<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash; // Tambahkan ini untuk hashing password
use Illuminate\Validation\Rules;     // Tambahkan ini untuk aturan validasi password

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // ==========================================
    // FITUR: FORCE CHANGE PASSWORD (Wajib Ganti Sandi)
    // ==========================================

    /**
     * Menampilkan form ganti password sementara
     */
    public function showChangePasswordForm(): View
    {
        // Memanggil file blade reset-password yang Anda miliki
        return view('auth.reset-password');
    }

    /**
     * Memproses penyimpanan password baru
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // 1. Validasi input password baru
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $request->user();

        // 2. Simpan password baru dan matikan penanda wajib ganti sandi
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        // 3. Arahkan pengguna kembali ke dashboard dengan pesan sukses
        return Redirect::route('dashboard')->with('success', 'Kata sandi Anda berhasil diperbarui. Silakan lanjutkan aktivitas Anda.');
    }
}
