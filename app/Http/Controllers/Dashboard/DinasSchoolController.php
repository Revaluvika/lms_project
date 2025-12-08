<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\School;
use App\Models\User;
use App\Enums\SchoolStatus;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DinasSchoolController extends Controller
{
    // === Verifikasi Sekolah (Pending) ===
    
    public function pending()
    {
        $schools = School::with('admin')
            ->where('status', SchoolStatus::PENDING)->latest()->paginate(10);
        return view('dashboard.dinas.schools.pending', compact('schools'));
    }

    public function approve($id)
    {
        $school = School::with('admin')->findOrFail($id);
        $school->update(['status' => SchoolStatus::ACTIVE]);

        \App\Events\SchoolApproved::dispatch($school);

        return redirect()->back()->with('success', "Sekolah {$school->name} berhasil disetujui dan aktif.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        
        $school = School::with('admin')->findOrFail($id);
        $school->update(['status' => SchoolStatus::REJECTED]);

        \App\Events\SchoolRejected::dispatch($school, $request->rejection_reason);

        return redirect()->back()->with('success', "Sekolah ditolak. Alasan: {$request->rejection_reason}");
    }

    // === Data Sekolah (Active) ===

    public function active(Request $request)
    {
        $query = School::where('status', SchoolStatus::ACTIVE);

        // Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('education_level')) {
            $query->where('education_level', $request->education_level);
        }
        if ($request->filled('district')) {
            $query->where('district', 'like', '%'.$request->district.'%');
        }

        $schools = $query->latest()->paginate(10);
        
        // Get districts for filter dropdown
        $districts = School::select('district')->distinct()->pluck('district');

        return view('dashboard.dinas.schools.active', compact('schools', 'districts'));
    }

    public function suspend($id)
    {
        $school = School::findOrFail($id);
        $school->update(['status' => SchoolStatus::SUSPENDED]);

        return redirect()->back()->with('warning', "Sekolah {$school->name} telah dibekukan (suspended).");
    }
    
    public function activate($id)
    {
        $school = School::findOrFail($id);
        $school->update(['status' => SchoolStatus::ACTIVE]);

        return redirect()->back()->with('success', "Sekolah {$school->name} telah diaktifkan kembali.");
    }

    public function resetPassword($id)
    {
        // Find School Admin or Kepsek linked to this school
        $admin = User::where('school_id', $id)
            ->whereIn('role', [UserRole::ADMIN_SEKOLAH, UserRole::KEPALA_SEKOLAH])
            ->first();

        if (!$admin) {
             return redirect()->back()->with('error', "Tidak ditemukan akun Admin/Kepsek untuk sekolah ini.");
        }

        $defaultPassword = 'password123'; // Or generate random
        $admin->update(['password' => Hash::make($defaultPassword)]);

        return redirect()->back()->with('success', "Password Admin Sekolah berhasil direset menjadi: $defaultPassword");
    }
}
