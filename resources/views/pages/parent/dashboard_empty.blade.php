@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-6">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </div>
    
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Siswa Terhubung</h1>
    <p class="text-gray-500 max-w-md mb-8">
        Akun Anda belum terhubungkan dengan profil siswa manapun. Silakan hubungi admin sekolah untuk menghubungkan akun Anda dengan data anak Anda.
    </p>

    <a href="#" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
        Hubungi Admin Sekolah
    </a>
</div>
@endsection
