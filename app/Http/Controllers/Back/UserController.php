<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mua;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
        // Prioritize paths based on hosting structure (public_html folder)
        $possiblePaths = [
            public_path('templates/users_import_template.xlsx'), // Standard Laravel (../public_html)
            base_path('public/templates/users_import_template.xlsx'), // Public in same directory
            base_path('../public/templates/users_import_template.xlsx'), // Public in parent directory
            dirname(public_path()) . '/templates/users_import_template.xlsx', // Alternative
        ];

        $excelPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path) && filesize($path) > 1000) {
                $excelPath = $path;
                break;
            }
        }

        // CSV paths with same priority
        $csvPaths = [
            public_path('templates/users_import_template.csv'),
            base_path('public/templates/users_import_template.csv'),
            base_path('../public/templates/users_import_template.csv'),
            dirname(public_path()) . '/templates/users_import_template.csv',
        ];

        $csvPath = null;
        foreach ($csvPaths as $path) {
            if (file_exists($path)) {
                $csvPath = $path;
                break;
            }
        }

        // Try to create Excel template if not found
        if (!$excelPath) {
            try {
                $this->createTemplateFile();
                // Check again after creation
                foreach ($possiblePaths as $path) {
                    if (file_exists($path) && filesize($path) > 1000) {
                        $excelPath = $path;
                        break;
                    }
                }
            } catch (\Exception $e) {
                // Fallback to CSV if Excel creation fails
                if ($csvPath) {
                    return response()->download($csvPath, 'users_import_template.csv');
                }
                // Create simple CSV if neither exists
                $this->createSimpleCsvTemplate();
                return response()->download($csvPath, 'users_import_template.csv');
            }
        }

        // Return Excel if found and valid
        if ($excelPath) {
            return response()->download($excelPath, 'users_import_template.xlsx');
        }

        // Fallback to CSV
        if (!$csvPath) {
            $this->createSimpleCsvTemplate();
            // Find the created CSV
            foreach ($csvPaths as $path) {
                if (file_exists($path)) {
                    $csvPath = $path;
                    break;
                }
            }
        }

        return response()->download($csvPath, 'users_import_template.csv');
    }

    /**
     * Create simple CSV template
     */
    private function createSimpleCsvTemplate()
    {
        // Prioritize same paths as downloadTemplate
        $possibleDirs = [
            public_path('templates'), // Standard Laravel (../public_html)
            base_path('public/templates'), // Public in same directory
            base_path('../public/templates'), // Public in parent directory
            dirname(public_path()) . '/templates', // Alternative
        ];

        $templatePath = null;
        foreach ($possibleDirs as $dir) {
            if (!is_dir($dir)) {
                try {
                    mkdir($dir, 0755, true);
                } catch (\Exception $e) {
                    continue; // Try next directory
                }
            }
            if (is_writable($dir)) {
                $templatePath = $dir;
                break;
            }
        }

        // Fallback to system temp if no directory is writable
        if (!$templatePath) {
            $templatePath = sys_get_temp_dir();
        }

        $csvContent = "name,username,email,password,role,whatsapp,address,biodata\n";
        $csvContent .= "John Doe,johndoe123,john.doe@example.com,password123,user,+6281234567890,\"Jakarta Selatan, DKI Jakarta\",\"Regular user interested in makeup services\"\n";
        $csvContent .= "Sarah Anderson,sarahmua,sarah.anderson@example.com,makeup2024,mua,+6282234567890,\"Bandung, Jawa Barat\",\"Professional makeup artist with 5 years experience\"\n";
        $csvContent .= "Admin User,admin01,admin@glowhub.com,adminpass123,admin,+6283234567890,\"Jakarta Pusat, DKI Jakarta\",\"System administrator for managing platform\"\n";

        file_put_contents($templatePath . '/users_import_template.csv', $csvContent);
    }

    /**
     * Create Excel template file
     */
    private function createTemplateFile()
    {
        // Prioritize same paths as downloadTemplate
        $possibleDirs = [
            public_path('templates'), // Standard Laravel (../public_html)
            base_path('public/templates'), // Public in same directory
            base_path('../public/templates'), // Public in parent directory
            dirname(public_path()) . '/templates', // Alternative
        ];

        $templatePath = null;
        foreach ($possibleDirs as $dir) {
            if (!is_dir($dir)) {
                try {
                    mkdir($dir, 0755, true);
                } catch (\Exception $e) {
                    continue; // Try next directory
                }
            }
            if (is_writable($dir)) {
                $templatePath = $dir;
                break;
            }
        }

        // Fallback to system temp if no directory is writable
        if (!$templatePath) {
            $templatePath = sys_get_temp_dir();
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Users Import Template');

        // Set headers
        $headers = ['name', 'username', 'email', 'password', 'role', 'whatsapp', 'address', 'biodata'];
        $sheet->fromArray($headers, null, 'A1');

        // Add sample data with realistic examples
        $sampleData = [
            // Row 2 - Regular User
            [
                'John Doe',
                'johndoe123',
                'john.doe@example.com',
                'password123',
                'user',
                '+6281234567890',
                'Jakarta Selatan, DKI Jakarta',
                'Regular user interested in makeup services'
            ],
            // Row 3 - MUA User
            [
                'Sarah Anderson',
                'sarahmua',
                'sarah.anderson@example.com',
                'makeup2024',
                'mua',
                '+6282234567890',
                'Bandung, Jawa Barat',
                'Professional makeup artist with 5 years experience in bridal and party makeup'
            ],
            // Row 4 - Admin User
            [
                'Admin User',
                'admin01',
                'admin@glowhub.com',
                'adminpass123',
                'admin',
                '+6283234567890',
                'Jakarta Pusat, DKI Jakarta',
                'System administrator for managing platform'
            ]
        ];

        // Insert sample data starting from row 2
        $sheet->fromArray($sampleData, null, 'A2');

        // Style the header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Style the data rows
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB']
                ]
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $sheet->getStyle('A1:H4')->applyFromArray($dataStyle);

        // Set column widths
        $columnWidths = [
            'A' => 25, // name
            'B' => 20, // username
            'C' => 30, // email
            'D' => 15, // password
            'E' => 12, // role
            'F' => 20, // whatsapp
            'G' => 35, // address
            'H' => 50  // biodata
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Add instructions at the top
        $sheet->insertNewRowBefore(1, 5);

        // Instruction text
        $instructions = [
            'USERS IMPORT TEMPLATE - INSTRUCTIONS:',
            '',
            'REQUIRED FIELDS: name, username, email | OPTIONAL: password, role, whatsapp, address, biodata',
            'ROLE OPTIONS: user, mua, admin | DEFAULT: password="password123", role="user"',
            'IMPORTANT: Delete rows 1-5 before importing. After deletion, header row becomes row 1.'
        ];

        $sheet->fromArray($instructions, null, 'A1');

        // Style instructions
        $instructionStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'DC2626']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FEF2F2']
            ]
        ];
        $sheet->getStyle('A1:A5')->applyFromArray($instructionStyle);

        // Merge instruction cells (but keep them readable)
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');
        $sheet->mergeCells('A4:H4');
        $sheet->mergeCells('A5:H5');

        // Style header row (now row 6)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB']
                ]
            ]
        ];
        $sheet->getStyle('A6:H6')->applyFromArray($headerStyle);

        // Save the file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($templatePath . '/users_import_template.xlsx');

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
    }
}
