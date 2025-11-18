@extends('layouts.dashboard')
@section('title','Dashboard Orang Tua')
@section('header','Dashboard Orang Tua')

@section('content')

<h1 class="text-2xl font-bold text-blue-700">Dashboard Orang Tua</h1>
<p class="text-gray-600 mt-2">Pantau perkembangan anak Anda di sini.</p>

<div class="bg-white p-6 rounded-xl shadow text-center">
  <h2 class="text-xl font-semibold mb-3">Progress Belajar Anak</h2>
  <div class="w-full bg-gray-200 rounded-full h-6">
    <div class="bg-blue-600 h-6 rounded-full" style="width: {{ $progressAnak }}%"></div>
  </div>
  <p class="mt-3 font-bold text-blue-600">{{ $progressAnak }}%</p>
</div>
@endsection
