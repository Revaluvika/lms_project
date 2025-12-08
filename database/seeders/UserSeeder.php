<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Users from DatabaseSeeder
            [
                'name' => 'Admin Kepala Sekolah',
                'email' => 'kepsek@learnflux.test',
                'password' => 'password', // Will be hashed below
                'role' => 'kepala_sekolah',
            ],
            [
                'name' => 'Guru Utama',
                'email' => 'guru@learnflux.test',
                'password' => 'password',
                'role' => 'guru',
            ],
            [
                'name' => 'Siswa Demo',
                'email' => 'siswa@learnflux.test',
                'password' => 'password',
                'role' => 'siswa',
            ],
            // Users originally in UserSeeder
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@example.com',
                'password' => 'password',
                'role' => 'kepala_sekolah'
            ],
            [
                'name' => 'Guru Sains',
                'email' => 'guru@example.com',
                'password' => 'password',
                'role' => 'guru'
            ],
            [
                'name' => 'Siswa Andi',
                'email' => 'siswa@example.com',
                'password' => 'password',
                'role' => 'siswa'
            ],
            [
                'name' => 'Orang Tua Andi',
                'email' => 'ortu@example.com',
                'password' => 'password',
                'role' => 'orang_tua'
            ],
            [
                'name' => 'Admin Dinas',
                'email' => 'dinas@example.com',
                'password' => 'password',
                'role' => 'dinas'
            ],
            [
                'name' => 'Administrator Dinas',
                'email' => 'admin.dinas@example.com',
                'password' => 'password',
                'role' => 'admin_dinas'
            ],
        ];

        foreach ($users as $userData) {
            // Check if user already exists to avoid duplicates if run multiple times
            if (User::where('email', $userData['email'])->exists()) {
                continue;
            }

            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => $userData['role'],
            ]);
        }
    }
}
