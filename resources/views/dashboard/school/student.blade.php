@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Siswa</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Nilai --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.nilai')
            <div>
                <h2 class="font-bold text-xl">87%</h2>
                <p class="text-gray-500">Rata-rata Nilai</p>
            </div>
        </div>

        {{-- Jadwal --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.jadwal')
            <div>
                <h2 class="font-bold text-xl">Hari Ini</h2>
                <p class="text-gray-500">3 Mata Pelajaran</p>
            </div>
        </div>

        {{-- Pengumuman --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.notifikasi')
            <div>
                <h2 class="font-bold text-xl">2</h2>
                <p class="text-gray-500">Pengumuman Baru</p>
            </div>
        </div>

    </div>
</div>
@endsection
@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Siswa</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Nilai --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.nilai')
            <div>
                <h2 class="font-bold text-xl">87%</h2>
                <p class="text-gray-500">Rata-rata Nilai</p>
            </div>
        </div>

        {{-- Jadwal --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.jadwal')
            <div>
                <h2 class="font-bold text-xl">Hari Ini</h2>
                <p class="text-gray-500">3 Mata Pelajaran</p>
            </div>
        </div>

        {{-- Pengumuman --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.notifikasi')
            <div>
                <h2 class="font-bold text-xl">2</h2>
                <p class="text-gray-500">Pengumuman Baru</p>
            </div>
        </div>

    </div>
</div>
@endsection
