@extends('layouts.dashboard')
@section('title', 'Edit Siswa')
@section('header', 'Edit Data Siswa')

@section('content')
<form action="{{ route('students.update', $student->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg mx-auto">
  @csrf
  @method('PUT')

  <div class="mb-4">
    <label class="block font-semibold mb-1">Nama</label>
    <input type="text" name="nama" class="w-full border rounded-lg px-4 py-2" value="{{ $student->nama }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Kelas</label>
    <input type="text" name="kelas" class="w-full border rounded-lg px-4 py-2" value="{{ $student->kelas }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">NIS</label>
    <input type="text" name="nis" class="w-full border rounded-lg px-4 py-2" value="{{ $student->nis }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Email</label>
    <input type="email" name="email" class="w-full border rounded-lg px-4 py-2" value="{{ $student->email }}">
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
</form>
@endsection
