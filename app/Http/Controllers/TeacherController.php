<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TeacherImport;
use App\Exports\TeacherTemplateExport;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->where('school_id', auth()->user()->school_id)->latest()->paginate(10);
        return view('pages.school.admin.teachers.index', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|unique:teachers,nip',
            'specialization' => 'required', // Mapel
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
                'role' => UserRole::GURU,
                'school_id' => auth()->user()->school_id,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'school_id' => auth()->user()->school_id,
                'nip' => $request->nip,
                'specialization' => $request->specialization,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            DB::commit();
            return back()->with('success', 'Data guru berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan guru: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        $request->validate([
            'nama' => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'nip' => "required|unique:teachers,nip,$id",
            'specialization' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            $teacher->update([
                'nip' => $request->nip,
                'specialization' => $request->specialization,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            DB::commit();
            return back()->with('success', 'Data guru berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui guru: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $teacher = Teacher::findOrFail($id);
            $teacher->user->delete();
            $teacher->delete();
            DB::commit();
            return back()->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus guru.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new TeacherImport, $request->file('file'));
            return back()->with('success', 'Data guru berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new TeacherTemplateExport, 'template_guru.xlsx');
    }

    public function resetPassword($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->user->update([
                'password' => Hash::make('password'), // Default password
            ]);
            return back()->with('success', 'Password berhasil direset menjadi "password".');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mereset password.');
        }
    }
}
