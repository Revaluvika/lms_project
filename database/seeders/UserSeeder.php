<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@example.com',
                'password' => Hash::make('password'),
                'role' => 'kepala_sekolah'
            ],
            [
                'name' => 'Guru Sains',
                'email' => 'guru@example.com',
                'password' => Hash::make('password'),
                'role' => 'guru'
            ],
            [
                'name' => 'Siswa Andi',
                'email' => 'siswa@example.com',
                'password' => Hash::make('password'),
                'role' => 'siswa'
            ],
            [
                'name' => 'Orang Tua Andi',
                'email' => 'ortu@example.com',
                'password' => Hash::make('password'),
                'role' => 'orang_tua'
            ],
            [
                'name' => 'Admin Dinas',
                'email' => 'dinas@example.com',
                'password' => Hash::make('password'),
                'role' => 'dinas'
            ],
        ]);
    }
}
