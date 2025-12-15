@extends('layouts.dashboard')

@section('title', 'Koreksi Jawaban - ' . $attempt->student->user->name)

@section('content')
<div class="p-6 max-w-5xl mx-auto space-y-8">
    
    <form action="{{ route('teacher.exams.grade', ['id' => $exam->id, 'attemptId' => $attempt->id]) }}" method="POST">
        @csrf

        <!-- Sticky Header -->
        <div class="sticky top-4 z-20 mb-8">
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200 p-4 md:p-6 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-12 h-12 rounded-full hidden md:flex items-center justify-center bg-blue-100 text-blue-600 font-bold text-lg shrink-0">
                        {{ substr($attempt->student->user->name, 0, 2) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <a href="{{ route('teacher.exams.results', $exam->id) }}" class="text-gray-500 hover:text-blue-600 text-xs font-medium flex items-center gap-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Kembali
                            </a>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ $attempt->student->user->name }}</h1>
                        <p class="text-sm text-gray-500">{{ $attempt->student->nis }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                    <div class="text-right">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Nilai</p>
                        <p class="text-2xl font-black text-blue-600 leading-none">{{ number_format($attempt->total_score, 2) }}</p>
                    </div>
                    <div class="h-8 w-px bg-gray-200 hidden md:block"></div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2 transform hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>

        @php
            $mappedAnswers = $attempt->answers->keyBy('exam_question_id');
            // Stats Calculation
            $totalQuestions = $exam->questions->count();
            $answeredCount = $mappedAnswers->count();
            $correctCount = 0;
            
            // Only count auto-graded correct answers for stats (excluding essays initially or check score)
            foreach($exam->questions as $q){
               $ans = $mappedAnswers[$q->id] ?? null;
               if($ans && $q->question_type != 'essay' && $ans->score == $q->points){
                   $correctCount++;
               }
            }
        @endphp

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase">Total Soal</p>
                    <p class="text-lg font-black text-gray-900">{{ $totalQuestions }}</p>
                </div>
            </div>
             <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase">Dijawab</p>
                    <p class="text-lg font-black text-gray-900">{{ $answeredCount }}</p>
                </div>
            </div>
             <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase">Benar (Obj.)</p>
                    <p class="text-lg font-black text-gray-900">{{ $correctCount }}</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
               <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase">Skor Saat Ini</p>
                    <p class="text-lg font-black text-gray-900">{{ number_format($attempt->total_score, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Question List -->
        <div class="space-y-6 pb-12">
            @foreach($exam->questions as $index => $question)
                @php
                    $answer = $mappedAnswers[$question->id] ?? null;
                    $userAnswerVal = $answer ? $answer->answer : null;
                    $currentScore = $answer ? $answer->score : 0;
                    $isEssay = $question->question_type == 'essay';
                    
                    // Determine status color
                    $statusColor = 'border-gray-200'; // Default
                    if ($answer) {
                        if ($currentScore == $question->points) $statusColor = 'border-green-400 ring-1 ring-green-400';
                        elseif ($currentScore > 0) $statusColor = 'border-yellow-400 ring-1 ring-yellow-400'; // Partial
                        else $statusColor = 'border-red-400 ring-1 ring-red-400';
                    }
                    if($isEssay) $statusColor = 'border-blue-300 ring-1 ring-blue-300';
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border {{ $statusColor }} overflow-hidden transition-shadow hover:shadow-md">
                    <!-- Question Header -->
                    <div class="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center font-bold text-gray-700 shadow-sm">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide">
                                    {{ str_replace('_', ' ', $question->question_type) }}
                                </span>
                                <span class="text-xs text-gray-500 font-medium ml-2">Maksimal: {{ $question->points }} Poin</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                            <label class="text-xs font-bold text-gray-500 uppercase">Input Nilai:</label>
                            <input type="number" 
                                   name="scores[{{ $question->id }}]" 
                                   value="{{ $currentScore }}" 
                                   step="0.01"
                                   min="0" 
                                   max="{{ $question->points }}" 
                                   class="w-20 font-mono font-bold text-lg border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-blue-500 p-0 text-blue-600 bg-transparent transition-colors text-right"
                            >
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Question Text -->
                        <div class="prose prose-blue max-w-none text-gray-800 mb-6 font-medium">
                            {!! nl2br(e($question->question_text)) !!}
                        </div>

                        <!-- Answer Section -->
                        @if($isEssay)
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase">Jawaban Siswa:</label>
                                <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100 text-gray-800 whitespace-pre-wrap font-serif leading-relaxed dark:text-gray-900">
                                    {{ $userAnswerVal ?? '(Siswa tidak menjawab)' }}
                                </div>
                            </div>
                        @else
                            <div class="space-y-3">
                                <label class="text-xs font-bold text-gray-400 uppercase">Kunci Jawaban & Pilihan Siswa:</label>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($question->options as $key => $val)
                                        @php
                                            $isCorrect = $key == $question->correct_answer;
                                            $isSelected = $key == $userAnswerVal;
                                            
                                            $optionClass = 'border-gray-200 bg-white hover:bg-gray-50';
                                            $icon = '';

                                            if ($isCorrect) {
                                                $optionClass = 'border-green-200 bg-green-50 ring-1 ring-green-200';
                                                $icon = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                            } elseif ($isSelected) {
                                                $optionClass = 'border-red-200 bg-red-50 ring-1 ring-red-200';
                                                $icon = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                            }
                                        @endphp
                                        
                                        <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $optionClass }}">
                                            <span class="w-8 h-8 flex items-center justify-center rounded-lg font-bold text-sm bg-white border border-gray-200 shadow-sm shrink-0 {{ $isCorrect ? 'text-green-700 border-green-300' : ($isSelected ? 'text-red-700 border-red-300' : 'text-gray-600') }}">
                                                {{ $key }}
                                            </span>
                                            <span class="flex-1 text-sm font-medium text-gray-700">{{ $val }}</span>
                                            
                                            <div class="flex items-center gap-2">
                                                @if($isSelected)
                                                    <span class="text-[10px] font-bold uppercase px-2 py-1 rounded bg-white border border-gray-200 text-gray-500">Jawaban Siswa</span>
                                                @endif
                                                {!! $icon !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>
@endsection
