<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
     * Specify the heading row (row 6 after removing instruction rows 1-5)
     */
    public function headingRow(): int
    {
        return 1; // After deleting rows 1-5, header becomes row 1
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password123'), // Default password if not provided
            'role' => $row['role'] ?? 'user', // Default role if not provided
            'whatsapp' => $row['whatsapp'] ?? null,
            'address' => $row['address'] ?? null,
            'biodata' => $row['biodata'] ?? null,
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'role' => 'nullable|string|in:admin,mua,user',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'biodata' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Name field is required.',
            'username.required' => 'Username field is required.',
            'username.unique' => 'Username has already been taken.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email has already been taken.',
            'role.in' => 'Role must be one of: admin, mua, user.',
        ];
    }

    /**
     * Batch size for inserts
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size for reading
     */
    public function chunkSize(): int
    {
        return 100;
    }
}
