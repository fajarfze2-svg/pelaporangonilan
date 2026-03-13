<x-guest-layout>
    {{-- Import Fonts: Inter (Formal/Biasa) & Montserrat (Judul) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Modern SaaS Animations 2026 --}}
    <style>
        .ease-spring {
            transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes revealUp {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(-15px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .anim-reveal {
            animation: revealUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .anim-fade-right {
            animation: fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.15s;
        }

        .delay-300 {
            animation-delay: 0.2s;
        }

        .delay-400 {
            animation-delay: 0.25s;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>

    {{-- Background Halaman (Slate Sangat Terang) --}}
    <div
        class="min-h-screen w-full bg-[#F7F8F0] flex items-center justify-center p-4 sm:p-6 font-['Inter'] selection:bg-slate-800 selection:text-white relative overflow-hidden">

        {{-- ================= KARTU SEDERHANA (Tengah) ================= --}}
        <div
            class="w-full max-w-md bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)] border border-slate-100 p-8 sm:p-10 relative z-10 anim-reveal">

            {{-- Icon Keamanan --}}
            <div
                class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-slate-800 mb-6 anim-fade-right">
                <i data-feather="lock" class="w-5 h-5"></i>
            </div>

            {{-- Header Form --}}
            <div class="mb-8 anim-fade-right delay-100">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight mb-2 font-['Montserrat']">Perbarui Sandi
                </h2>
                <p class="text-xs font-medium text-slate-500 leading-relaxed">
                    Halo <span class="font-bold text-slate-800">{{ auth()->user()->name ?? 'Pengguna' }}</span>, Anda
                    menggunakan sandi sementara. Demi keamanan, silakan buat kata sandi baru.
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                {{-- Input Password Baru --}}
                <div class="space-y-1.5 anim-fade-right delay-200">
                    <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                        Sandi Baru
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-slate-800/10 focus:border-slate-800 focus:bg-white transition-all duration-300 ease-spring text-sm font-bold placeholder:font-medium placeholder:text-slate-400 tracking-widest"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px] text-red-500 font-bold" />
                </div>

                {{-- Input Konfirmasi Password --}}
                <div class="space-y-1.5 anim-fade-right delay-300">
                    <label for="password_confirmation"
                        class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                        Konfirmasi Sandi
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-slate-800/10 focus:border-slate-800 focus:bg-white transition-all duration-300 ease-spring text-sm font-bold placeholder:font-medium placeholder:text-slate-400 tracking-widest"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[10px] text-red-500 font-bold" />
                </div>

                {{-- Submit Button (Soft Black) --}}
                <div class="pt-4 anim-fade-right delay-400">
                    <button type="submit"
                        class="w-full py-3.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold uppercase tracking-widest text-[11px] shadow-lg shadow-slate-800/20 transition-all duration-300 ease-spring hover:-translate-y-0.5 active:scale-95 flex items-center justify-center relative overflow-hidden group">
                        <span class="relative z-10">Simpan Sandi Baru</span>
                        {{-- Efek Kilap (Shine) --}}
                        <div
                            class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent z-0">
                        </div>
                    </button>
                </div>
            </form>

            {{-- Form Logout / Batal --}}
            <div class="mt-8 pt-6 border-t border-slate-100 text-center anim-fade-right delay-400">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-[10px] font-bold text-slate-400 hover:text-red-500 uppercase tracking-widest transition-colors duration-300 ease-spring focus:outline-none">
                        Batal dan Keluar
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Inisialisasi Script Icon --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-guest-layout>
