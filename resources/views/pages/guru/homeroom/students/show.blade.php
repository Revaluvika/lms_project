@extends('layouts.dashboard')

@section('title', 'Detail Siswa - ' . $student->user->name)

@section('content')
<div class="px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Siswa</h1>
            <p class="text-slate-500 mt-1">Profile lengkap dan data akademik.</p>
        </div>
        <a href="{{ route('homeroom.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Biodata Section -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h6 class="font-semibold text-slate-800">Biodata Siswa</h6>
                </div>
                <div class="p-6">
                    <div class="text-center mb-6">
                        <img class="w-24 h-24 rounded-full mx-auto ring-4 ring-indigo-50 mb-4" src="https://ui-avatars.com/api/?name={{ urlencode($student->user->name) }}&background=random" alt="{{ $student->user->name }}">
                        <h5 class="text-lg font-bold text-slate-800">{{ $student->user->name }}</h5>
                        <p class="text-sm text-slate-500">{{ $classroom->name }}</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">NIS / NISN</small>
                            <span class="text-slate-800 font-medium font-mono">{{ $student->nis ?? '-' }} / {{ $student->nisn ?? '-' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</small>
                            <span class="text-slate-800 font-medium">{{ $student->place_of_birth ?? '-' }}, {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->isoFormat('D MMMM Y') : '-' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</small>
                            <span class="text-slate-800 font-medium truncate block">{{ $student->user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic & Parent Info -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Parent Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h6 class="font-semibold text-slate-800">Data Orang Tua / Wali</h6>
                </div>
                <div class="divide-y divide-slate-100">
                     @forelse($student->parents as $parent)
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Hubungan</small>
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $parent->pivot->relation_type ?? 'Orang Tua' }}
                                </span>
                            </div>
                            <div>
                                <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</small>
                                <span class="text-slate-800 font-bold">{{ $parent->user->name }}</span>
                            </div>
                            <div>
                                <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kontak / WA</small>
                                @php
                                    $phone = $parent->user->phone_number ?? $parent->phone_alternate;
                                @endphp

                                @if($phone)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $phone)) }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 hover:underline">
                                        <i class="fab fa-whatsapp"></i> {{ $phone }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </div>
                             <div>
                                <small class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Pekerjaan</small>
                                <span class="text-slate-800">{{ $parent->occupation ?? '-' }}</span>
                            </div>
                        </div>
                     @empty
                        <div class="p-12 text-center text-slate-500">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <p>Data Orang Tua belum dihubungkan.</p>
                        </div>
                     @endforelse
                </div>
            </div>

            <!-- Attendance Summary Placeholder -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h6 class="font-semibold text-slate-800">Ringkasan Kehadiran (Semester Ini)</h6>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                            <div class="text-2xl font-bold text-emerald-700 mb-1">-</div>
                            <div class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Hadir</div>
                        </div>
                         <div class="text-center p-4 rounded-xl bg-amber-50 border border-amber-100">
                            <div class="text-2xl font-bold text-amber-700 mb-1">-</div>
                            <div class="text-xs font-bold text-amber-600 uppercase tracking-wider">Sakit</div>
                        </div>
                         <div class="text-center p-4 rounded-xl bg-blue-50 border border-blue-100">
                            <div class="text-2xl font-bold text-blue-700 mb-1">-</div>
                            <div class="text-xs font-bold text-blue-600 uppercase tracking-wider">Izin</div>
                        </div>
                         <div class="text-center p-4 rounded-xl bg-red-50 border border-red-100">
                            <div class="text-2xl font-bold text-red-700 mb-1">-</div>
                            <div class="text-xs font-bold text-red-600 uppercase tracking-wider">Alpha</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
