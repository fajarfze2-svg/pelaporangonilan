<x-guest-layout>
    {{-- Import Font: Public Sans (Global Font Pemerintahan) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- Import Toastify CSS --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Public Sans"', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            400: '#1A3A73',
                            500: '#0F2854',
                            600: '#0A1B38',
                            900: '#050D1C',
                        },
                        gold: {
                            400: '#D4B572',
                            500: '#C5A059',
                            600: '#B08D4C',
                        }
                    }
                }
            }
        }
    </script>

    {{-- Modern SaaS Animations --}}
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

        @keyframes floatIcon {
            0% {
                transform: translateY(0px) rotate(-5deg);
            }

            50% {
                transform: translateY(-15px) rotate(-8deg);
            }

            100% {
                transform: translateY(0px) rotate(-5deg);
            }
        }

        .animate-float {
            animation: floatIcon 10s ease-in-out infinite;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>

    <div
        class="min-h-screen w-full bg-slate-50 flex items-center justify-center p-4 sm:p-6 lg:p-8 font-sans selection:bg-navy-500 selection:text-white">
        <div
            class="w-full max-w-4xl bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(15,40,84,0.15)] flex flex-col lg:flex-row overflow-hidden relative z-10 anim-reveal">

            {{-- KIRI: BRANDING --}}
            <div
                class="w-full lg:w-[45%] bg-navy-500 p-10 lg:p-12 relative flex flex-col justify-center overflow-hidden border-b lg:border-b-0 lg:border-r border-navy-600/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"
                    class="absolute -right-16 -bottom-16 w-[350px] h-[350px] lg:w-[450px] lg:h-[450px] text-white opacity-[0.05] animate-float select-none pointer-events-none">
                    <path
                        d="M160-120v-112h640v112H160Zm8-208v-312h80v312h-80Zm240 0v-312h80v312h-80Zm240 0v-312h80v312h-80ZM120-710v-110l360-180 360 180v110H120Zm80-30h560l-280-140-280 140Z" />
                </svg>

                <div class="relative z-10">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-[9px] font-bold uppercase tracking-widest text-white mb-6 shadow-sm anim-fade-right">
                        <span class="w-1.5 h-1.5 rounded-full bg-gold-500 animate-pulse"></span>
                        Portal Internal
                    </div>
                    <h1
                        class="text-3xl lg:text-4xl font-black text-white leading-[1.15] mb-5 tracking-tight anim-fade-right delay-100">
                        Smart <br> Public <br> Facility.
                    </h1>
                    <p
                        class="text-slate-300 text-xs lg:text-sm leading-relaxed max-w-[280px] font-medium anim-fade-right delay-200">
                        Sistem manajemen pelaporan terpadu. Terintegrasi langsung untuk Administrator dan Teknisi
                        lapangan.
                    </p>
                </div>
            </div>

            {{-- KANAN: FORM --}}
            <div class="w-full lg:w-[55%] p-8 sm:p-12 relative bg-white flex flex-col justify-center">
                <a href="{{ url('/') }}"
                    class="absolute top-6 right-6 text-[10px] font-bold text-slate-400 hover:text-navy-900 uppercase tracking-widest transition-colors duration-300 ease-spring">
                    Kembali &rarr;
                </a>

                <div class="w-full max-w-[320px] mx-auto">
                    <div class="mb-8 mt-4 sm:mt-0 anim-fade-right delay-100">
                        <p class="text-xs font-medium text-slate-500">Silakan masukkan kredensial sistem Anda.</p>
                    </div>

                    <x-auth-session-status
                        class="mb-6 bg-slate-50 text-navy-900 p-3.5 rounded-xl text-[11px] font-bold border border-slate-200 text-center shadow-sm"
                        :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <div class="space-y-1.5 anim-fade-right delay-200">
                            <label for="username"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Username</label>
                            <input id="username" type="text" name="username" :value="old('username')" required
                                autofocus
                                class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-navy-900 rounded-xl focus:ring-2 focus:ring-navy-500/20 focus:border-navy-500 focus:bg-white transition-all duration-300 ease-spring text-sm font-semibold placeholder:font-medium placeholder:text-slate-400"
                                placeholder="Ketik username Anda">
                            <x-input-error :messages="$errors->get('username')" class="mt-1 text-[10px] text-red-500 font-bold" />
                        </div>

                        <div class="space-y-1.5 anim-fade-right delay-300">
                            <div class="flex items-center justify-between">
                                <label for="password"
                                    class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kata
                                    Sandi</label>

                                {{-- BUTTON LUPA SANDI DENGAN ONCLICK BARU --}}
                                <button type="button" onclick="showForgotPasswordToast()"
                                    class="text-[9px] font-bold uppercase tracking-wider text-slate-400 hover:text-navy-900 transition-colors focus:outline-none">
                                    Lupa Sandi?
                                </button>
                            </div>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-navy-900 rounded-xl focus:ring-2 focus:ring-navy-500/20 focus:border-navy-500 focus:bg-white transition-all duration-300 ease-spring text-sm font-bold placeholder:font-medium placeholder:text-slate-400 tracking-widest"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px] text-red-500 font-bold" />
                        </div>

                        <div class="flex items-center anim-fade-right delay-400 pt-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded border-slate-300 text-navy-500 shadow-sm focus:ring-navy-500 w-3.5 h-3.5 cursor-pointer transition-colors">
                                <span
                                    class="ml-2.5 text-[11px] font-semibold text-slate-500 group-hover:text-navy-900 transition-colors">Ingat
                                    saya di perangkat ini</span>
                            </label>
                        </div>

                        <div class="pt-3 anim-fade-right delay-400">
                            <button type="submit"
                                class="w-full py-3.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold uppercase tracking-widest text-[11px] shadow-lg shadow-slate-800/20 transition-all duration-300 ease-spring hover:-translate-y-0.5 active:scale-95 flex items-center justify-center relative overflow-hidden group">
                                <span class="relative z-10">Masuk</span>
                                <div
                                    class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent z-0">
                                </div>
                            </button>
                        </div>
                    </form>

                    <div class="mt-10 pt-5 border-t border-slate-100 text-center anim-fade-right delay-400">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">&copy;
                            {{ date('Y') }} SmartPublicFacility</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Import Toastify JS --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Script Notifikasi Pop-Up Kapsul --}}
    <script>
        function showForgotPasswordToast() {
            Toastify({
                text: "Hubungi Administrator untuk reset sandi Anda.",
                duration: 3500,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "#18181b", // Hitam pekat modern
                    color: "#ffffff",
                    borderRadius: "100px", // Kapsul
                    boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
                    padding: "12px 24px",
                    fontFamily: "'Public Sans', system-ui, -apple-system, sans-serif", // Font disamakan
                    fontSize: "13px",
                    fontWeight: "600",
                    border: "1px solid #27272a",
                    letterSpacing: "0.025em"
                }
            }).showToast();
        }
    </script>
</x-guest-layout>
