@extends('layouts.dashboard')

@section('title', 'Input Data Rapor - ' . $student->user->name)

@section('content')
<div class="px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Input Data Rapor</h1>
            <p class="text-slate-500 mt-1">Siswa: {{ $student->user->name }}</p>
        </div>
        <a href="{{ route('homeroom.report.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('homeroom.report.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Student Info & Attendance -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Student Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h6 class="font-semibold text-slate-800">Siswa</h6>
                    </div>
                    <div class="p-6 text-center">
                        <div class="inline-block p-1 rounded-full bg-indigo-50 mb-3">
                            <img class="w-20 h-20 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($student->user->name) }}&background=random" alt="{{ $student->user->name }}">
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">{{ $student->user->name }}</h5>
                        <p class="text-sm text-slate-500 font-mono mt-1">{{ $student->nis }} / {{ $student->nisn }}</p>
                    </div>
                </div>

                <!-- Attendance -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h6 class="font-semibold text-slate-800">Ketidakhadiran (Semester Ini)</h6>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 items-center gap-4">
                            <label class="text-sm font-medium text-slate-700">Sakit (Hari)</label>
                            <input type="number" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="sick_count" value="{{ $termRecord->sick_count ?? 0 }}" min="0">
                        </div>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <label class="text-sm font-medium text-slate-700">Izin (Hari)</label>
                            <input type="number" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="permission_count" value="{{ $termRecord->permission_count ?? 0 }}" min="0">
                        </div>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <label class="text-sm font-medium text-slate-700">Tanpa Keterangan</label>
                            <input type="number" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="absentee_count" value="{{ $termRecord->absentee_count ?? 0 }}" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Notes & Extracurriculars -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Notes -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h6 class="font-semibold text-slate-800">Catatan Wali Kelas</h6>
                    </div>
                    <div class="p-6">
                        <textarea class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="notes" rows="4" placeholder="Tuliskan catatan motivasi, sikap, atau perkembangan siswa...">{{ $termRecord->notes }}</textarea>
                    </div>
                </div>

                <!-- Extracurriculars -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                        <h6 class="font-semibold text-slate-800">Ekstrakurikuler & Prestasi</h6>
                        <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 text-white text-xs font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm" id="addEkskulBtn">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah
                        </button>
                    </div>
                    <div class="p-6">
                        <div id="ekskulContainer" class="space-y-3">
                            @forelse($ekskul as $ek)
                                <div class="ekskul-item grid grid-cols-12 gap-3 items-start">
                                    <div class="col-span-12 md:col-span-4">
                                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="ekskul_name[]" placeholder="Nama Kegiatan" value="{{ $ek->activity_name }}">
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm text-center" name="ekskul_grade[]" placeholder="Nilai" value="{{ $ek->grade }}">
                                    </div>
                                    <div class="col-span-6 md:col-span-5">
                                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="ekskul_description[]" placeholder="Keterangan" value="{{ $ek->description }}">
                                    </div>
                                    <div class="col-span-12 md:col-span-1 text-right md:text-center">
                                        <button type="button" class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:bg-red-50 rounded-lg transition-colors remove-ekskul">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="ekskul-item grid grid-cols-12 gap-3 items-start">
                                    <div class="col-span-12 md:col-span-4">
                                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="ekskul_name[]" placeholder="Nama Kegiatan">
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm text-center" name="ekskul_grade[]" placeholder="Nilai">
                                    </div>
                                    <div class="col-span-6 md:col-span-5">
                                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="ekskul_description[]" placeholder="Keterangan">
                                    </div>
                                    <div class="col-span-12 md:col-span-1 text-right md:text-center">
                                        <button type="button" class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:bg-red-50 rounded-lg transition-colors remove-ekskul">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                 <div class="flex justify-end pt-4">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white text-base font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 hover:shadow-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Data Rapor
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('ekskulContainer');
        const addBtn = document.getElementById('addEkskulBtn');

        addBtn.addEventListener('click', function() {
            const template = `
                <div class="ekskul-item grid grid-cols-12 gap-3 items-start">
                    <div class="col-span-12 md:col-span-4">
                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="ekskul_name[]" placeholder="Nama Kegiatan">
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm text-center" name="ekskul_grade[]" placeholder="Nilai">
                    </div>
                    <div class="col-span-6 md:col-span-5">
                        <input type="text" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" name="ekskul_description[]" placeholder="Keterangan">
                    </div>
                    <div class="col-span-12 md:col-span-1 text-right md:text-center">
                        <button type="button" class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:bg-red-50 rounded-lg transition-colors remove-ekskul">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
        });

        container.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-ekskul');
            if (removeBtn) {
                const row = removeBtn.closest('.ekskul-item');
                if (container.children.length > 1) {
                    row.remove();
                } else {
                    // Clear inputs if it's the last one
                    row.querySelectorAll('input').forEach(input => input.value = '');
                }
            }
        });
    });
</script>
@endsection
