@extends('layouts.dashboard')

@section('content')

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Kehadiran</h1>
        <p class="text-gray-600">
            Data kehadiran untuk <strong>{{ $activeChild->nama }}</strong>
        </p>
    </div>
    
    {{-- Child Switcher can also be here or handled globally, for now assuming context is set --}}
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
        <span class="text-3xl font-bold text-green-600 mb-1">{{ $stats['present'] }}</span>
        <span class="text-sm text-gray-500 font-medium">Hadir</span>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
        <span class="text-3xl font-bold text-blue-600 mb-1">{{ $stats['sick'] }}</span>
        <span class="text-sm text-gray-500 font-medium">Sakit</span>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
        <span class="text-3xl font-bold text-purple-600 mb-1">{{ $stats['permission'] }}</span>
        <span class="text-sm text-gray-500 font-medium">Izin</span>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
        <span class="text-3xl font-bold text-red-600 mb-1">{{ $stats['absent'] }}</span>
        <span class="text-sm text-gray-500 font-medium">Alpha</span>
    </div>
</div>

{{-- Attendance List --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 font-semibold text-xs uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">Mata Pelajaran (Optional)</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($attendances as $attendance)
            @php
                $statusColors = [
                    'present' => 'bg-green-100 text-green-700',
                    'late' => 'bg-yellow-100 text-yellow-700',
                    'absent' => 'bg-red-100 text-red-700',
                    'sick' => 'bg-blue-100 text-blue-700',
                    'permission' => 'bg-purple-100 text-purple-700',
                ];
                $colorClass = $statusColors[$attendance->status] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4 text-gray-800 font-medium">
                    {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y') }}
                </td>
                <td class="px-6 py-4 text-gray-600">
                    {{ $attendance->course->subject->name ?? 'Harian / Wali Kelas' }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorClass }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">
                    {{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                   Belum ada data kehadiran yang tercatat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $attendances->links() }}
    </div>
</div>

@endsection
