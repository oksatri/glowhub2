<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mua;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('back.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User();
        return view('back.users.create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('users', 'public');
            $data['profile_image'] = $path;
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if ($user->role === 'mua') {
            Mua::create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('back.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('users', 'public');
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $data['profile_image'] = $path;
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $previousRole = $user->role;

        $user->update($data);

        if ($user->role === 'mua') {
            $mua = $user->mua()->first();

            if (! $mua) {
                Mua::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                ]);
            } else {
                $mua->update([
                    'name' => $user->name,
                ]);
            }
        } elseif ($previousRole === 'mua' && $user->role !== 'mua') {
            $user->mua()->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('back.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }
        if ($user->mua) {
            $user->mua()->delete();
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        $file = $request->file('excel_file');
        $filePath = $file->getPathname();
        $fileExtension = $file->getClientOriginalExtension();

        try {
            $importedCount = 0;
            $errors = [];

            if ($fileExtension === 'csv') {
                // Handle CSV file
                $handle = fopen($filePath, 'r');
                if ($handle === false) {
                    return redirect()->back()->with('error', 'Unable to open CSV file.');
                }

                $header = fgetcsv($handle); // Read header row
                $expectedHeader = ['name', 'username', 'email', 'phone', 'role', 'password'];
                
                // Check if header matches expected format
                if (!$this->validateHeader($header, $expectedHeader)) {
                    fclose($handle);
                    return redirect()->back()->with('error', 'Invalid CSV format. Expected columns: ' . implode(', ', $expectedHeader));
                }

                $rowNumber = 2; // Start from 2 (after header)
                while (($data = fgetcsv($handle)) !== false) {
                    $result = $this->processUserRow($data, $rowNumber);
                    if ($result['success']) {
                        $importedCount++;
                    } else {
                        $errors[] = "Row {$rowNumber}: " . $result['error'];
                    }
                    $rowNumber++;
                }
                fclose($handle);
            } else {
                // Handle Excel file using PHPExcel reader (simplified approach)
                // For now, we'll convert to CSV or use a simple approach
                return redirect()->back()->with('error', 'For Excel files (.xlsx, .xls), please convert to CSV format first. CSV import is fully supported.');
            }

            $message = "Import completed. {$importedCount} users imported successfully.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " errors occurred.";
                session(['import_errors' => $errors]);
            }

            return redirect()->route('admin.users.index')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    private function validateHeader($header, $expectedHeader)
    {
        if (count($header) < 3) return false; // At least name, username, email required
        
        // Normalize header (lowercase, trim spaces)
        $normalizedHeader = array_map(function($item) {
            return strtolower(trim(str_replace(' ', '', $item)));
        }, $header);

        // Check required columns exist
        $requiredColumns = ['name', 'username', 'email'];
        foreach ($requiredColumns as $column) {
            if (!in_array($column, $normalizedHeader)) {
                return false;
            }
        }

        return true;
    }

    public function downloadTemplate()
    {
        $filename = "users_import_template.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding
            fwrite($file, "\xEF\xBB\xBF");
            
            // CSV Header
            fputcsv($file, ['name', 'username', 'email', 'phone', 'role', 'password']);
            
            // Sample data rows
            fputcsv($file, ['John Doe', 'johndoe', 'john@example.com', '08123456789', 'member', 'password123']);
            fputcsv($file, ['Jane Smith', 'janesmith', 'jane@example.com', '08234567890', 'mua', 'password456']);
            fputcsv($file, 'Admin User', 'adminuser', 'admin@example.com', '08345678901', 'admin', 'admin789');
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function processUserRow($data, $rowNumber)
    {
        try {
            // Expected order: name, username, email, phone, role, password
            $name = trim($data[0] ?? '');
            $username = trim($data[1] ?? '');
            $email = trim($data[2] ?? '');
            $phone = trim($data[3] ?? '');
            $role = trim($data[4] ?? 'member');
            $password = trim($data[5] ?? '');

            // Validate required fields
            if (empty($name) || empty($username) || empty($email)) {
                return ['success' => false, 'error' => 'Name, username, and email are required'];
            }

            // Check if username already exists
            if (User::where('username', $username)->exists()) {
                return ['success' => false, 'error' => 'Username already exists'];
            }

            // Check if email already exists
            if (User::where('email', $email)->exists()) {
                return ['success' => false, 'error' => 'Email already exists'];
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email format'];
            }

            // Validate role
            $validRoles = ['admin', 'mua', 'member'];
            if (!in_array($role, $validRoles)) {
                $role = 'member'; // Default to member if invalid
            }

            // Generate password if not provided
            if (empty($password)) {
                $password = 'password123'; // Default password
            }

            // Create user
            $userData = [
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'phone' => $phone ?: null,
                'role' => $role,
                'password' => Hash::make($password),
            ];

            $user = User::create($userData);

            // Create MUA record if role is mua
            if ($role === 'mua') {
                Mua::create([
                    'user_id' => $user->id,
                    'name' => $name,
                ]);
            }

            return ['success' => true];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
