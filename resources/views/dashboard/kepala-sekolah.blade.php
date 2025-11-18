@extends('layouts.dashboard')
@section('title','Dashboard Kepsek')
@section('header','Dashboard Kepala Sekolah')

@section('content')
<h1 class="text-2xl font-bold text-blue-700">Dashboard Kepala Sekolah</h1>
<p class="text-gray-600 mt-2">Selamat datang di panel manajemen sekolah.</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-blue-600 text-white p-6 rounded-xl shadow">
    <h2>Total Guru</h2>
    <p class="text-4xl font-bold">{{ $totalGuru }}</p>
  </div>
  <div class="bg-green-600 text-white p-6 rounded-xl shadow">
    <h2>Total Siswa</h2>
    <p class="text-4xl font-bold">{{ $totalSiswa }}</p>
  </div>
  <div class="bg-yellow-500 text-white p-6 rounded-xl shadow">
    <h2>Laporan Baru</h2>
    <p class="text-4xl font-bold">{{ $laporanBaru }}</p>
  </div>
</div>
@endsection
