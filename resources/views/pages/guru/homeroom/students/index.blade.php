@extends('layouts.dashboard')

@section('title', 'Anggota Kelas - ' . $classroom->name)

@section('content')
<div class="px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Anggota Kelas</h1>
            <p class="text-slate-500 mt-1">Kelas: {{ $classroom->name }}</p>
        </div>
        <a href="{{ route('homeroom.promotion.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            Kenaikan Kelas
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h6 class="font-semibold text-slate-800">Daftar Siswa</h6>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIS / NISN</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Orang Tua (Ayah/Ibu)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontak Ortu</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($students as $index => $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-700 font-mono">{{ $student->nis ?? '-' }}</span>
                            <span class="text-slate-400 mx-1">/</span>
                            <span class="text-sm text-slate-500 font-mono">{{ $student->nisn ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $student->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 space-y-1">
                            @php
                                $ayah = $student->parents->where('pivot.relation_type', 'Ayah')->first();
                                $ibu = $student->parents->where('pivot.relation_type', 'Ibu')->first();
                                $wali = $student->parents->where('pivot.relation_type', 'Wali')->first();
                            @endphp
                            
                            @if($ayah)
                                <div class="flex items-center gap-2"><span class="w-10 text-xs text-slate-400 uppercase">Ayah:</span> <span class="text-slate-700">{{ $ayah->user->name ?? '-' }}</span></div>
                            @endif
                            @if($ibu)
                                <div class="flex items-center gap-2"><span class="w-10 text-xs text-slate-400 uppercase">Ibu:</span> <span class="text-slate-700">{{ $ibu->user->name ?? '-' }}</span></div>
                            @endif
                            @if($wali)
                                <div class="flex items-center gap-2"><span class="w-10 text-xs text-slate-400 uppercase">Wali:</span> <span class="text-slate-700">{{ $wali->user->name ?? '-' }}</span></div>
                            @endif
                            
                            @if(!$ayah && !$ibu && !$wali)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    Data Ortu Belum Ada
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 space-y-1">
                            @if($ayah && ($ayah->user->phone_number || $ayah->phone_alternate))
                                <div class="flex items-center gap-2 text-emerald-600">
                                    <i class="fab fa-whatsapp"></i> <span>{{ $ayah->user->phone_number ?? $ayah->phone_alternate }} (A)</span>
                                </div>
                            @endif
                            @if($ibu && ($ibu->user->phone_number || $ibu->phone_alternate))
                                <div class="flex items-center gap-2 text-emerald-600">
                                    <i class="fab fa-whatsapp"></i> <span>{{ $ibu->user->phone_number ?? $ibu->phone_alternate }} (I)</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('homeroom.students.show', $student->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p class="text-lg font-medium text-slate-900">Belum ada data siswa</p>
                                <p class="text-sm">Tidak ada siswa yang terdaftar di kelas ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
