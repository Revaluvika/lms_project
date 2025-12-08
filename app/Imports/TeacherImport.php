<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use App\Enums\UserRole;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class TeacherImport implements ToModel, WithHeadingRow
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
            'role' => UserRole::GURU,
            'school_id' => auth()->user()->school_id,
        ]);

        // 2. Create Teacher linked to User
        return new Teacher([
            'user_id' => $user->id,
            'school_id' => auth()->user()->school_id,
            'nip' => $row['nip'],
            'specialization' => $row['mapel'], // Map 'mapel' column to 'specialization'
            'alamat' => $row['alamat'] ?? null,
            'telepon' => $row['telepon'] ?? null,
        ]);
    }
}
