@extends('layouts.dashboard')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="px-6 py-8">
    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard Wali Kelas</h1>
            <p class="text-slate-500 mt-1">Kelas: {{ $classroom->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Jumlah Siswa Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <div class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">
                        Jumlah Siswa</div>
                    <div class="text-2xl font-bold text-slate-800">{{ $classroom->students()->count() }}</div>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        </div>

        <!-- Absensi Harian Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <div class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">
                        Hadir Hari Ini</div>
                    <div class="text-2xl font-bold text-slate-800">-</div>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
             <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h6 class="font-semibold text-slate-800">Menu Wali Kelas</h6>
            </div>
            <div class="divide-y divide-slate-100">
                <a href="{{ route('homeroom.students.index') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-slate-900">Manajemen Anggota Kelas</h4>
                        <p class="text-sm text-slate-500">Lihat daftar siswa, kontak orang tua, dan promosi.</p>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 ml-auto group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                
                <a href="{{ route('homeroom.leger.index') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-slate-900">Monitoring Akademik (Leger)</h4>
                        <p class="text-sm text-slate-500">Lihat rekap nilai siswa seluruh mata pelajaran.</p>
                    </div>
                     <svg class="w-5 h-5 text-slate-400 ml-auto group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('homeroom.report.index') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-slate-900">Manajemen Rapor</h4>
                        <p class="text-sm text-slate-500">Input catatan, ekstrakurikuler, dan cetak rapor.</p>
                    </div>
                     <svg class="w-5 h-5 text-slate-400 ml-auto group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
