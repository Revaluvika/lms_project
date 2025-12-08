<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Exports\StudentTemplateExport;


use App\Models\Classroom;
use Illuminate\Validation\Rules\Enum; // Import validation rule

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'classroom'])->where('school_id', auth()->user()->school_id)->latest()->paginate(10);
        $classrooms = Classroom::where('school_id', auth()->user()->school_id)->get();
        return view('pages.school.admin.students.index', compact('students', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|unique:students,nis',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        if (!auth()->user()->school_id) {
            return back()->with('error', 'Akun Anda tidak terkait dengan sekolah manapun.');
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'phone_number' => $request->telepon, // Sync phone
                'password' => Hash::make('password'),
                'role' => UserRole::SISWA,
                'school_id' => auth()->user()->school_id,
            ]);

            Student::create([
                'user_id' => $user->id,
                'school_id' => auth()->user()->school_id,
                'classroom_id' => $request->classroom_id,
                'nama' => $request->nama,
                'nis' => $request->nis,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            DB::commit();
            return back()->with('success', 'Data siswa berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $request->validate([
            'nama' => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'nis' => "required|unique:students,nis,$id",
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            $student->update([
                'classroom_id' => $request->classroom_id,
                'nama' => $request->nama,
                'nis' => $request->nis,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            DB::commit();
            return back()->with('success', 'Data siswa berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui siswa: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $student = Student::findOrFail($id);
            $student->user->delete(); // This should cascade if set up, but let's be explicit or safe
            $student->delete();
            DB::commit();
            return back()->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus siswa.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new StudentImport, $request->file('file'));
            return back()->with('success', 'Data siswa berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new StudentTemplateExport, 'template_siswa.xlsx');
    }

    public function resetPassword($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->user->update([
                'password' => Hash::make('password'), // Default password
            ]);
            return back()->with('success', 'Password berhasil direset menjadi "password".');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mereset password.');
        }
    }

    public function mutation(Request $request, $id)
    {
        $request->validate([
            'classroom_id' => 'nullable|exists:classrooms,id',
            'status' => ['required', new Enum(\App\Enums\StudentStatus::class)],
        ]);

        try {
            DB::beginTransaction();

            $student = Student::findOrFail($id);
            
            // Should validate logic (e.g., if transferred/graduated, remove from class?)
            // For now, let's just update as requested.
            
            $updateData = [
                'status' => $request->status,
            ];

            if ($request->has('classroom_id')) {
                $updateData['classroom_id'] = $request->classroom_id;
            }

            $student->update($updateData);

            DB::commit();
            return back()->with('success', 'Data mutasi siswa berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses mutasi: ' . $e->getMessage());
        }
    }
}
