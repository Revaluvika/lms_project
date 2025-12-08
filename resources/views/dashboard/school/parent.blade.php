@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Orang Tua</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Profil Anak --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.profil')
            <div>
                <h2 class="font-bold text-xl">Ananda</h2>
                <p class="text-gray-500">Lihat Profil</p>
            </div>
        </div>

        {{-- Nilai Anak --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.nilai')
            <div>
                <h2 class="font-bold text-xl">88%</h2>
                <p class="text-gray-500">Rata-rata Nilai</p>
            </div>
        </div>

        {{-- Pesan dari Guru --}}
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            @include('components.icons.pesan')
            <div>
                <h2 class="font-bold text-xl">3</h2>
                <p class="text-gray-500">Pesan Baru</p>
            </div>
        </div>

    </div>
</div>
@endsection
