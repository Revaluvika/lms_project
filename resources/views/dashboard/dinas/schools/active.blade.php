```blade
@extends('layouts.dashboard')

@section('content')
<div class="space-y-6" x-data="{
    resetPasswordAction: '',
    suspendAction: '',
    activateAction: '',
    openResetPassword(url) {
        this.resetPasswordAction = url;
        $dispatch('open-modal', 'reset-password-modal');
    },
    openSuspend(url) {
        this.suspendAction = url;
        $dispatch('open-modal', 'suspend-modal');
    },
    openActivate(url) {
        this.activateAction = url;
        $dispatch('open-modal', 'activate-modal');
    }
}">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Sekolah</h1>
            <p class="text-gray-500 font-light">Manajemen data seluruh sekolah aktif</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <form method="GET" action="{{ route('dinas.schools.active') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search Name --}}
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / NPSN</label>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: SMA Negeri 1...">
            </div>

            {{-- Filter Jenjang --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                <select name="education_level" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Semua Jenjang</option>
                    <option value="SD" {{ request('education_level') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ request('education_level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ request('education_level') == 'SMA' ? 'selected' : '' }}>SMA</option>
                    <option value="SMK" {{ request('education_level') == 'SMK' ? 'selected' : '' }}>SMK</option>
                </select>
            </div>

            {{-- Filter Kecamatan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                <select name="district" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Semua Kecamatan</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>{{ $district }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium w-full md:w-auto">
                    Filter
                </button>
                <a href="{{ route('dinas.schools.active') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 text-sm font-medium w-full md:w-auto text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($schools as $school)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase">
                                        {{ substr($school->name, 0, 2) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $school->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $school->education_level }} • NPSN: {{ $school->npsn }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $school->address }}</div>
                            <div class="text-xs text-gray-500">Kec. {{ $school->district }}, Kel. {{ $school->village }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($school->status->value === 'active')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @elseif($school->status->value === 'suspended')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Suspended
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($school->status->value) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Dropdown Actions for Cleaner UI --}}
                            <div class="flex items-center justify-end gap-3">
                                {{-- Reset Password --}}
                                <button type="button" @click="openResetPassword('{{ route('dinas.schools.reset-password', $school->id) }}')" class="text-gray-400 hover:text-indigo-600 transition-colors" title="Reset Password Admin">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                                </button>
                                
                                {{-- Suspend/Activate --}}
                                @if($school->status->value === 'active')
                                    <button type="button" @click="openSuspend('{{ route('dinas.schools.suspend', $school->id) }}')" class="text-gray-400 hover:text-red-600 transition-colors" title="Suspend Sekolah">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                    </button>
                                @elseif($school->status->value === 'suspended')
                                    <button type="button" @click="openActivate('{{ route('dinas.schools.activate', $school->id) }}')" class="text-gray-400 hover:text-green-600 transition-colors" title="Aktifkan Kembali">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Tidak ada data sekolah ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $schools->withQueryString()->links() }}
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <x-modal name="reset-password-modal" maxWidth="md">
        <form :action="resetPasswordAction" method="POST">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Reset Password?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Password Admin Sekolah akan direset menjadi default <strong>(password123)</strong>. Apakah Anda yakin?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Reset Password
                </button>
                <button type="button" @click="$dispatch('close-modal', 'reset-password-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Suspend Modal --}}
    <x-modal name="suspend-modal" maxWidth="md">
        <form :action="suspendAction" method="POST">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Suspend Sekolah?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Sekolah ini akan dibekukan sementara dan tidak dapat mengakses sistem. Lanjutkan?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Suspend
                </button>
                <button type="button" @click="$dispatch('close-modal', 'suspend-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Activate Modal --}}
    <x-modal name="activate-modal" maxWidth="md">
        <form :action="activateAction" method="POST">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Aktifkan Kembali?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Akses sekolah ini akan dipulihkan sepenuhnya. Lanjutkan?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Aktifkan
                </button>
                <button type="button" @click="$dispatch('close-modal', 'activate-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
```
