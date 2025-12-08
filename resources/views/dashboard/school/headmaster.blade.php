@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Kepala Sekolah</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Data Guru --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.data-guru')
            <div>
                <h2 class="text-xl font-bold">25</h2>
                <p class="text-gray-500">Total Guru</p>
            </div>
        </div>

        {{-- Data Siswa --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.data-siswa')
            <div>
                <h2 class="text-xl font-bold">340</h2>
                <p class="text-gray-500">Jumlah Siswa</p>
            </div>
        </div>

        {{-- Laporan Sekolah --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.laporan')
            <div>
                <h2 class="text-xl font-bold">12</h2>
                <p class="text-gray-500">Laporan Baru</p>
            </div>
        </div>
    </div>
</div>
@endsection
