<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && in_array($user->role->value, [
            \App\Enums\UserRole::KEPALA_SEKOLAH->value,
            \App\Enums\UserRole::GURU->value,
            \App\Enums\UserRole::SISWA->value,
            \App\Enums\UserRole::ORANG_TUA->value,
            \App\Enums\UserRole::ADMIN_SEKOLAH->value
        ])) {
            $school = $user->school;

            if (!$school) {
                // If user has role but no school, weird state, maybe logout or 403
                abort(403, 'Akun Anda tidak terhubung dengan sekolah manapun.');
            }

            if ($school->status !== \App\Enums\SchoolStatus::ACTIVE) {
                // Allow logout, verification, and inactive error page
                if ($request->routeIs('logout') || 
                    $request->routeIs('verification.*') || 
                    $request->routeIs('school.inactive')) {
                    return $next($request);
                }
                return redirect()->route('school.inactive');
            }
        }

        return $next($request);
    }
}
