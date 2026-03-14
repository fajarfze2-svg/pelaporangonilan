<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'role' => ['required', 'in:admin,teknisi,user'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ];

        // 🔐 Jika admin mengubah password user secara manual
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            // Paksa user ganti password saat login berikutnya
            $data['must_change_password'] = true;
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui' . ($request->filled('password') ? ' dan wajib ganti password saat login.' : ''));
    }

    // ==========================================
    // FITUR: RESET PASSWORD KE DEFAULT
    // ==========================================
    public function resetPassword(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Gunakan fitur Edit Profile untuk mengubah password Anda sendiri.');
        }

        // Set password menjadi default dan aktifkan must_change_password
        $user->update([
            'password' => Hash::make('password123'),
            'must_change_password' => true
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Password milik ' . $user->name . ' berhasil direset menjadi: password123. User wajib menggantinya saat login.');
    }

    // ==========================================
    // FITUR: HAPUS USER
    // ==========================================
    public function destroy(User $user)
    {
        // 1. Cegah admin menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $userName = $user->name;
            $user->delete();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User ' . $userName . ' berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            // 2. Antisipasi jika user memiliki relasi data (misal: laporan) yang mencegah penghapusan
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Gagal menghapus user. Data mungkin sedang digunakan di tabel lain.');
        }
    }
} 
