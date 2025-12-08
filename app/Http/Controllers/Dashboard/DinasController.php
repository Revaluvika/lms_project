<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DinasController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $totalSekolah = \App\Models\School::count();
        $sekolahNegeri = \App\Models\School::where('ownership_status', 'Negeri')->count();
        $sekolahSwasta = \App\Models\School::where('ownership_status', 'Swasta')->count();
        
        $totalGuru = \App\Models\Teacher::count();
        $totalSiswa = \App\Models\Student::count();
        
        $laporanBulanIni = \App\Models\SchoolReport::whereYear('report_period', now()->year)
            ->whereMonth('report_period', now()->month)
            ->count();

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

        // 3. Grafik Perkembangan Siswa (5 Tahun Terakhir) - Cumulative status
        $studentChartLabels = [];
        $studentChartData = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $studentChartLabels[] = $year;
            
            // Cumulative count up to end of that year
            $count = \App\Models\Student::whereYear('created_at', '<=', $year)->count();
            $studentChartData[] = $count;
        }

        return view('dashboard.dinas.executive-summary', compact(
            'totalSekolah', 
            'sekolahNegeri', 
            'sekolahSwasta', 
            'totalGuru', 
            'totalSiswa', 
            'laporanBulanIni',
            'schoolChartLabels',
            'schoolChartData',
            'studentChartLabels',
            'studentChartData'
        ));
    }
}
