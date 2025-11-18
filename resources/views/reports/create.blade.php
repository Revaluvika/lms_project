@extends('layouts.dashboard')
@section('title', 'Buat Laporan')
@section('header', 'Buat Laporan Baru')

@section('content')
<form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg mx-auto">
  @csrf
  <div class="mb-4">
    <label class="block font-semibold mb-1">Judul</label>
    <input type="text" name="judul" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="w-full border rounded-lg px-4 py-2" required></textarea>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Lampiran (opsional)</label>
    <input type="file" name="file" class="w-full border rounded-lg px-4 py-2">
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Kirim</button>
</form>
@endsection
