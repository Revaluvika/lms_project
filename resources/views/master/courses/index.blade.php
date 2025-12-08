@extends('layouts.dashboard')
@section('title', 'Manajemen Pengajaran')
@section('header', 'Data Kelas Mata Pelajaran (Courses)')

@section('content')
<div x-data="courseManager()">
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-lg">Daftar Pengajaran</h3>
            <button @click="openModal('create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Pengajaran
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border-b">Tahun Akademik</th>
                        <th class="p-3 border-b">Kelas</th>
                        <th class="p-3 border-b">Mata Pelajaran</th>
                        <th class="p-3 border-b">Guru Pengampu</th>
                        <th class="p-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b">{{ $course->academicYear->name }}</td>
                            <td class="p-3 border-b">{{ $course->classroom->name }}</td>
                            <td class="p-3 border-b">{{ $course->subject->name }} ({{ $course->subject->code }})</td>
                            <td class="p-3 border-b">{{ $course->teacher->user->name ?? '-' }}</td>
                            <td class="p-3 border-b text-center">
                                <button @click="openModal('edit', {{ $course }})" class="text-blue-600 hover:text-blue-800 mr-2">
                                    Edit
                                </button>
                                <form action="{{ route('master.courses.destroy', $course->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pengajaran ini? Data terkait seperti jadwal dan nilai akan terhapus!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada data pengajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="course-modal" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4" x-text="mode === 'create' ? 'Tambah Pengajaran' : 'Edit Pengajaran'"></h2>
            
            <form :action="formAction" method="POST">
                @csrf
                <input type="hidden" name="_method" :value="mode === 'create' ? 'POST' : 'PUT'">

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Tahun Akademik</label>
                    <select name="academic_year_id" x-model="form.academic_year_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Tahun Akademik</option>
                        @foreach(\App\Models\AcademicYear::where('school_id', Auth::user()->school_id)->get() as $year)
                            <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Kelas</label>
                    <select name="classroom_id" x-model="form.classroom_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Kelas</option>
                        @foreach(\App\Models\Classroom::where('school_id', Auth::user()->school_id)->get() as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Mata Pelajaran</label>
                    <select name="subject_id" x-model="form.subject_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach(\App\Models\Subject::where('school_id', Auth::user()->school_id)->get() as $subject)
                             <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Guru Pengampu</label>
                    <select name="teacher_id" x-model="form.teacher_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Guru</option>
                        @foreach(\App\Models\Teacher::with('user')->where('school_id', Auth::user()->school_id)->get() as $teacher)
                             <option value="{{ $teacher->id }}">{{ $teacher->user->name }} - {{ $teacher->nip }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
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
