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

    public function getStudentGrowthData(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $labels = [];
        $data = [];
        $level = 'year'; // default
        $title = 'Tren Perkembangan Siswa (5 Tahun Terakhir)';

        if ($year && $month) {
            // Level: Date (Daily data for specific month)
            $level = 'date';
            $daysInMonth = \Carbon\Carbon::createFromDate($year, $month, 1)->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = \Carbon\Carbon::createFromDate($year, $month, $day);
                $labels[] = $date->format('d M');
                
                // Cumulative count up to that day
                $count = \App\Models\Student::whereDate('created_at', '<=', $date)->count();
                $data[] = $count;
            }
            $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y');
            $title = "Tren Perkembangan Siswa ({$monthName})";

        } elseif ($year) {
            // Level: Month (Monthly data for specific year)
            $level = 'month';
            
            for ($m = 1; $m <= 12; $m++) {
                $date = \Carbon\Carbon::createFromDate($year, $m, 1);
                $labels[] = $date->format('M');
                
                // Cumulative count up to end of that month
                $count = \App\Models\Student::whereYear('created_at', '<', $year)
                    ->orWhere(function($query) use ($year, $m) {
                        $query->whereYear('created_at', $year)
                              ->whereMonth('created_at', '<=', $m);
                    })->count();
                $data[] = $count;
            }
            $title = "Tren Perkembangan Siswa ({$year})";

        } else {
            // Level: Year (Default 5 years)
            $level = 'year';
            for ($i = 4; $i >= 0; $i--) {
                $y = now()->subYears($i)->year;
                $labels[] = (string)$y;
                
                // Cumulative count up to end of that year
                $count = \App\Models\Student::whereYear('created_at', '<=', $y)->count();
                $data[] = $count;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'level' => $level,
            'title' => $title
        ]);
    }
}
