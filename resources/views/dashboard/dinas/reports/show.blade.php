@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    {{-- Breadcrumb / Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('dinas.reports.incoming') }}" class="hover:text-indigo-600">Laporan Masuk</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Detail Laporan</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left: Report Details & PDF Preview --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Document Header --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h1>
                        <p class="text-gray-500 mt-1">
                            {{ $report->school->name }} • {{ $report->report_period ? $report->report_period->format('F Y') : 'Periode Tidak Spesifik' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $report->status == 'submitted' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $report->status == 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $report->status == 'revision_needed' ? 'bg-orange-100 text-orange-800' : '' }}
                        {{ $report->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                    </span>
                </div>

                <div class="mt-6 prose text-gray-600">
                    <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide">Deskripsi Pengirim</h3>
                    <p>{{ $report->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>

                <div class="mt-4 text-xs text-gray-400">
                    Diunggah oleh: {{ $report->uploader->name }} pada {{ $report->created_at->format('d F Y, H:i') }}
                </div>
            </div>

            {{-- PDF Preview --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-semibold text-gray-700">Pratinjau Dokumen</h3>
                    <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        Buka di Tab Baru
                    </a>
                </div>
                <div class="h-[600px] w-full bg-gray-100 flex items-center justify-center">
                    {{-- Assuming file_path is a standard file path. PDF embedding via iframe or object --}}
                    @if(Str::endsWith($report->file_path, '.pdf'))
                        <iframe src="{{ asset('storage/' . $report->file_path) }}" class="w-full h-full" frameborder="0"></iframe>
                    @else
                        <div class="text-center p-6">
                            <p class="text-gray-500 mb-2">Pratinjau tidak tersedia untuk format file ini.</p>
                            <a href="{{ asset('storage/' . $report->file_path) }}" class="btn btn-primary" download>Unduh File</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Validation Action --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Validasi Dinas</h3>
                
                @if($report->status == 'accepted')
                     <div class="rounded-lg bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">Laporan Diterima</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>{{ $report->dinas_feedback }}</p>
                                </div>
                                <div class="mt-4 text-xs text-green-600">
                                    Direview oleh: {{ $report->reviewer?->name ?? 'Admin Dinas' }} <br>
                                    {{ $report->reviewed_at?->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form action="{{ route('dinas.reports.review', $report->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keputusan</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="accepted">Terima Laporan</option>
                                <option value="revision_needed">Perlu Revisi</option>
                                <option value="rejected">Tolak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan / Umpan Balik</label>
                            <textarea name="dinas_feedback" rows="4" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Berikan catatan untuk sekolah..."></textarea>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kirim Validasi
                        </button>
                    </form>
                @endif
            </div>

            @if($report->status == 'revision_needed' || $report->status == 'rejected')
                <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                    <h4 class="text-sm font-semibold text-red-800 mb-2">Riwayat Review Terakhir</h4>
                    <p class="text-sm text-red-700 italic">"{{ $report->dinas_feedback }}"</p>
                    <div class="mt-2 text-xs text-red-500">
                        {{ $report->reviewed_at?->format('d M Y') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
