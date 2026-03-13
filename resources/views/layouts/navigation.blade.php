{{-- Teks utama di sidebar diubah menjadi text-white --}}
<nav class="h-full flex flex-col relative overflow-hidden text-white">

    {{-- ================= BACKGROUND AMBIENT GLOW ================= --}}
    {{-- Glow transparan agar memberi tekstur elegan pada warna Navy yang gelap --}}
    <div class="absolute top-[-10%] left-[-20%] w-64 h-64 bg-white/5 rounded-full blur-[80px] pointer-events-none z-0">
    </div>
    <div
        class="absolute bottom-[20%] right-[-20%] w-48 h-48 bg-white/5 rounded-full blur-[60px] pointer-events-none z-0">
    </div>

    {{-- ================= HEADER MOBILE (Tombol Close) ================= --}}
    <div class="lg:hidden flex items-center justify-between p-4 border-b border-white/10 relative z-10 bg-black/10">
        <span class="font-bold text-sm text-white">Menu Navigasi</span>
        <button @click="isMobileOpen = false"
            class="p-1.5 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    {{-- ================= MENU ================= --}}
    <div class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar relative z-10">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 group
                {{ request()->routeIs('dashboard')
                    ? 'bg-white/20 text-white font-bold border border-white/20 shadow-inner'
                    : 'text-white/80 hover:text-white hover:bg-white/10 border border-transparent' }}">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
            </svg>

            <span class="text-sm whitespace-nowrap">Dashboard</span>
        </a>

        @if (auth()->user()->role === 'admin')
            <div class="pt-6 pb-2 px-2 text-[11px] font-extrabold uppercase tracking-widest text-white/50">
                Menu Utama
            </div>

            {{-- LAPORAN --}}
            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 group
                {{ request()->routeIs('admin.laporan*')
                    ? 'bg-white/20 text-white font-bold border border-white/20 shadow-inner'
                    : 'text-white/80 hover:text-white hover:bg-white/10 border border-transparent' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.laporan*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6M9 8h6m2 12H7a2 2 0 01-2-2V6a2 2 0 012-2h5l5 5v9a2 2 0 01-2 2z" />
                </svg>

                <span class="text-sm whitespace-nowrap">Laporan Masuk</span>
            </a>

            {{-- USERS --}}
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 group
                {{ request()->routeIs('admin.users*')
                    ? 'bg-white/20 text-white font-bold border border-white/20 shadow-inner'
                    : 'text-white/80 hover:text-white hover:bg-white/10 border border-transparent' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.users*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5V4H2v16h5m10 0v-4a4 4 0 00-8 0v4m8 0H9" />
                </svg>

                <span class="text-sm whitespace-nowrap">Data Pegawai</span>
            </a>
        @endif
    </div>

    {{-- ================= PROFILE ================= --}}
    <div class="p-4 border-t border-white/10 bg-black/20 relative z-10 shrink-0">

        <div class="flex items-center gap-3 mb-4 px-1">
            {{-- Avatar: Latar putih, teks disamakan dengan warna Navy --}}
            <div
                class="w-10 h-10 shrink-0 rounded-full bg-white text-[#0F2854] flex items-center justify-center font-black text-sm shadow-md">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>

            <div class="overflow-hidden leading-tight">
                <div class="text-sm font-bold text-white truncate">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-[10px] font-bold tracking-widest text-white/60 mt-0.5">
                    {{ Auth::user()->role == 'admin' ? 'Admin' : Auth::user()->role }}
                </div>
            </div>
        </div>

        {{-- Logout Button: Menyatu dengan tema, merah transparan saat di-hover --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 py-2.5 rounded-xl bg-white/10 text-white hover:bg-red-500 hover:text-white border border-transparent hover:border-red-400 transition-all text-sm font-bold focus:outline-none">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>

                <span>Keluar</span>
            </button>
        </form>

    </div>
</nav>

<style>
    /* Scrollbar diubah warnanya menjadi putih transparan */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.4);
    }
</style>
