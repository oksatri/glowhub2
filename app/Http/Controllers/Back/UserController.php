<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mua;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Import users from Excel file
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('excel_file');

            Excel::import(new UsersImport, $file);

            return redirect()->route('admin.users.index')
                ->with('success', 'Users imported successfully!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessage = 'Import failed with validation errors:<br><br>';
            foreach ($failures as $failure) {
                $errorMessage .= "Row {$failure->row()}: " . implode(', ', $failure->errors()) . "<br>";
            }

            return redirect()->route('admin.users.index')
                ->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Download sample Excel template
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/users_import_template.xlsx');

        if (!file_exists($filePath)) {
            // Create template if it doesn't exist
            $this->createTemplateFile();
        }

        return response()->download($filePath, 'users_import_template.xlsx');
    }

    /**
     * Create Excel template file
     */
    private function createTemplateFile()
    {
        $templatePath = public_path('templates');
        if (!is_dir($templatePath)) {
            mkdir($templatePath, 0755, true);
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['name', 'username', 'email', 'password', 'role', 'whatsapp', 'address', 'biodata'];
        $sheet->fromArray($headers, null, 'A1');

        // Add sample data
        $sampleData = [
            'John Doe',
            'johndoe',
            'john@example.com',
            'password123',
            'user',
            '+628123456789',
            'Jakarta, Indonesia',
            'Experienced makeup artist'
        ];
        $sheet->fromArray($sampleData, null, 'A2');

        // Style the header row
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:H1')->getFill()->getStartColor()->setRGB('E3F2FD');

        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($templatePath . '/users_import_template.xlsx');

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
    }
}
