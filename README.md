# 🎓 Sistem Manajemen Pembelajaran (LMS) Terintegrasi

LMS ini adalah platform pendidikan komprehensif yang dirancang untuk menghubungkan **Dinas Pendidikan**, **Sekolah**, **Guru**, **Siswa**, dan **Orang Tua** dalam satu ekosistem terpadu. Sistem ini memfasilitasi manajemen sekolah, kegiatan belajar mengajar (KBM), pelaporan, dan pemantauan akademik secara _real-time_.

## 🌟 Fitur Utama

Sistem ini dibangun dengan konsep **Multi-Role** dan **Multi-Tenant (School-based)**:

-   **🏢 Dinas Pendidikan**: Dashboard eksekutif untuk memantau statistik seluruh sekolah, validasi laporan sekolah, dan manajemen perizinan.
-   **🏫 Manajemen Sekolah**: Pengelolaan data master (Guru, Siswa, Kelas, Mapel), pengaturan kurikulum, dan kalender akademik.
-   **👨‍🏫 Portal Guru**: Manajemen kelas, absensi, materi, tugas, ujian online (CBT), dan input nilai (E-Rapor).
-   **👨‍🎓 Portal Siswa**: Akses jadwal, materi pelajaran, pengerjaan tugas & ujian, serta melihat hasil belajar.
-   **👨‍👩‍👧‍👦 Portal Orang Tua**: Pemantauan kehadiran, nilai, dan jadwal anak secara langsung.

## 🛠️ Teknologi yang Digunakan

-   **Framework**: [Laravel 10.x](https://laravel.com)
-   **Database**: MySQL / MariaDB
-   **Frontend**: Blade Templates dengan [Tailwind CSS](https://tailwindcss.com) & [Alpine.js](https://alpinejs.dev)
-   **Icons**: FontAwesome / Heroicons

## 🚀 Cara Instalasi & Menjalankan (Local)

Pastikan **PHP** (minimal 8.3), **Composer**, **Node.js**, dan **MySQL** sudah terinstal di komputer Anda.

1.  **Clone Repository**

    ```bash
    git clone https://github.com/Mariatiara/lms_project.git
    cd lms_project
    ```

2.  **Instalasi Dependencies (Backend)**

    ```bash
    composer install
    ```

3.  **Setup Environment**
    Salin file konfigurasi `.env`.

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan koneksi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4.  **Generate Key & Migrasi Database**

    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    # --seed akan mengisi data dummy untuk Sekolah, Guru, Siswa, dll.
    ```

5.  **Instalasi Dependencies & Build Assets (Frontend)**

    ```bash
    npm install
    npm run dev
    ```

6.  **Jalankan Aplikasi**
    Buka terminal baru untuk menjalankan server lokal Laravel:

    ```bash
    php artisan serve
    ```

    Aplikasi dapat diakses di: `http://localhost:8000`

## 📚 Dokumentasi Lengkap

Kami menyediakan dokumentasi terperinci untuk pengembang dan pengguna:

-   **📖 [Dokumentasi Fitur & Hak Akses](docs/features.md)**: Penjelasan mendalam tentang apa yang bisa dilakukan oleh setiap role.
-   **🗄️ [Struktur Database](docs/database.md)**: Skema tabel, tipe data, dan relasi antar entitas (ERD).
-   **🚀 [Alur Kerja (Workflows)](.agent/workflows)**: Panduan langkah-demi-langkah untuk tugas pengembangan umum.

## 📂 Struktur Folder Penting

-   `app/Models`: Model Eloquent untuk entitas database.
-   `app/Http/Controllers`: Logika bisnis aplikasi, dikelompokkan dalam folder `Dashboard` berdasarkan role.
-   `resources/views`: Tampilan antarmuka (Blade), terbagi menjadi `auth`, `dashboard` (dinas/sekolah), dan `pages` (guru/siswa).
-   `routes/web.php`: Definisi rute aplikasi, dikelompokkan dengan rapi berdasarkan role dan middleware.

## 👥 Akun Demo (Seeder Default)

Jika menjalankan `migrate:fresh --seed`, gunakan akun berikut untuk login:

| Role                 | Email                         | Password   |
| :------------------- | :---------------------------- | :--------- |
| **Dinas Pendidikan** | `dinas@example.com`           | `password` |
| **Admin Sekolah**    | `admin.sekolah@example.com`   | `password` |
| **Kepala Sekolah**   | `kepsek@example.com`          | `password` |
| **Guru**             | `guru.matematika@example.com` | `password` |
| **Siswa**            | `siswa.1@example.com`         | `password` |
| **Orang Tua**        | `orangtua.1@example.com`      | `password` |

---

_Dibuat oleh Tim Pengembang LMS Project_
