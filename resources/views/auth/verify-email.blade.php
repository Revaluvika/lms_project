@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">
                Verifikasi Email Anda
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Untuk alasan keamanan, mohon verifikasi alamat email Anda sebelum melanjutkan.
            </p>
        </div>

        @if (session('message') == 'Link verifikasi telah dikirim ulang!')
            <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                             Link verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-md bg-blue-50 p-4 border-l-4 border-blue-400">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Kami telah mengirimkan link verifikasi ke email Anda. Silakan cek inbox atau folder spam Anda.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-5 sm:mt-6 flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                    Kirim Ulang Link Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Keluar / Log Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
