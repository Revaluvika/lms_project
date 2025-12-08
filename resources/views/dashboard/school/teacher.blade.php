@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Guru</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Kartu Jumlah Siswa --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.data-siswa')
            <div>
                <h2 class="font-bold text-xl">340</h2>
                <p class="text-gray-500">Jumlah Siswa</p>
            </div>
        </div>

        {{-- Jadwal Minggu Ini --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.jadwal')
            <div>
                <h2 class="font-bold text-xl">12 Kelas</h2>
                <p class="text-gray-500">Jadwal Minggu Ini</p>
            </div>
        </div>

        {{-- Laporan Kegiatan --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.laporan')
            <div>
                <h2 class="font-bold text-xl">5</h2>
                <p class="text-gray-500">Laporan Baru</p>
            </div>
        </div>

    </div>
</div>
@endsection
