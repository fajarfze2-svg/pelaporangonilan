<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input (Username & Password wajib diisi)
        $credentials = $request->validate([
            'username' => ['required', 'string'], // Kita set 'username' sebagai aturan
            'password' => ['required', 'string'],
        ]);

        // 2. Coba Login (Auth Attempt)
        // Fungsi ini akan mencocokkan input 'username' dengan kolom 'username' di database
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {

            // 3. Jika Gagal: Lempar error
            throw ValidationException::withMessages([
                'username' => trans('auth.failed'), // Pesan error "Credential not match"
            ]);
        }

        // 4. Jika Berhasil: Regenerasi Session
        $request->session()->regenerate();

        // 5. Redirect ke Dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
