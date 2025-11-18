@extends('layouts.dashboard')
@section('title', 'Laporan')
@section('header', 'Manajemen Laporan')

@section('content')
<div class="flex justify-end mb-4">
  <a href="{{ route('reports.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Buat Laporan</a>
</div>

@if(session('success'))
  <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="w-full border-collapse bg-white rounded-xl shadow-md">
  <thead>
    <tr class="bg-gray-100 text-gray-700">
      <th class="p-3 text-left">Judul</th>
      <th class="p-3 text-left">Deskripsi</th>
      <th class="p-3 text-left">Status</th>
      <th class="p-3 text-left">File</th>
      <th class="p-3 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($reports as $report)
    <tr class="border-b hover:bg-gray-50">
      <td class="p-3">{{ $report->judul }}</td>
      <td class="p-3">{{ Str::limit($report->deskripsi, 60) }}</td>
      <td class="p-3">
        <span class="px-3 py-1 rounded-full text-sm 
          @if($report->status == 'Selesai') bg-green-100 text-green-700
          @elseif($report->status == 'Diproses') bg-yellow-100 text-yellow-700
          @else bg-gray-100 text-gray-700 @endif">
          {{ $report->status }}
        </span>
      </td>
      <td class="p-3">
        @if($report->file)
          <a href="{{ asset('storage/' . $report->file) }}" class="text-blue-600 hover:underline" target="_blank">Lihat</a>
        @else
          -
        @endif
      </td>
      <td class="p-3 text-center">
        <a href="{{ route('reports.edit', $report->id) }}" class="text-blue-600 hover:underline">Edit</a> |
        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="inline">
          @csrf @method('DELETE')
          <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus laporan ini?')">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
