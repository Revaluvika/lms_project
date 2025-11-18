@extends('layouts.dashboard')
@section('title', 'Edit Guru')
@section('header', 'Edit Data Guru')

@section('content')
<form action="{{ route('teachers.update', $teacher->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg mx-auto">
  @csrf
  @method('PUT')

  <div class="mb-4">
    <label class="block font-semibold mb-1">Nama</label>
    <input type="text" name="nama" class="w-full border rounded-lg px-4 py-2" value="{{ $teacher->nama }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">NIP</label>
    <input type="text" name="nip" class="w-full border rounded-lg px-4 py-2" value="{{ $teacher->nip }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Mata Pelajaran</label>
    <input type="text" name="mapel" class="w-full border rounded-lg px-4 py-2" value="{{ $teacher->mapel }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Email</label>
    <input type="email" name="email" class="w-full border rounded-lg px-4 py-2" value="{{ $teacher->email }}">
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
</form>
@endsection
