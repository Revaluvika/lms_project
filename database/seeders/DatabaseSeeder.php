use App\Models\User;

public function run(): void
{
    User::create([
        'name' => 'Admin Kepala Sekolah',
        'email' => 'kepsek@learnflux.test',
        'password' => bcrypt('password'),
        'role' => 'kepala-sekolah',
    ]);

    User::create([
        'name' => 'Guru Utama',
        'email' => 'guru@learnflux.test',
        'password' => bcrypt('password'),
        'role' => 'guru',
    ]);

    User::create([
        'name' => 'Siswa Demo',
        'email' => 'siswa@learnflux.test',
        'password' => bcrypt('password'),
        'role' => 'siswa',
    ]);
    { 
        $this->call(UserSeeder::class);
    }
}
