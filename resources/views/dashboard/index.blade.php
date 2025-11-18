@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('header', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-blue-600 text-white p-6 rounded-xl shadow-md">
      <h2 class="text-lg">Total Guru</h2>
      <p class="text-4xl font-bold">{{ $totalGuru ?? 0 }}</p>
  </div>
  <div class="bg-green-600 text-white p-6 rounded-xl shadow-md">
      <h2 class="text-lg">Total Siswa</h2>
      <p class="text-4xl font-bold">{{ $totalSiswa ?? 0 }}</p>
  </div>
  <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-md">
      <h2 class="text-lg">Total Laporan</h2>
      <p class="text-4xl font-bold">{{ $totalLaporan ?? 0 }}</p>
  </div>
</div>
@endsection
