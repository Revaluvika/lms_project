@extends('layouts.dashboard')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Laporan Akademik</h1>
    <p class="text-gray-600">
        Hasil nilai dan rapor untuk <strong>{{ $activeChild->nama }}</strong>
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    {{-- Left: Report Cards (E-Rapor) --}}
    <div>
        <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
            E-Rapor Semester
        </h3>
        
        <div class="space-y-4">
            @forelse($reportCards as $rapor)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h4 class="font-bold text-gray-800">Rapor {{ $rapor->academicYear->name ?? 'Tahun Ajaran Unknown' }}</h4>
                    <p class="text-sm text-gray-500">{{ ucfirst($rapor->academicYear->semester ?? '-') }}</p>
                </div>
                <a href="{{ route('rapor.pdf', $rapor->id) }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 font-medium transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download PDF
                </a>
            </div>
            @empty
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center text-gray-500">
                Belum ada rapor yang diterbitkan.
            </div>
            @endforelse
        </div>
    </div>

    {{-- Right: Exam Results --}}
    <div>
        <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
             <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
            Hasil Ujian Terbaru
        </h3>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Ujian</th>
                        <th class="px-5 py-3">Mapel</th>
                        <th class="px-5 py-3 text-right">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($examResults as $result)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="font-medium text-gray-800">{{ $result->exam->title }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($result->finished_at)->format('d M Y') }}</div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600">
                            {{ $result->exam->course->subject->name ?? '-' }}
                        </td>
                        <td class="px-5 py-3 text-right">
                             <span class="font-bold text-gray-800 {{ $result->total_score < 75 ? 'text-red-500' : 'text-green-600' }}">
                                 {{ $result->total_score }}
                             </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-6 text-center text-gray-500 text-sm">
                            Belum ada hasil ujian yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
