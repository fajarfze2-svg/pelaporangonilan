<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceChangePassword
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user sedang login DAN statusnya wajib ganti password
        if (Auth::check() && Auth::user()->must_change_password) {

            // Pengecualian agar tidak terjadi infinite loop (berputar-putar di halaman yang sama)
            // User tetap diizinkan mengakses halaman ganti password dan fungsi logout
            if (! $request->is('password/change') && ! $request->is('logout')) {
                return redirect()->route('password.change')
                    ->with('warning', 'Anda wajib mengganti password sementara/default Anda demi keamanan.');
            }
        }

        return $next($request);
    }
}
