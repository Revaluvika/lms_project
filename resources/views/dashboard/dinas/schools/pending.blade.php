@extends('layouts.dashboard')

@section('content')
<div class="space-y-6" x-data="{
    docUrl: '',
    rejectAction: '',
    approveAction: '',
    openDoc(url) {
        this.docUrl = url;
        $dispatch('open-modal', 'doc-modal');
    },
    openReject(url) {
        this.rejectAction = url;
        $dispatch('open-modal', 'reject-modal');
    },
    openApprove(url) {
        this.approveAction = url;
        $dispatch('open-modal', 'approve-modal');
    }
}">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi Sekolah</h1>
            <p class="text-gray-500 font-light">Daftar registrasi sekolah yang menunggu persetujuan</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($schools as $school)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-700 font-bold uppercase">
                                        {{ substr($school->name, 0, 2) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $school->name }}</div>
                                    <div class="text-xs text-gray-500">NPSN: {{ $school->npsn }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $school->education_level }} - {{ $school->ownership_status }}</div>
                            <div class="text-xs text-gray-500">{{ $school->district }}, {{ $school->student_count ?? 0 }} Siswa</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="openDoc('{{ asset('storage/'.$school->verification_doc) }}')" class="text-xs inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1.5 rounded-lg border border-indigo-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Preview SK
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $school->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                             <div class="flex items-center justify-end gap-2">
                                @if($school->admin && $school->admin->hasVerifiedEmail())
                                    <button @click="openApprove('{{ route('dinas.schools.approve', $school->id) }}')" class="bg-green-600 text-white hover:bg-green-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                        Approve
                                    </button>
                                @else
                                    <button disabled class="bg-gray-300 text-gray-500 cursor-not-allowed px-3 py-1.5 rounded-lg text-xs font-medium transition-colors" title="Email admin belum diverifikasi">
                                        Approve
                                    </button>
                                @endif
                                <button @click="openReject('{{ route('dinas.schools.reject', $school->id) }}')" class="bg-red-600 text-white hover:bg-red-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Tidak ada sekolah yang menunggu verifikasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $schools->links() }}
        </div>
    </div>

    {{-- Doc Modal Component --}}
    <x-modal name="doc-modal" maxWidth="7xl">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full h-[80vh]">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Dokumen Verifikasi</h3>
                    <iframe :src="docUrl" class="w-full h-full border rounded-lg"></iframe>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- Approve Modal Component --}}
    <x-modal name="approve-modal" maxWidth="md">
        <form :action="approveAction" method="POST">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Setujui Sekolah?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin menyetujui dan mengaktifkan sekolah ini? Akses akan segera diberikan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Ya, Setujui
                </button>
                <button type="button" @click="$dispatch('close-modal', 'approve-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Reject Modal Component --}}
    <x-modal name="reject-modal" maxWidth="lg">
        <form :action="rejectAction" method="POST">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Registrasi Sekolah</h3>
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Dokumen SK tidak terbaca, NPSN salah..." required autofocus></textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Tolak Sekolah
                </button>
                <button type="button" @click="$dispatch('close-modal', 'reject-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
