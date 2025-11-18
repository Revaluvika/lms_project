@extends('layouts.dashboard')
@section('title', 'Data Siswa')
@section('header', 'Manajemen Data Siswa')

@section('content')
<div class="flex justify-end mb-4">
  <a href="{{ route('students.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ Tambah Siswa</a>
</div>

@if(session('success'))
  <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="w-full border-collapse bg-white rounded-xl shadow-md">
  <thead>
    <tr class="bg-gray-100 text-gray-700">
      <th class="p-3 text-left">Nama</th>
      <th class="p-3 text-left">Kelas</th>
      <th class="p-3 text-left">NIS</th>
      <th class="p-3 text-left">Email</th>
      <th class="p-3 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($students as $student)
    <tr class="border-b hover:bg-gray-50">
      <td class="p-3">{{ $student->nama }}</td>
      <td class="p-3">{{ $student->kelas }}</td>
      <td class="p-3">{{ $student->nis }}</td>
      <td class="p-3">{{ $student->email }}</td>
      <td class="p-3 text-center">
        <a href="{{ route('students.edit', $student->id) }}" class="text-blue-600 hover:underline">Edit</a> |
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
          @csrf @method('DELETE')
          <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus siswa ini?')">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
