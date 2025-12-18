# 📖 Dokumentasi Fitur & Hak Akses LMS

Dokumen ini menjelaskan secara rinci fitur-fitur yang tersedia dalam Sistem Manajemen Pembelajaran (LMS) berdasarkan peran pengguna (_User Role_).

---

## 1. 🏢 Dinas Pendidikan (Role: `dinas`, `admin_dinas`)

Dinas Pendidikan memiliki peran pengawasan (supervisory) terhadap sekolah-sekolah di wilayahnya.

### 🔹 Dashboard Eksekutif

-   **Statistik Makro**: Melihat total jumlah sekolah (L/P, Negeri/Swasta), total guru, dan total siswa.
-   **Grafik Pertumbuhan**: Visualisasi tren pendaftar sekolah baru dan pertumbuhan siswa dalam 5 tahun terakhir.
-   **Status Pelaporan**: Memantau berapa banyak sekolah yang sudah mengirimkan laporan periodik bulan ini.

### 🔹 Manajemen Sekolah

-   **Validasi Sekolah Baru**: Menyetujui atau menolak pendaftaran akun sekolah baru.
-   **Monitoring Sekolah**: Melihat profil detail setiap sekolah, termasuk data guru dan siswa.
-   **Kontrol Akses**: Membekukan (_suspend_) atau mengaktifkan kembali akses sekolah jika diperlukan.

### 🔹 E-Reporting (Pelaporan)

-   **Inbox Laporan**: Menerima laporan bulanan/semesteran yang dikirim oleh Kepala Sekolah.
-   **Review & Feedback**:
    -   Melihat preview dokumen laporan (PDF/Docx) secara langsung.
    -   Memberikan status: _Accepted_, _Rejected_, atau _Revision Needed_.
    -   Memberikan catatan revisi (_feedback_) yang akan muncul di dashboard Kepala Sekolah.
-   **Arsip Laporan**: Melihat riwayat laporan yang sudah diselesai diproses.

---

## 2. 🏫 Manajemen Sekolah (Role: `admin_sekolah`, `kepala_sekolah`)

Mengelola operasional harian sekolah dan data master.

### 🔹 Admin Sekolah

-   **Master Data**:
    -   **Tahun Ajaran**: Mengatur tahun ajaran aktif (Ganjil/Genap).
    -   **Kelas (Rombel)**: Membuat kelas dan menunjuk Wali Kelas.
    -   **Mata Pelajaran**: Daftar mapel dan KKM (Kriteria Ketuntasan Minimal).
    -   **Guru & Siswa**: Import data massal (Excel) atau input manual, reset password pengguna.
-   **Kurikulum & Penjadwalan**:
    -   **Pengajaran (Courses)**: Menentukan "Guru A mengajar Mapel B di Kelas C".
    -   **Jadwal Pelajaran**: Mengatur jadwal mingguan (plot jam dan mata pelajaran).
    -   **Pengaturan Jam Sekolah**: Mengatur durasi jam pelajaran dan istirahat.
-   **Bobot Nilai**: Mengatur persentase bobot nilai Harian, UTS, dan UAS untuk kalkulasi rapor.

### 🔹 Kepala Sekolah

-   **Supervisi**: Melihat ringkasan statistik sekolah (kehadiran, nilai rata-rata).
-   **Pelaporan ke Dinas**:
    -   Mengunggah dokumen laporan sekolah (Bulanan/Semester).
    -   Memantau status validasi dari Dinas.
    -   Melakukan revisi laporan jika diminta (upload ulang file baru).

---

## 3. 👨‍🏫 Guru (Role: `guru`)

Fasilitator pembelajaran yang berinteraksi langsung dengan siswa.

### 🔹 Kegiatan Belajar Mengajar (KBM)

-   **Manajemen Materi**: Upload materi pelajaran (PDF, PPT, Link Video) untuk kelas yang diampu.
-   **Manajemen Tugas**: Membuat tugas dengan tenggat waktu (_deadline_).
-   **Input Nilai (Gradebook)**:
    -   Menilai tugas siswa.
    -   Menginput nilai manual (Harian, UTS, UAS) ke buku nilai.
-   **Presensi Kelas**: Mencatat kehadiran siswa (Hadir, Sakit, Izin, Alpha) pada setiap sesi pelajaran.

### 🔹 Ujian Online (CBT)

-   **Bank Soal**: Membuat soal Pilihan Ganda atau Essay.
-   **Publikasi Ujian**: Menjadwalkan ujian (tanggal, durasi) untuk kelas tertentu.
-   **Monitoring**: Melihat hasil ujian siswa dan analisis jawaban.
-   **Koreksi Essay**: Memberikan nilai untuk soal isian/essay secara manual.

### 🔹 Wali Kelas (Tugas Tambahan)

Jika guru ditunjuk sebagai Wali Kelas:

-   **Dashboard Wali Kelas**: Ringkasan kondisi kelas perwaliannya.
-   **Leger Nilai**: Melihat rekap nilai seluruh mapel siswa di kelasnya.
-   **Rapor Semester**:
    -   Menginput catatan akademik, prestasi, dan ekstrakurikuler.
    -   Mencetak/Generate PDF Rapor Siswa.
-   **Kenaikan Kelas**: Memproses status kenaikan kelas siswa di akhir tahun ajaran.

---

## 4. 👨‍🎓 Siswa (Role: `siswa`)

Peserta didik yang mengakses materi dan evaluasi.

-   **Dashboard Siswa**: Melihat jadwal hari ini, tugas yang belum dikumpulkan, dan pengumuman sekolah.
-   **Akses Materi**: Mengunduh atau membaca materi yang dibagikan guru.
-   **Tugas & Ujian**:
    -   Mengumpulkan tugas (upload file).
    -   Mengerjakan ujian online (CBT) dengan timer.
-   **Hasil Belajar**:
    -   Melihat nilai tugas dan ujian harian.
    -   Melihat rekap kehadiran sendiri.
-   **Profil**: Mengelola data diri dasar.

---

## 5. 👨‍👩‍👧‍👦 Orang Tua (Role: `orang_tua`)

Pendamping yang memantau perkembangan anak.

-   **Multi-Anak**: Satu akun orang tua dapat memantau lebih dari satu anak (jika bersekolah di tempat yang sama).
-   **Monitoring Real-time**:
    -   **Jadwal**: Melihat jadwal pelajaran anak.
    -   **Absensi**: Menerima status kehadiran anak di sekolah hari ini.
    -   **Nilai**: Memantau perolehan nilai tugas dan ujian anak.

---

_Dokumentasi ini diperbarui terakhir pada: Desember 2025_
