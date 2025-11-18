@extends('layouts.dashboard')
@section('title','Dashboard Siswa')
@section('header','Dashboard Siswa')

@section('content')

<h1 class="text-2xl font-bold text-blue-700">Dashboard Siswa</h1>
<p class="text-gray-600 mt-2">Lihat jadwal, materi, dan nilai Anda di sini.</p>

<h2 class="text-xl font-semibold mb-4">Riwayat Laporan Terakhir</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
  <table class="w-full">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="p-3 text-left">Judul</th>
        <th class="p-3 text-left">Status</th>
        <th class="p-3 text-left">Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($riwayatLaporan as $r)
      <tr class="border-b">
        <td class="p-3">{{ $r->judul }}</td>
        <td class="p-3">{{ $r->status }}</td>
        <td class="p-3">{{ $r->created_at->format('d M Y') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
