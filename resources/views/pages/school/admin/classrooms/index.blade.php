@extends('layouts.dashboard')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Kelas (Rombel)</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola data kelas, tingkat, dan wali kelas.</p>
        </div>
        <div class="flex gap-2">
            <button x-data x-on:click="$dispatch('open-modal', 'create-modal')" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kelas
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
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2" role="alert">
         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Content Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-800 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Nama Kelas</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Tahun Ajaran</th>
                        <th class="px-6 py-4">Wali Kelas</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($classrooms as $classroom)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $classroom->name }}</td>
                        <td class="px-6 py-4">Kelas {{ $classroom->grade_level }}</td>
                        <td class="px-6 py-4">
                            @if($classroom->academicYear)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $classroom->academicYear->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $classroom->academicYear->name }} - {{ ucfirst($classroom->academicYear->semester) }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($classroom->teacher && $classroom->teacher->user)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                        {{ substr($classroom->teacher->user->name, 0, 1) }}
                                    </div>
                                    <span>{{ $classroom->teacher->user->name }}</span>
                                </div>
                            @else
                                <span class="text-gray-400 italic">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <button onclick="openEditModal({{ $classroom->id }}, '{{ $classroom->name }}', '{{ $classroom->grade_level }}', '{{ $classroom->academic_year_id }}', '{{ $classroom->teacher_id }}')" class="p-1.5 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button onclick="openDeleteModal('{{ route('master.classrooms.destroy', $classroom->id) }}')" class="p-1.5 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <p class="text-sm">Belum ada data kelas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<x-modal name="create-modal" :show="$errors->has('name') || $errors->has('grade_level') || $errors->has('teacher_id')" focusable>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Tambah Kelas</h3>
            <button x-on:click="$dispatch('close-modal', 'create-modal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">Terdapat kesalahan:</p>
                        <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('master.classrooms.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: X IPA 1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                <input type="number" name="grade_level" value="{{ old('grade_level') }}" placeholder="Contoh: 10" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <select name="academic_year_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    <option value="" disabled {{ old('academic_year_id') ? '' : 'selected' }}>Pilih Tahun Ajaran</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }} - {{ ucfirst($year->semester) }} {{ $year->is_active ? '(Aktif)' : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas (Opsional)</label>
                <select name="teacher_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }} ({{ $teacher->nip }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" x-on:click="$dispatch('close-modal', 'create-modal')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</x-modal>

<!-- Edit Modal -->
<x-modal name="edit-modal" :show="false" focusable>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Edit Kelas</h3>
            <button x-on:click="$dispatch('close-modal', 'edit-modal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" id="editName" name="name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                <input type="number" id="editGradeLevel" name="grade_level" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <select id="editAcademicYear" name="academic_year_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }} - {{ ucfirst($year->semester) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                <select id="editTeacher" name="teacher_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }} ({{ $teacher->nip }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" x-on:click="$dispatch('close-modal', 'edit-modal')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-modal>

<script>
    function openEditModal(id, name, grade_level, academic_year_id, teacher_id) {
        document.getElementById('editForm').action = `/master/classrooms/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editGradeLevel').value = grade_level;
        document.getElementById('editAcademicYear').value = academic_year_id;
        document.getElementById('editTeacher').value = teacher_id;
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-modal' }));
    }

    function openDeleteModal(url) {
        document.getElementById('deleteForm').action = url;
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-modal' }));
    }
</script>

<!-- Delete Modal -->
<x-modal name="delete-modal" :show="false" focusable>
    <div class="p-6">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="mt-3 text-center sm:mt-5">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Hapus Kelas?</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <form id="deleteForm" method="POST" class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                Hapus
            </button>
            <button type="button" x-on:click="$dispatch('close-modal', 'delete-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                Batal
            </button>
        </form>
    </div>
</x-modal>
@endsection
