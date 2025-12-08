@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin Dinas</h1>
        <p class="text-gray-500 font-light">Panel Administrasi & Verifikasi Sekolah</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1: Sekolah --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Sekolah</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSekolah }}</h2>
                    <div class="mt-2 text-sm text-gray-600 space-y-1">
                        <div class="flex justify-between w-full gap-4">
                            <span>Negeri:</span>
                            <span class="font-semibold">{{ $sekolahNegeri }}</span>
                        </div>
                        <div class="flex justify-between w-full gap-4">
                            <span>Swasta:</span>
                            <span class="font-semibold">{{ $sekolahSwasta }}</span>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    @include('components.icons.dashboard-dinas')
                </div>
            </div>
        </div>

        {{-- Card 2: Guru --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Guru</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalGuru }}</h2>
                    <p class="text-xs text-gray-400 mt-2">Terdaftar di sistem</p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 3: Siswa --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Siswa</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSiswa }}</h2>
                    <p class="text-xs text-gray-400 mt-2">Terdaftar di sistem</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 4: Menunggu Verifikasi --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menunggu Verifikasi</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingSchools }}</h2>
                    <p class="text-xs text-red-600 font-medium mt-2">Sekolah Baru</p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Chart 1 --}}
        <div class="bg-white shadow-sm rounded-xl p-6">
            <h3 class="font-bold text-gray-700 mb-4">Pendaftar Sekolah (6 Bulan Terakhir)</h3>
            <div class="relative h-72 w-full">
                <canvas id="schoolGrowthChart"></canvas>
            </div>
        </div>
        {{-- Chart 2 --}}
        <div class="bg-white shadow-sm rounded-xl p-6">
            <h3 class="font-bold text-gray-700 mb-4">Tren Perkembangan Siswa (5 Tahun)</h3>
            <div class="relative h-72 w-full">
                <canvas id="studentGrowthChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Activities --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="font-semibold text-gray-700">Aktivitas Pendaftaran Sekolah Terbaru</h3>
            </div>
            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenjang & Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentRegistrations as $school)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase">
                                        {{ substr($school->name, 0, 2) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $school->name }}</div>
                                    <div class="text-xs text-gray-500">NPSN: {{ $school->npsn }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $school->education_level }}</div>
                            <span class="inline-flex text-xs leading-5 font-semibold text-gray-500">
                                {{ $school->ownership_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $school->district }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $school->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($school->status->value === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ ucfirst($school->status->value) }}
                                </span>
                            @elseif($school->status->value === 'active')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($school->status->value) }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($school->status->value) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Belum ada aktivitas pendaftaran sekolah baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Scripts --}}
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

<script>
    // Data from Controller
    const schoolLabels = @json($schoolChartLabels);
    const schoolData = @json($schoolChartData);
    
    const studentLabels = @json($studentChartLabels);
    const studentData = @json($studentChartData);

    // Chart 1: School Growth (Bar)
    const ctxSchool = document.getElementById('schoolGrowthChart').getContext('2d');
    new Chart(ctxSchool, {
        type: 'bar',
        data: {
            labels: schoolLabels,
            datasets: [{
                label: 'Pendaftaran Sekolah',
                data: schoolData,
                backgroundColor: 'rgba(59, 130, 246, 0.6)', 
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // Chart 2: Student Growth (Line)
    const ctxStudent = document.getElementById('studentGrowthChart').getContext('2d');
    new Chart(ctxStudent, {
        type: 'line',
        data: {
            labels: studentLabels,
            datasets: [{
                label: 'Pertumbuhan Siswa',
                data: studentData,
                backgroundColor: 'rgba(16, 185, 129, 0.2)', 
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
