@extends('layouts.dashboard')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h1>
    <p class="text-gray-600">
        Jadwal mingguan <strong>{{ $activeChild->nama }}</strong> - Kelas {{ $activeChild->classroom->name ?? '-' }}
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    
    @php
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $dayLabels = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu'
        ];
    @endphp
    
    @foreach($days as $day)
        @if(isset($schedules[$day]) && $schedules[$day]->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="bg-indigo-50 px-4 py-3 border-b border-indigo-100 flex items-center justify-between">
                <h3 class="font-bold text-indigo-800">{{ $dayLabels[$day] }}</h3>
                <span class="text-xs font-semibold bg-white text-indigo-600 px-2 py-1 rounded-md border border-indigo-100 shadow-sm">
                    {{ $schedules[$day]->count() }} Mapel
                </span>
            </div>
            
            <div class="divide-y divide-gray-100 flex-1">
                @foreach($schedules[$day] as $schedule)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-1">
                        <span class="font-bold text-gray-800 text-sm">
                            {{ $schedule->course->subject->name ?? 'Subject' }}
                        </span>
                        <span class="text-xs font-mono text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        </span>
                    </div>
                    
                    <p class="text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $schedule->course->teacher->nama ?? 'Guru Pengampu' }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach

    @if($schedules->isEmpty())
        <div class="col-span-full flex flex-col items-center justify-center py-16 bg-white rounded-xl border-2 border-dashed border-gray-200">
             <div class="h-16 w-16 text-gray-300 mb-4 bg-gray-50 rounded-full flex items-center justify-center">
                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
             </div>
             <h3 class="text-xl font-semibold text-gray-800">Belum ada jadwal</h3>
             <p class="text-gray-500 mt-2 max-w-sm text-center">Jadwal pelajaran untuk kelas <strong>{{ $activeChild->classroom->name ?? 'ini' }}</strong> belum tersedia atau belum dipublikasikan oleh sekolah.</p>
        </div>
    @endif

</div>

@endsection
