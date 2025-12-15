@extends('layouts.dashboard')

@section('title', 'Leger Nilai - ' . $classroom->name)

@section('content')
<div class="px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Leger Nilai</h1>
            <p class="text-slate-500 mt-1">Kelas: {{ $classroom->name }}</p>
        </div>
        <a href="{{ route('homeroom.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h6 class="font-semibold text-slate-800">Rekap Nilai Siswa</h6>
        </div>
        
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-800 text-white">
                        <th rowspan="2" class="px-4 py-3 border-r border-slate-700 text-center w-12 text-xs uppercase tracking-wider">No</th>
                        <th rowspan="2" class="px-4 py-3 border-r border-slate-700 text-left min-w-[200px] text-xs uppercase tracking-wider">Nama Siswa</th>
                        <th colspan="{{ $subjects->count() }}" class="px-4 py-2 border-b border-slate-700 text-center text-xs uppercase tracking-wider">Mata Pelajaran</th>
                        <th rowspan="2" class="px-4 py-3 border-l border-slate-700 text-center w-24 text-xs uppercase tracking-wider">Rata-rata</th>
                    </tr>
                    <tr class="bg-slate-700 text-white">
                        @foreach($subjects as $subject)
                            <th class="px-3 py-2 text-center text-xs font-medium border-r border-slate-600 last:border-r-0 whitespace-nowrap" title="{{ $subject->name }}">
                                {{ $subject->code ?? substr($subject->name, 0, 3) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($students as $index => $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 text-center text-slate-500 border-r border-slate-100">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800 border-r border-slate-100">{{ $student->user->name }}</td>
                        
                        @php $totalScore = 0; $countScore = 0; @endphp
                        
                        @foreach($subjects as $subject)
                            @php
                                $gradeData = $grades[$student->id][$subject->id] ?? null;
                                $score = $gradeData ? $gradeData['final_grade'] : 0;
                                if ($score > 0) {
                                    $totalScore += $score;
                                    $countScore++;
                                }
                                $isPassing = $score >= ($subject->passing_grade ?? 75);
                            @endphp
                            <td class="px-2 py-3 text-center border-r border-slate-100 last:border-r-0 {{ $score > 0 && !$isPassing ? 'text-red-600 font-bold bg-red-50' : 'text-slate-600' }}">
                                {{ $score > 0 ? number_format($score, 0) : '-' }}
                            </td>
                        @endforeach
                        
                        <td class="px-4 py-3 text-center font-bold text-slate-800 border-l border-slate-200 bg-slate-50">
                            {{ $countScore > 0 ? number_format($totalScore / $countScore, 1) : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $subjects->count() + 3 }}" class="px-6 py-12 text-center text-slate-500">
                            Data siswa tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-500 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-red-500"></span>
            <span>Nilai berwarna <strong>MERAH</strong> menandakan di bawah KKM.</span>
        </div>
    </div>
</div>
@endsection
