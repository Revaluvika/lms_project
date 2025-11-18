@extends('layouts.dashboard')
@section('title', 'Tambah Guru')
@section('header', 'Tambah Data Guru')

@section('content')
<form action="{{ route('teachers.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg mx-auto">
  @csrf
  <div class="mb-4">
    <label class="block font-semibold mb-1">Nama</label>
    <input type="text" name="nama" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">NIP</label>
    <input type="text" name="nip" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Mata Pelajaran</label>
    <input type="text" name="mapel" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Email</label>
    <input type="email" name="email" class="w-full border rounded-lg px-4 py-2">
  </div>

  <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Simpan</button>
</form>
@endsection
