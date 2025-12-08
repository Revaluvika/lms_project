<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        $subjects = Subject::where('school_id', $schoolId)->orderBy('name', 'asc')->get();
        return view('pages.school.admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
        ]);

        Subject::create([
            'school_id' => Auth::user()->school_id,
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
        ]);

        $subject = Subject::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subject = Subject::where('school_id', Auth::user()->school_id)->findOrFail($id);
        
        // Optional: Check if subject is used in any courses before deleting
        // if ($subject->courses()->exists()) {
        //     return redirect()->back()->with('error', 'Mata pelajaran tidak dapat dihapus karena sedang digunakan dalam jadwal.');
        // }

        $subject->delete();
        return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
