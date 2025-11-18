@extends('layouts.dashboard')
@section('title', 'Data Guru')
@section('header', 'Manajemen Data Guru')

@section('content')
<div class="flex justify-end mb-4">
  <a href="{{ route('teachers.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ Tambah Guru</a>
</div>

@if(session('success'))
  <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="w-full border-collapse bg-white rounded-xl shadow-md">
  <thead>
    <tr class="bg-gray-100 text-gray-700">
      <th class="p-3 text-left">Nama</th>
      <th class="p-3 text-left">NIP</th>
      <th class="p-3 text-left">Mata Pelajaran</th>
      <th class="p-3 text-left">Email</th>
      <th class="p-3 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($teachers as $teacher)
    <tr class="border-b hover:bg-gray-50">
      <td class="p-3">{{ $teacher->nama }}</td>
      <td class="p-3">{{ $teacher->nip }}</td>
      <td class="p-3">{{ $teacher->mapel }}</td>
      <td class="p-3">{{ $teacher->email }}</td>
      <td class="p-3 text-center">
        <a href="{{ route('teachers.edit', $teacher->id) }}" class="text-blue-600 hover:underline">Edit</a> |
        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline">
          @csrf @method('DELETE')
          <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus guru ini?')">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
