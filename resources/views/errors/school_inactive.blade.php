@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center p-10 bg-white rounded-xl shadow-lg">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
            <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-gray-900">
            Sekolah Belum Aktif
        </h2>
        
        <p class="mt-2 text-md text-gray-600">
            @if(auth()->user()->school && auth()->user()->school->status->value === 'pending')
                Pendaftaran sekolah Anda masih dalam proses verifikasi oleh Dinas Pendidikan. Mohon tunggu persetujuan.
            @elseif(auth()->user()->school && auth()->user()->school->status->value === 'rejected')
                Mohon maaf, pendaftaran sekolah Anda ditolak. Silakan hubungi Dinas Pendidikan untuk informasi lebih lanjut.
            @else
                Akun sekolah Anda saat ini tidak aktif ({{ auth()->user()->school->status->value ?? 'Unknown' }}).
            @endif
        </p>

        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    Keluar / Log Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
