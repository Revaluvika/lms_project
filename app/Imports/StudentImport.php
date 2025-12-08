<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use App\Enums\UserRole;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. Create User
        $user = User::create([
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make('password'), // Default password
            'role' => UserRole::SISWA,
            'school_id' => auth()->user()->school_id,
        ]);

        // 2. Find Classroom
        $classroom = \App\Models\Classroom::where('school_id', auth()->user()->school_id)
            ->where('name', $row['kelas'])
            ->first();

        // 3. Create Student linked to User
        return new Student([
            'user_id' => $user->id,
            'school_id' => auth()->user()->school_id,
            'classroom_id' => $classroom ? $classroom->id : null,
            'nama' => $row['nama'],
            'nis' => $row['nis'],
            'alamat' => $row['alamat'] ?? null,
            'telepon' => $row['telepon'] ?? null,
        ]);
    }
}
