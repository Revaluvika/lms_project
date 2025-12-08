<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();
        if (!in_array($user->role->value, $roles)) {
            return abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
