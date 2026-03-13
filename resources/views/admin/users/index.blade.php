<x-app-layout>
    <x-slot name="header">
        {{-- Import Font Google untuk Judul Saja (Serif) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        {{-- Wrapper Header: Formal Glassmorphism --}}
        <div
            class="relative pt-10 pb-6 bg-white/70 backdrop-blur-2xl border-b border-slate-200/80 shadow-[0_2px_15px_rgba(15,23,42,0.03)] overflow-hidden">

            {{-- Pancaran Glow Sangat Halus (Disesuaikan dengan Navy) --}}
            <div
                class="absolute top-[-50%] right-[10%] w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[100px] pointer-events-none z-0">
            </div>
            <div
                class="absolute bottom-[-30%] left-[5%] w-[400px] h-[400px] bg-slate-400/10 rounded-full blur-[80px] pointer-events-none z-0">
            </div>

            {{-- Konten Header --}}
            <div
                class="relative z-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    {{-- Judul Utama dengan FONT SERIF dan Warna EMAS --}}
                    <h2
                        class="text-4xl md:text-5xl font-semibold text-[#0F2854] font-serif tracking-tight leading-snug">
                        Manajemen <span class="text-[#CBA135]">Pegawai</span>
                    </h2>

                    {{-- Deskripsi menggunakan Font Sans Formal --}}
                    <p class="text-sm text-slate-500 mt-3 max-w-2xl leading-relaxed font-sans font-medium">
                        Kelola data akses akun Admin dan Teknisi yang beroperasi di dalam sistem.
                    </p>
                </div>

                {{-- Tombol Tambah User (Warna Navy) --}}
                <div class="shrink-0 mb-1">
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-[#0F2854] hover:bg-[#1A3A73] text-white rounded-xl text-xs font-extrabold shadow-md transition-all duration-300 uppercase tracking-widest active:scale-95">
                        <i data-feather="user-plus" class="w-4 h-4"></i>
                        Tambah Pegawai
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- KONTEN UTAMA DENGAN FONT FORMAL (font-sans) --}}
    <div class="py-10 min-h-screen font-sans bg-[#F7F8F0]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ================= TABEL DATA USER ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                {{-- Info Header Tabel --}}
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        {{-- Aksen Garis diubah ke Navy --}}
                        <span class="w-1.5 h-6 bg-[#0F2854] rounded-full"></span>
                        <h3 class="font-bold text-slate-800 text-lg tracking-tight">Daftar Akun Terdaftar</h3>
                    </div>
                    <span
                        class="px-3 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold shadow-sm">
                        Total: {{ $users->count() }} Akun
                    </span>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Profil Pegawai</th>
                                <th class="px-6 py-4 w-48">Username Login</th>
                                <th class="px-6 py-4 w-32 text-center">Hak Akses</th>
                                <th class="px-6 py-4 w-56 text-right">Aksi & Manajemen</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($users as $index => $user)
                                <tr class="hover:bg-slate-50/50 transition-colors group">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xs font-bold text-slate-400">{{ $index + 1 }}</span>
                                    </td>

                                    {{-- Profil Pegawai --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            {{-- Avatar Hover diubah ke Navy --}}
                                            <div
                                                class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center font-bold text-sm shadow-sm group-hover:bg-[#0F2854] group-hover:text-white group-hover:border-[#0F2854] transition-colors">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 text-sm">{{ $user->name }}</div>
                                                <div
                                                    class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">
                                                    ID: {{ $user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Username --}}
                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-600 font-mono text-xs font-medium">
                                            <i data-feather="at-sign" class="w-3 h-3 text-slate-400"></i>
                                            {{ $user->username }}
                                        </div>
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-6 py-4 text-center">
                                        @if (strtolower($user->role) == 'admin')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-bold uppercase tracking-wider">
                                                Admin
                                            </span>
                                        @else
                                            <span
                                                class="inline-block px-3 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase tracking-wider">
                                                Teknisi
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">

                                            {{-- Tombol Edit (Warna Biru Standar) --}}
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100"
                                                title="Edit Profil">
                                                <i data-feather="edit-2" class="w-4 h-4"></i>
                                            </a>

                                            @if (auth()->id() !== $user->id)
                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('PERINGATAN: Yakin ingin menghapus permanen akun {{ $user->name }}?')"
                                                        class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100"
                                                        title="Hapus Akun">
                                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>

                                                {{-- Tombol Reset Password --}}
                                                <form action="{{ route('admin.users.reset-password', $user->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin ingin mereset password {{ $user->name }} menjadi password default (password123)?');"
                                                        class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg border border-amber-200 transition-colors shadow-sm text-[10px] font-bold uppercase tracking-wider ml-1"
                                                        title="Kembalikan Password ke Default">
                                                        <i data-feather="key" class="w-3.5 h-3.5"></i> Reset Pass
                                                    </button>
                                                </form>
                                            @else
                                                <span
                                                    class="px-3 py-1.5 bg-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-slate-200 ml-1">
                                                    Akun Anda
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                                <i data-feather="users" class="w-6 h-6 text-slate-400"></i>
                                            </div>
                                            <p class="text-slate-800 font-bold text-sm">Belum Ada Pegawai</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Script inisialisasi Feather Icons --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-app-layout>
