<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            UserRole::DINAS => redirect()->route('dashboard.dinas'),
            UserRole::ADMIN_DINAS => redirect()->route('dashboard.dinas.admin'),
            UserRole::KEPALA_SEKOLAH => redirect()->route('dashboard.headmaster'),
            UserRole::ADMIN_SEKOLAH => redirect()->route('dashboard.school.admin'),
            UserRole::GURU => redirect()->route('dashboard.teacher'),
            UserRole::SISWA => redirect()->route('dashboard.student'),
            default => abort(403, 'Unauthorized action.'),
        };
    }
    
    // public function index()
    // {
    //     $totalGuru = User::where('role', 'guru')->count();
    //     $totalSiswa = User::where('role', 'siswa')->count();
    //     $totalLaporan = Report::count();

    //     return view('dashboard.index', compact('totalGuru', 'totalSiswa', 'totalLaporan'));
    // }

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
