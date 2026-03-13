<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block">Role</label>
                <select name="role" class="w-full border rounded p-2">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="teknisi" {{ $user->role === 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Password Baru</label>
                <input type="password" name="password" class="w-full border rounded p-2"
                    placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>

            <div class="mb-4">
                <label class="block">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2"
                    placeholder="Ulangi password baru">
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan
                </button>

                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition text-center">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
