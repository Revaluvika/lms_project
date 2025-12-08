<?php

namespace App\Http\Controllers;

use App\Enums\SchoolStatus;
use App\Enums\UserRole;
use App\Events\NewSchoolRegistered;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolRegistrationController extends Controller
{
    public function index()
    {
        return view('school-registration.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Data Sekolah
            'npsn' => 'required|numeric|digits:8|unique:schools,npsn', // Pastikan 8 digit
            'school_name' => 'required|string|max:255',
            'education_level' => 'required|in:SD,SMP,SMA,SMK,SLB', // Validasi enum
            'ownership_status' => 'required|in:negeri,swasta',
            'address' => 'required|string',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'verification_doc' => 'required|file|mimes:pdf,jpg,jpeg|max:2048', // Batasi tipe file dokumen
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
            // Data Operator (User)
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|min:10|max:14', // Tambahan sesuai diskusi
            'password' => 'required|string|min:8|confirmed',
        ]);

        
        [$user, $school] = DB::transaction(function () use ($validated, $request) {
            $folderPath = 'schools/' . $validated['npsn'];
            
            $docPath = $request->file('verification_doc')->store($folderPath . '/documents', 'public');
            $logoPath = $request->file('logo')->store($folderPath . '/logos', 'public');
            
            $school = School::create([
                'npsn'=> $validated['npsn'],
                'name'=> $validated['school_name'],
                'education_level' => $validated['education_level'],
                'ownership_status' => $validated['ownership_status'],
                'address' => $validated['address'],
                'district'=> $validated['district'],
                'village'=> $validated['village'],
                'verification_doc'=> $docPath,
                'logo' => $logoPath,
                'status' => SchoolStatus::PENDING
            ]);

            $user = User::create([
                'name'=> $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'password' => Hash::make($validated['password']),
                'role' => UserRole::ADMIN_SEKOLAH,
                'school_id' => $school->id,
            ]);

            return [$user, $school];
        });

        event(new Registered($user));
        
        // Dispatch event for sending notification email to Admin Dinas (Queued)
        NewSchoolRegistered::dispatch($school);

        return redirect()->route('school.register')->with('success', 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi akun sebelum kami memproses pendaftaran.');
    }
}
