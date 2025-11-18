<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalLaporan = Report::count();

        return view('dashboard.index', compact('totalGuru', 'totalSiswa', 'totalLaporan'));
    }

    public function kepsek()
    {
        $laporanBaru = Report::where('status', 'Menunggu')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('dashboard.kepala-sekolah', compact('laporanBaru', 'totalGuru', 'totalSiswa'));
    }

    public function guru()
    {
        $laporanSaya = Report::where('status', 'Diproses')->count();
        return view('dashboard.guru', compact('laporanSaya'));
    }

    public function siswa()
    {
        $riwayatLaporan = Report::latest()->take(5)->get();
        return view('dashboard.siswa', compact('riwayatLaporan'));
    }

    public function orangtua()
    {
        $progressAnak = 85; // contoh statis, bisa dari tabel nilai
        return view('dashboard.orang-tua', compact('progressAnak'));
    }

    public function dinas()
    {
        $totalSekolah = 5; // contoh statis
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('dashboard.dinas', compact('totalSekolah', 'totalGuru', 'totalSiswa'));
    }
}
