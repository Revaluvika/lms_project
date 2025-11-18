@extends('layouts.dashboard')
@section('title', 'Tambah Siswa')
@section('header', 'Tambah Data Siswa')

@section('content')
<form action="{{ route('students.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg mx-auto">
  @csrf
  <div class="mb-4">
    <label class="block font-semibold mb-1">Nama</label>
    <input type="text" name="nama" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Kelas</label>
    <input type="text" name="kelas" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">NIS</label>
    <input type="text" name="nis" class="w-full border rounded-lg px-4 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Email</label>
    <input type="email" name="email" class="w-full border rounded-lg px-4 py-2">
  </div>

  <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Simpan</button>
</form>
@endsection
