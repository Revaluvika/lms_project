@extends('layouts.dashboard')
@section('title','Dashboard Guru')
@section('header','Dashboard Guru')

@section('content')
<h1 class="text-2xl font-bold text-blue-700">Dashboard Guru</h1>
<p class="text-gray-600 mt-2">Kelola kelas, tugas, dan nilai siswa di sini.</p>

<div class="bg-white p-6 rounded-xl shadow text-center">
  <h2 class="text-xl font-semibold mb-2">Laporan yang sedang diproses</h2>
  <p class="text-4xl font-bold text-blue-600">{{ $laporanSaya }}</p>
</div>
@endsection
