@extends('layouts.dashboard')

@section('title', 'Kenaikan Kelas')

@section('content')
<div class="px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kenaikan Kelas</h1>
            <p class="text-slate-500 mt-1">Kelas: {{ $classroom->name }}</p>
        </div>
        <a href="{{ route('homeroom.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('homeroom.promotion.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h6 class="font-semibold text-slate-800">Status Kenaikan Siswa</h6>
                <p class="text-sm text-slate-500 mt-1">Setiap siswa harus ditentukan status kenaikannya untuk tahun ajaran berikutnya.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Kenaikan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($students as $index => $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">{{ $student->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 font-mono">{{ $student->nis ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               name="promotions[{{ $student->id }}]" 
                                               value="promoted" 
                                               class="form-radio text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4" 
                                               {{ ($student->promotion_status ?? 'continuing') == 'promoted' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm font-medium text-emerald-700">Naik Kelas / Lulus</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               name="promotions[{{ $student->id }}]" 
                                               value="retained" 
                                               class="form-radio text-red-600 focus:ring-red-500 border-slate-300 w-4 h-4" 
                                               {{ ($student->promotion_status ?? 'continuing') == 'retained' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm font-medium text-red-700">Tinggal Kelas</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <p>Tidak ada siswa.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
