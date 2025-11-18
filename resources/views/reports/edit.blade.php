@extends('layouts.dashboard')
@section('title', 'Edit Laporan')
@section('header', 'Edit Laporan')

@section('content')
<form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg mx-auto">
  @csrf
  @method('PUT')

  <div class="mb-4">
    <label class="block font-semibold mb-1">Judul</label>
    <input type="text" name="judul" class="w-full border rounded-lg px-4 py-2" value="{{ $report->judul }}" required>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="w-full border rounded-lg px-4 py-2" required>{{ $report->deskripsi }}</textarea>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Status</label>
    <select name="status" class="w-full border rounded-lg px-4 py-2">
      <option value="Menunggu" {{ $report->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
      <option value="Diproses" {{ $report->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
      <option value="Selesai" {{ $report->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
  </div>

  <div class="mb-4">
    <label class="block font-semibold mb-1">Ganti File (opsional)</label>
    <input type="file" name="file" class="w-full border rounded-lg px-4 py-2">
    @if($report->file)
      <p class="text-sm mt-2">File saat ini: <a href="{{ asset('storage/' . $report->file) }}" class="text-blue-600 hover:underline" target="_blank">Lihat</a></p>
    @endif
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
</form>
@endsection
