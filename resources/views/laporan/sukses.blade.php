<x-guest-layout>
    {{-- Import Animasi & Toastify CSS --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        /* Animasi Masuk Kartu */
        @keyframes springUp {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-spring-up {
            animation: springUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Ikon Centang Animasi Pop */
        @keyframes popIcon {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            70% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-pop {
            animation: popIcon 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

    {{-- Background Abu-abu Kehijauan Terang sesuai Welcome Page --}}
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-[#F4F6F6] px-4 sm:px-6 relative overflow-hidden font-sans">

        {{-- Latar Belakang Glow Navy Halus --}}
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-[#0F2854]/10 rounded-full blur-[100px] pointer-events-none z-0">
        </div>

        {{-- ================= KARTU UTAMA ================= --}}
        <div
            class="relative z-10 bg-white/95 backdrop-blur-xl p-8 sm:p-12 rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(15,40,84,0.1)] border border-white max-w-[420px] w-full text-center animate-spring-up">

            {{-- Ikon Sukses Navy --}}
            <div
                class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-blue-50 mb-6 relative animate-pop">
                <div class="absolute inset-0 rounded-full bg-[#0F2854]/10 scale-125 -z-10"></div>
                <svg class="h-10 w-10 text-[#0F2854]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 tracking-tight">Laporan Terkirim!</h2>
            <p class="text-slate-500 mb-8 text-sm font-medium leading-relaxed px-2">
                Terima kasih atas kepedulian Anda. Laporan kerusakan telah masuk antrean sistem kami.
            </p>

            {{-- KOTAK KODE TIKET (Warna Navy #0F2854) --}}
            <div class="bg-[#0F2854] rounded-3xl p-6 mb-8 relative shadow-lg shadow-[#0F2854]/20 group overflow-hidden">
                {{-- Aksen visual dalam kotak Navy --}}
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3">
                </div>

                {{-- Teks "Kode Tiket Anda" berwarna Putih --}}
                <p class="text-[10px] font-bold text-white uppercase tracking-[0.25em] mb-2 relative z-10">
                    Kode Tiket Anda
                </p>

                {{-- Teks Kode Tiket berwarna Putih --}}
                <p
                    class="text-3xl sm:text-4xl font-black text-white tracking-[0.15em] select-all font-mono relative z-10 drop-shadow-sm">
                    {{ $tiket }}
                </p>

                <p class="text-[11px] text-slate-300 mt-4 font-semibold relative z-10">
                    * Simpan kode ini untuk melacak status perbaikan.
                </p>
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="space-y-3">

                {{-- Tombol Salin Kode (Warna Putih) --}}
                <button type="button" onclick="copyTicketCode('{{ $tiket }}')"
                    class="w-full py-4 px-4 bg-white border-2 border-slate-200 hover:border-[#0F2854] text-[#0F2854] font-bold uppercase tracking-wider text-xs rounded-2xl transition-all duration-300 flex items-center justify-center gap-2 group active:scale-95 shadow-sm">
                    <svg class="w-4 h-4 text-[#0F2854] group-hover:scale-110 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    Salin Kode Tiket
                </button>

                {{-- Tombol Kembali (Warna Navy) --}}
                <a href="{{ url('/') }}"
                    class="flex w-full py-4 px-4 bg-[#0F2854] hover:bg-[#1A3A73] text-white font-bold uppercase tracking-wider text-xs rounded-2xl transition-all duration-300 justify-center items-center active:scale-95 shadow-md shadow-[#0F2854]/30">
                    Kembali ke Beranda
                </a>

            </div>

        </div>
    </div>

    {{-- Import Toastify JS --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Script Salin Kode & Notifikasi Pop-Up Kapsul --}}
    <script>
        function copyTicketCode(tiket) {
            // Salin ke clipboard
            navigator.clipboard.writeText(tiket).then(() => {
                // Munculkan Toastify sesuai format desain yang diminta
                Toastify({
                    text: "Kode tiket berhasil disalin!",
                    duration: 3000, 
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "#18181b",
                        color: "#ffffff",
                        borderRadius: "100px",
                        boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
                        padding: "12px 24px",
                        fontFamily: "'Inter', system-ui, -apple-system, sans-serif",
                        fontSize: "14px",
                        fontWeight: "600",
                        border: "1px solid #27272a"
                    }
                }).showToast();
            }).catch(err => {
                console.error('Gagal menyalin kode', err);
            });
        }
    </script>
</x-guest-layout>
