<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\SchoolStatus;

class DinasAdminController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $totalSekolah = \App\Models\School::count();
        $sekolahNegeri = \App\Models\School::where('ownership_status', 'Negeri')->count();
        $sekolahSwasta = \App\Models\School::where('ownership_status', 'Swasta')->count();
        
        $totalGuru = \App\Models\Teacher::count();
        $totalSiswa = \App\Models\Student::count();
        
        // Data Sekolah Menunggu Verifikasi
        $pendingSchools = \App\Models\School::where('status', SchoolStatus::PENDING)->count();

        // 5 Aktivitas Pendaftaran Terakhir
        $recentRegistrations = \App\Models\School::latest()
            ->take(5)
            ->get();

        // 2. Grafik Jumlah Sekolah Mendaftar (6 Bulan Terakhir)
        $schoolChartLabels = [];
        $schoolChartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');
            $schoolChartLabels[] = $monthName;
            
            $count = \App\Models\School::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $schoolChartData[] = $count;
        }

        // 3. Grafik Perkembangan Siswa (5 Tahun Terakhir)
        $studentChartLabels = [];
        $studentChartData = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $studentChartLabels[] = $year;
            
            // Cumulative count up to end of that year
            $count = \App\Models\Student::whereYear('created_at', '<=', $year)->count();
            $studentChartData[] = $count;
        }

        return view('dashboard.dinas.admin', compact(
            'totalSekolah', 
            'sekolahNegeri', 
            'sekolahSwasta', 
            'totalGuru', 
            'totalSiswa', 
            'pendingSchools',
            'recentRegistrations',
            'schoolChartLabels',
            'schoolChartData',
            'studentChartLabels',
            'studentChartData'
        ));
    }
}
