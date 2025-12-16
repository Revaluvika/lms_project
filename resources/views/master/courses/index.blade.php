@extends('layouts.dashboard')

@section('content')
<div class="space-y-6 animate-fade-in-up" x-data="courseManager()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengajaran</h1>
            <p class="text-gray-500 text-sm mt-1">Atur pembagian kelas, mata pelajaran, dan guru pengampu.</p>
        </div>
        <div class="flex gap-2">
            <button @click="openModal('create')" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengajaran
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2" role="alert">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Content Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-800 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Tahun Akademik</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Guru Pengampu</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($courses as $course)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $course->academicYear->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $course->classroom->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800">{{ $course->subject->name }}</span>
                                <span class="text-xs text-gray-500 font-mono">{{ $course->subject->code }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($course->teacher)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                        {{ substr($course->teacher->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-900">{{ $course->teacher->user->name }}</span>
                                </div>
                            @else
                                <span class="text-gray-400 italic">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <button @click="openModal('edit', {{ $course }})" class="p-1.5 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-blue-600 transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            
                            <form action="{{ route('master.courses.destroy', $course->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengajaran ini? Data terkait seperti jadwal dan nilai akan terhapus!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                             <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <p class="text-sm font-medium">Belum ada data pengajaran yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($courses->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $courses->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Form -->
    <x-modal name="course-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800" x-text="mode === 'create' ? 'Tambah Pengajaran Baru' : 'Edit Pengajaran'"></h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form :action="formAction" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="_method" :value="mode === 'create' ? 'POST' : 'PUT'">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Akademik</label>
                    <select name="academic_year_id" x-model="form.academic_year_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                        <option value="">Pilih Tahun Akademik</option>
                        @foreach(\App\Models\AcademicYear::where('school_id', Auth::user()->school_id)->get() as $year)
                            <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="classroom_id" x-model="form.classroom_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                            <option value="">Pilih Kelas</option>
                            @foreach(\App\Models\Classroom::where('school_id', Auth::user()->school_id)->get() as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        <select name="subject_id" x-model="form.subject_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach(\App\Models\Subject::where('school_id', Auth::user()->school_id)->get() as $subject)
                                 <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guru Pengampu</label>
                    <select name="teacher_id" x-model="form.teacher_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                        <option value="">Pilih Guru</option>
                        @foreach(\App\Models\Teacher::with('user')->where('school_id', Auth::user()->school_id)->get() as $teacher)
                             <option value="{{ $teacher->id }}">{{ $teacher->user->name }} - {{ $teacher->nip }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm transition-colors">Simpan Pengajaran</button>
                </div>
            </form>
        </div>
    </x-modal>
</div>

<script>
    function courseManager() {
        return {
            mode: 'create',
            formAction: '{{ route('master.courses.store') }}',
            form: {
                academic_year_id: '',
                classroom_id: '',
                subject_id: '',
                teacher_id: ''
            },
            openModal(mode, course = null) {
                this.mode = mode;
                if (mode === 'create') {
                    this.formAction = '{{ route('master.courses.store') }}';
                    this.form = {
                        academic_year_id: '{{ \App\Models\AcademicYear::where("school_id", Auth::user()->school_id)->where("is_active", true)->first()->id ?? "" }}',
                        classroom_id: '',
                        subject_id: '',
                        teacher_id: ''
                    };
                } else {
                    this.formAction = '/master/courses/' + course.id;
                    this.form = {
                        academic_year_id: course.academic_year_id,
                        classroom_id: course.classroom_id,
                        subject_id: course.subject_id,
                        teacher_id: course.teacher_id
                    };
                }
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'course-modal' }));
            },
            closeModal() {
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'course-modal' }));
            }
        }
    }
</script>
@endsection
