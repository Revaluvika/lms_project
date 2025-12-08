<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicYearController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        $academicYears = AcademicYear::where('school_id', $schoolId)->orderBy('created_at', 'desc')->get();
        return view('pages.school.admin.academic-years.index', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|in:ganjil,genap',
        ]);

        AcademicYear::create([
            'school_id' => Auth::user()->school_id,
            'name' => $request->name,
            'semester' => $request->semester,
            'is_active' => false, // Default inactive
        ]);

        return redirect()->back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|in:ganjil,genap',
        ]);

        $academicYear = AcademicYear::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $academicYear->update([
            'name' => $request->name,
            'semester' => $request->semester,
        ]);

        return redirect()->back()->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::where('school_id', Auth::user()->school_id)->findOrFail($id);
        
        if ($academicYear->is_active) {
             return redirect()->back()->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif.');
        }

        $academicYear->delete();
        return redirect()->back()->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $schoolId = Auth::user()->school_id;
        $academicYear = AcademicYear::where('school_id', $schoolId)->findOrFail($id);

        // Deactivate all other years
        AcademicYear::where('school_id', $schoolId)->update(['is_active' => false]);

        // Activate selected year
        $academicYear->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Tahun ajaran aktif berhasil diubah.');
    }
}
