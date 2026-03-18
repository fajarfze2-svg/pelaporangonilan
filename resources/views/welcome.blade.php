<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartPublicFacility - Layanan Pengaduan Resmi</title>

    {{-- Font Resmi Pemerintahan: Public Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        // Menerapkan Public Sans secara global ke seluruh elemen
                        sans: ['"Public Sans"', 'sans-serif'],
                    },
                    colors: {
                        gov: {
                            50: '#F8FAFC',
                            100: '#F1F5F9',
                            200: '#E2E8F0',
                            300: '#CBD5E1',
                            400: '#94A3B8',
                            500: '#64748B',
                            800: '#1E293B',
                            900: '#0F172A',
                        },
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
                    },
                    boxShadow: {
                        '3d': '0 10px 40px -10px rgba(15,40,84,0.15)',
                        '3d-hover': '0 20px 50px -10px rgba(15,40,84,0.25)',
                        'glow-gold': '0 4px 20px rgba(197, 160, 89, 0.4)',
                        'glass': 'inset 0 1px 1px rgba(255, 255, 255, 0.2), 0 8px 32px rgba(0, 0, 0, 0.1)',
                    },
                    animation: {
                        'blob': 'blob 15s infinite alternate ease-in-out',
                        'hero-zoom': 'slowZoomBlur 20s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        blob: {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '50%': {
                                transform: 'translate(20px, -30px) scale(1.05)'
                            },
                            '100%': {
                                transform: 'translate(-20px, 20px) scale(0.95)'
                            },
                        },
                        slowZoomBlur: {
                            '0%': {
                                transform: 'scale(1)',
                                filter: 'blur(0px)'
                            },
                            '100%': {
                                transform: 'scale(1.05)',
                                filter: 'blur(1px)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .reveal {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .delay-100 {
            transition-delay: 100ms;
        }

        .delay-200 {
            transition-delay: 200ms;
        }

        .delay-300 {
            transition-delay: 300ms;
        }

        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease;
            opacity: 0;
        }

        .faq-item.active .faq-content {
            max-height: 200px;
            opacity: 1;
        }

        .faq-icon {
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #F8FAFC;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0F2854;
        }
    </style>
</head>

<body class="font-sans bg-gov-50 text-gov-900 antialiased selection:bg-navy-500 selection:text-white overflow-x-hidden">

    {{-- ================= NAVBAR ================= --}}
    <nav id="navbar"
        class="fixed top-4 left-0 right-0 z-50 transition-all duration-500 px-4 sm:px-6 flex justify-center">
        <div id="nav-container"
            class="relative w-full max-w-5xl bg-navy-900/50 backdrop-blur-md border border-white/10 rounded-full p-2 flex items-center justify-between transition-all duration-500 shadow-glass">

            {{-- 1. Sisi Kiri: Hamburger Menu (Hanya Mobile) --}}
            <div class="flex items-center z-10">
                <button id="mobile-menu-btn"
                    class="md:hidden w-10 h-10 ml-1 bg-white/10 border border-white/20 rounded-full flex items-center justify-center text-white active:scale-90 transition-all">
                    <i data-feather="menu" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- 2. Sisi Tengah: Navigasi Desktop (Benar-benar Center secara Absolut) --}}
            {{-- whitespace-nowrap memastikan teks tidak terbagi atas bawah --}}
            <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center gap-1 text-sm font-semibold text-white whitespace-nowrap"
                id="nav-menu">
                <a href="#"
                    class="nav-link px-4 py-2 rounded-full hover:bg-white/10 hover:text-gold-400 transition-all tracking-wide">Beranda</a>
                <a href="#layanan"
                    class="nav-link px-4 py-2 rounded-full hover:bg-white/10 hover:text-gold-400 transition-all tracking-wide">Layanan</a>
                <a href="#tracking"
                    class="nav-link px-4 py-2 rounded-full hover:bg-white/10 hover:text-gold-400 transition-all tracking-wide">Cek
                    Status</a>
                <a href="#faq"
                    class="nav-link px-4 py-2 rounded-full hover:bg-white/10 hover:text-gold-400 transition-all tracking-wide">Bantuan</a>
            </div>

            {{-- 3. Sisi Kanan: Tombol Portal --}}
            <div class="flex items-center z-10 mr-1">
                @auth
                    <a href="{{ url('/dashboard') }}" id="nav-btn"
                        class="whitespace-nowrap flex items-center gap-2 px-5 md:px-6 py-2.5 bg-gold-500 text-navy-900 rounded-full text-xs md:text-sm font-bold active:scale-95 transition-all shadow-glow-gold hover:bg-gold-400 tracking-wide">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" id="nav-btn"
                        class="whitespace-nowrap flex items-center gap-2 px-5 md:px-6 py-2.5 bg-gold-500 text-navy-900 rounded-full text-xs md:text-sm font-bold active:scale-95 transition-all shadow-glow-gold group hover:bg-gold-400 tracking-wide">
                        <i data-feather="log-in" class="w-4 h-4 hidden sm:block"></i> Portal Admin
                    </a>
                @endauth
            </div>

        </div>
    </nav>
    </div>
    </div>

    {{-- Mobile Drawer (Menu Overlay) --}}
    <div id="mobile-drawer" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-navy-950/80 backdrop-blur-sm" id="drawer-overlay"></div>
        <div class="absolute top-4 right-4 left-4 bg-navy-900 border border-white/10 rounded-3xl p-6 shadow-2xl transform transition-transform duration-300 -translate-y-full"
            id="drawer-content">
            <div class="flex justify-between items-center mb-8">
                <span class="text-gold-500 font-black tracking-widest text-xs uppercase">Menu Navigasi</span>
                <button id="close-menu-btn"
                    class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center text-white">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="flex flex-col gap-4">
                <a href="#"
                    class="mobile-link text-white text-lg font-bold px-4 py-3 rounded-xl hover:bg-white/5 hover:text-gold-400 transition-all">Beranda</a>
                <a href="#layanan"
                    class="mobile-link text-white text-lg font-bold px-4 py-3 rounded-xl hover:bg-white/5 hover:text-gold-400 transition-all">Layanan</a>
                <a href="#tracking"
                    class="mobile-link text-white text-lg font-bold px-4 py-3 rounded-xl hover:bg-white/5 hover:text-gold-400 transition-all">Cek
                    Status</a>
                <a href="#faq"
                    class="mobile-link text-white text-lg font-bold px-4 py-3 rounded-xl hover:bg-white/5 hover:text-gold-400 transition-all">Bantuan</a>
            </div>
        </div>
    </div>
    </nav>

    {{-- ================= HERO SECTION ================= --}}
    <section
        class="min-h-screen flex flex-col justify-center items-center text-center relative px-6 overflow-hidden bg-navy-900">

        <div class="absolute inset-0 z-0 overflow-hidden bg-navy-900">
            <div class="w-full h-full bg-[url('/solo.jpg')] bg-cover bg-center animate-hero-zoom"></div>

            <div class="absolute inset-0 bg-navy-900/85 backdrop-blur-[2px]"></div>
            <div class="absolute bottom-0 w-full h-20 bg-gradient-to-t from-gov-50 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto reveal mt-16">
            <span
                class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[11px] font-bold uppercase tracking-[0.2em] mb-8 shadow-sm cursor-default">
                <span class="w-2 h-2 rounded-full bg-gold-500 animate-pulse"></span>
                Portal Resmi Masyarakat Desa Gonilan
            </span>

            {{-- Judul dengan Public Sans terlihat jauh lebih elegan dan formal --}}
            <h1
                class="text-4xl md:text-6xl lg:text-7xl font-extrabold leading-snug text-white mb-6 tracking-tight drop-shadow-lg">
                Laporan Anda, <br>
                <span class="text-gold-400 inline-block mt-3 md:mt-4">Tindakan Kami.</span>
            </h1>

            <p
                class="text-base md:text-lg text-gov-100 font-medium leading-relaxed mb-12 max-w-2xl mx-auto drop-shadow-md">
                Sampaikan laporan kerusakan fasilitas di sekitar anda dengan mudah dan pantau progres penanganannya
                secara real-time.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('laporan.create') }}"
                    class="px-8 py-4 bg-gold-500 text-navy-900 rounded-2xl text-sm font-bold shadow-glow-gold hover:bg-gold-400 hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 group tracking-wide">
                    <i data-feather="edit-3"
                        class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300"></i> Buat Laporan Baru
                </a>

                <a href="#tracking"
                    class="px-8 py-4 bg-white/5 backdrop-blur-md text-white border border-white/40 rounded-2xl text-sm font-bold hover:bg-white/10 hover:border-white hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 tracking-wide">
                    <i data-feather="search" class="w-5 h-5"></i> Lacak Tiket
                </a>
            </div>
        </div>
    </section>

    {{-- ================= STATS SECTION ================= --}}
    <section class="relative z-20 -mt-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <div
                class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-10 shadow-3d border border-gov-100 grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gov-100 relative overflow-hidden">

                {{-- Garis Gradien Atas --}}
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-navy-500 via-gold-500 to-navy-500">
                </div>

                {{-- KARTU 1: Total Laporan --}}
                <div
                    class="text-center px-4 hover:-translate-y-2 active:scale-95 transition-transform duration-300 cursor-default group">
                    <div
                        class="w-14 h-14 mx-auto bg-gov-50 rounded-2xl flex items-center justify-center mb-4 border border-gov-100 group-hover:border-gold-500 transition-colors">
                        <i data-feather="file-text"
                            class="w-6 h-6 text-navy-500 group-hover:text-gold-500 transition-colors"></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-navy-900 tracking-tight counter"
                        data-target="{{ $totalLaporan ?? 0 }}">0</h3>
                    <p class="text-[11px] font-bold text-gov-500 uppercase tracking-widest mt-2">Total Laporan</p>
                </div>

                {{-- KARTU 2: Selesai Ditangani --}}
                <div
                    class="text-center px-4 hover:-translate-y-2 active:scale-95 transition-transform duration-300 cursor-default group">
                    <div
                        class="w-14 h-14 mx-auto bg-gov-50 rounded-2xl flex items-center justify-center mb-4 border border-gov-100 group-hover:border-gold-500 transition-colors">
                        <i data-feather="check-circle"
                            class="w-6 h-6 text-navy-500 group-hover:text-gold-500 transition-colors"></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-navy-900 tracking-tight counter"
                        data-target="{{ $laporanSelesai ?? 0 }}">0</h3>
                    <p class="text-[11px] font-bold text-gov-500 uppercase tracking-widest mt-2">Selesai Ditangani</p>
                </div>

                {{-- KARTU 3: Sedang Dikerjakan --}}
                <div
                    class="text-center px-4 hover:-translate-y-2 active:scale-95 transition-transform duration-300 cursor-default group">
                    <div
                        class="w-14 h-14 mx-auto bg-gov-50 rounded-2xl flex items-center justify-center mb-4 border border-gov-100 group-hover:border-gold-500 transition-colors">
                        <i data-feather="tool"
                            class="w-6 h-6 text-navy-500 group-hover:text-gold-500 transition-colors"></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-navy-900 tracking-tight counter"
                        data-target="{{ $sedangDiproses ?? 0 }}">0</h3>
                    <p class="text-[11px] font-bold text-gov-500 uppercase tracking-widest mt-2">Sedang Dikerjakan</p>
                </div>

                {{-- KARTU 4: Laporan Bulan Ini --}}
                <div
                    class="text-center px-4 hover:-translate-y-2 active:scale-95 transition-transform duration-300 cursor-default group">
                    <div
                        class="w-14 h-14 mx-auto bg-gov-50 rounded-2xl flex items-center justify-center mb-4 border border-gov-100 group-hover:border-gold-500 transition-colors">
                        <i data-feather="calendar"
                            class="w-6 h-6 text-navy-500 group-hover:text-gold-500 transition-colors"></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-navy-900 tracking-tight counter"
                        data-target="{{ $laporanBulanIni ?? 0 }}">0</h3>
                    <p class="text-[11px] font-bold text-gov-500 uppercase tracking-widest mt-2">Laporan Bulan Ini</p>
                </div>

            </div>
        </div>
    </section>
    {{-- ================= LAYANAN SECTION ================= --}}
    <section id="layanan" class="py-24 bg-gov-50 relative">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16 reveal">
                <span class="text-gold-500 font-bold text-xs uppercase tracking-[0.2em]">Kategori Pengaduan</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-navy-900 tracking-tight mt-2">Ruang Lingkup Layanan
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white p-8 rounded-[2rem] border border-gov-100 shadow-3d hover:shadow-3d-hover hover:-translate-y-3 hover:border-gold-400 transition-all duration-300 reveal group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:bg-gold-500 group-hover:text-white transition-all duration-300 mb-6">
                        <i data-feather="sun" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-navy-900 mb-2 text-lg tracking-tight">Penerangan Jalan</h4>
                    <p class="text-sm text-gov-500 leading-relaxed font-medium">Pelaporan lampu PJU mati, korsleting,
                        atau tiang listrik rusak.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-[2rem] border border-gov-100 shadow-3d hover:shadow-3d-hover hover:-translate-y-3 hover:border-gold-400 transition-all duration-300 reveal delay-100 group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-gold-500 group-hover:text-white transition-all duration-300 mb-6">
                        <i data-feather="map" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-navy-900 mb-2 text-lg tracking-tight">Jalan & Trotoar</h4>
                    <p class="text-sm text-gov-500 leading-relaxed font-medium">Perbaikan jalan berlubang, aspal
                        mengelupas, dan trotoar publik.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-[2rem] border border-gov-100 shadow-3d hover:shadow-3d-hover hover:-translate-y-3 hover:border-gold-400 transition-all duration-300 reveal delay-200 group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-gold-500 group-hover:text-white transition-all duration-300 mb-6">
                        <i data-feather="trash-2" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-navy-900 mb-2 text-lg tracking-tight">Kebersihan</h4>
                    <p class="text-sm text-gov-500 leading-relaxed font-medium">Pengangkutan sampah liar dan
                        pembersihan drainase/selokan.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-[2rem] border border-gov-100 shadow-3d hover:shadow-3d-hover hover:-translate-y-3 hover:border-gold-400 transition-all duration-300 reveal delay-300 group cursor-pointer">
                    <div
                        class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-gold-500 group-hover:text-white transition-all duration-300 mb-6">
                        <i data-feather="umbrella" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-navy-900 mb-2 text-lg tracking-tight">Fasilitas Umum</h4>
                    <p class="text-sm text-gov-500 leading-relaxed font-medium">Perbaikan bangku taman, halte bus, dan
                        area bermain anak.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= TRACKING SECTION ================= --}}
    <section id="tracking" class="py-24 bg-navy-500 relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-6 text-center reveal relative z-10">
            <div
                class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-sm flex items-center justify-center mx-auto mb-6">
                <i data-feather="search" class="w-6 h-6 text-gold-500"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-3">Lacak Status Pengaduan</h2>
            <p class="text-gov-200 text-sm font-medium mb-10">
                Masukkan nomor tiket Anda untuk memantau progres penanganan oleh tim teknisi secara real-time.
            </p>

            <form action="{{ route('laporan.cek') }}" method="GET"
                class="flex flex-col sm:flex-row gap-3 justify-center items-center max-w-2xl mx-auto">
                <div class="relative w-full flex-1 group">
                    <i data-feather="hash"
                        class="absolute left-5 top-1/2 -translate-y-1/2 text-gov-400 w-5 h-5 group-focus-within:text-gold-500 transition-colors"></i>
                    <input type="text" name="tiket" required autocomplete="off"
                        class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white focus:outline-none focus:ring-4 focus:ring-gold-500/40 font-bold text-navy-900 transition-all placeholder:text-gov-400 shadow-md tracking-wide"
                        placeholder="Contoh: TIC-8921...">
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-10 py-4 bg-gold-500 text-navy-900 rounded-2xl hover:bg-gold-400 transition-all duration-300 font-bold text-sm shadow-glow-gold hover:-translate-y-1 active:scale-95 whitespace-nowrap tracking-wide">
                    Cari Laporan
                </button>
            </form>
        </div>
    </section>

    {{-- ================= LIVE UPDATE SECTION ================= --}}
    <section class="py-24 bg-gov-50 reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10 border-b border-gov-200 pb-5">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900 tracking-tight">Live Update</h2>
                    <p class="text-sm text-gov-500 mt-2 font-medium">Daftar laporan masyarakat terbaru yang masuk ke
                        dalam sistem.</p>
                </div>
                <div
                    class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-navy-500 bg-white px-4 py-2 rounded-xl border border-gov-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-gold-500 animate-pulse"></span>
                    Sinkronisasi Aktif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($laporanTerbaru ?? [] as $item)
                    <div
                        class="bg-white p-6 rounded-[2rem] border border-gov-100 shadow-3d hover:shadow-3d-hover hover:-translate-y-2 hover:border-gold-400 transition-all duration-300 cursor-pointer active:scale-[0.98]">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-bold text-gov-400 uppercase tracking-widest">
                                {{ $item->created_at->diffForHumans() }}
                            </span>
                            @if ($item->status == 'baru' || $item->status == 'menunggu')
                                <span
                                    class="px-3 py-1 bg-blue-50 text-blue-600 rounded-md text-[9px] font-bold uppercase tracking-wider">Masuk</span>
                            @elseif ($item->status == 'proses')
                                <span
                                    class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-md text-[9px] font-bold uppercase tracking-wider">Diproses</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-md text-[9px] font-bold uppercase tracking-wider">Selesai</span>
                            @endif
                        </div>

                        <h4 class="font-bold text-navy-900 mb-2 line-clamp-1 text-lg tracking-tight">
                            {{ $item->lokasi }}</h4>
                        <p class="text-sm text-gov-500 font-medium line-clamp-2 mb-6">"{{ $item->deskripsi }}"</p>

                        <div class="flex items-center gap-3 pt-4 border-t border-gov-100">
                            <div
                                class="w-8 h-8 rounded-full bg-gov-50 flex items-center justify-center text-[10px] font-bold text-navy-500 border border-gov-200">
                                {{ substr($item->nama, 0, 1) }}
                            </div>
                            <span class="text-xs font-bold text-gov-500">{{ substr($item->nama, 0, 3) }}***</span>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-16 text-center bg-white border border-dashed border-gov-300 rounded-[2rem]">
                        <div class="w-16 h-16 bg-gov-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i data-feather="inbox" class="w-6 h-6 text-gov-400"></i>
                        </div>
                        <p class="text-sm font-bold text-gov-500 uppercase tracking-widest">Belum ada laporan terbaru.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= FAQ SECTION ================= --}}
    <section id="faq" class="py-24 bg-white reveal">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-gold-500 font-bold text-xs uppercase tracking-[0.2em]">Bantuan</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-navy-900 tracking-tight mt-2">Pertanyaan Umum</h2>
            </div>

            <div class="space-y-4">
                <div
                    class="faq-item border border-gov-100 rounded-2xl cursor-pointer hover:border-gold-400 hover:shadow-3d active:scale-[0.99] transition-all duration-300 bg-white">
                    <div class="px-6 py-5 flex justify-between items-center faq-question">
                        <h4 class="font-bold text-navy-900 text-sm">Bagaimana cara membuat laporan baru?</h4>
                        <div class="w-8 h-8 rounded-full bg-gov-50 flex items-center justify-center shrink-0">
                            <i data-feather="chevron-down" class="faq-icon text-gov-500 w-4 h-4"></i>
                        </div>
                    </div>
                    <div class="faq-content px-6 pb-0 text-sm text-gov-500 leading-relaxed font-medium">
                        Klik tombol "Buat Laporan Baru" di halaman utama. Isi form identitas, pilih lokasi secara akurat
                        di peta, deskripsikan masalah, dan unggah foto bukti kerusakan.
                        <div class="pb-6"></div>
                    </div>
                </div>

                <div
                    class="faq-item border border-gov-100 rounded-2xl cursor-pointer hover:border-gold-400 hover:shadow-3d active:scale-[0.99] transition-all duration-300 bg-white">
                    <div class="px-6 py-5 flex justify-between items-center faq-question">
                        <h4 class="font-bold text-navy-900 text-sm">Apakah identitas pelapor dirahasiakan?</h4>
                        <div class="w-8 h-8 rounded-full bg-gov-50 flex items-center justify-center shrink-0">
                            <i data-feather="chevron-down" class="faq-icon text-gov-500 w-4 h-4"></i>
                        </div>
                    </div>
                    <div class="faq-content px-6 pb-0 text-sm text-gov-500 leading-relaxed font-medium">
                        Tentu. Kami mengenkripsi data Anda dan menyamarkan nama pelapor di halaman publik (hanya inisial
                        yang terlihat) untuk menjaga privasi dan keamanan Anda.
                        <div class="pb-6"></div>
                    </div>
                </div>

                <div
                    class="faq-item border border-gov-100 rounded-2xl cursor-pointer hover:border-gold-400 hover:shadow-3d active:scale-[0.99] transition-all duration-300 bg-white">
                    <div class="px-6 py-5 flex justify-between items-center faq-question">
                        <h4 class="font-bold text-navy-900 text-sm">Berapa lama estimasi perbaikan dilakukan?</h4>
                        <div class="w-8 h-8 rounded-full bg-gov-50 flex items-center justify-center shrink-0">
                            <i data-feather="chevron-down" class="faq-icon text-gov-500 w-4 h-4"></i>
                        </div>
                    </div>
                    <div class="faq-content px-6 pb-0 text-sm text-gov-500 leading-relaxed font-medium">
                        Tergantung tingkat urgensi. Tim admin akan memvalidasi laporan dalam 1x24 jam, setelah itu
                        teknisi terkait akan langsung ditugaskan ke lokasi untuk penanganan secepatnya.
                        <div class="pb-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-[#0F2854] pt-10 pb-8 border-t border-white/10 relative overflow-hidden">
        {{-- Kontainer Flex Responsif: Kolom (tengah) di HP, Baris (kiri-kanan) di Desktop --}}
        <div
            class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-5 md:gap-6 relative z-10 text-center md:text-left">

            {{-- Logo Teks (Font Serif, Emas, Tanpa Ikon) --}}
            <div class="flex items-center justify-center md:justify-start">
                <span class="font-black font-serif text-white tracking-tight text-xl md:text-2xl">
                    Smart<span class="text-[#CBA135]">PublicFacility</span>
                </span>
            </div>

            {{-- Teks Copyright (Font Sans Formal) --}}
            <p class="text-xs font-medium text-slate-400 font-sans">
                &copy; {{ date('Y') }} Sistem Pengaduan Fasilitas Publik. All rights reserved.
            </p>

        </div>
    </footer>

    <script>
        // Inisialisasi Feather Icons
        feather.replace();

        // 1. Intersection Observer untuk Animasi Reveal
        const observerOptions = {
            threshold: 0.1
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

        // 2. Counter Animation
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = +counter.getAttribute('data-target');
                    const duration = 1500;
                    const increment = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            counter.innerText = Math.ceil(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCounter();
                    counterObserver.unobserve(counter);
                }
            });
        }, {
            threshold: 0.5
        });
        counters.forEach(counter => counterObserver.observe(counter));

        // 3. FAQ Accordion
        const faqItems = document.querySelectorAll(".faq-item");
        faqItems.forEach(item => {
            item.addEventListener("click", () => {
                const isActive = item.classList.contains("active");
                faqItems.forEach(otherItem => otherItem.classList.remove("active"));
                if (!isActive) item.classList.add("active");
            });
        });

        // 4. Navbar Scroll Effect & Mobile Menu Logic
        const navbar = document.getElementById("navbar");
        const navContainer = document.getElementById("nav-container");
        const navMenu = document.getElementById("nav-menu");
        const navLinks = document.querySelectorAll(".nav-link");
        const navBtn = document.getElementById("nav-btn");

        // Element Mobile Baru
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        const drawerContent = document.getElementById('drawer-content');
        const overlay = document.getElementById('drawer-overlay');

        // Fungsi Toggle Mobile Menu
        function toggleMenu() {
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                setTimeout(() => drawerContent.classList.remove('-translate-y-full'), 10);
            } else {
                drawerContent.classList.add('-translate-y-full');
                setTimeout(() => drawer.classList.add('hidden'), 300);
            }
        }

        if (mobileBtn) mobileBtn.addEventListener('click', toggleMenu);
        if (closeBtn) closeBtn.addEventListener('click', toggleMenu);
        if (overlay) overlay.addEventListener('click', toggleMenu);
        document.querySelectorAll('.mobile-link').forEach(link => link.addEventListener('click', toggleMenu));

        // Scroll Effect
        window.addEventListener("scroll", () => {
            const mobileBtn = document.getElementById('mobile-menu-btn'); // Ambil tombol hamburger

            if (window.scrollY > 20) {
                navbar.classList.replace("top-4", "top-2");
                navContainer.classList.remove("bg-navy-900/50", "border-white/10");
                navContainer.classList.add("bg-white", "border-slate-200", "shadow-lg"); // White solid agar kontras

                // Ubah warna teks menu desktop jadi gelap
                if (navMenu) {
                    navMenu.classList.remove("text-white");
                    navMenu.classList.add("text-navy-900");
                }

                // Ubah warna tombol hamburger mobile jadi gelap
                if (mobileBtn) {
                    mobileBtn.classList.remove("text-white", "bg-white/10", "border-white/20");
                    mobileBtn.classList.add("text-navy-900", "bg-slate-100", "border-slate-300");
                }

                navLinks.forEach(link => {
                    link.classList.remove("hover:bg-white/10", "hover:text-gold-400");
                    link.classList.add("hover:bg-slate-100", "hover:text-gold-600");
                });

                if (navBtn) {
                    // Tombol portal tetap terlihat tapi disesuaikan sedikit
                    navBtn.classList.remove("shadow-glow-gold");
                    navBtn.classList.add("shadow-md");
                }
            } else {
                navbar.classList.replace("top-2", "top-4");
                navContainer.classList.add("bg-navy-900/50", "border-white/10");
                navContainer.classList.remove("bg-white", "border-slate-200", "shadow-lg");

                // Kembalikan warna teks menu desktop ke putih
                if (navMenu) {
                    navMenu.classList.add("text-white");
                    navMenu.classList.remove("text-navy-900");
                }

                // Kembalikan warna tombol hamburger mobile ke putih
                if (mobileBtn) {
                    mobileBtn.classList.add("text-white", "bg-white/10", "border-white/20");
                    mobileBtn.classList.remove("text-navy-900", "bg-slate-100", "border-slate-300");
                }

                navLinks.forEach(link => {
                    link.classList.add("hover:bg-white/10", "hover:text-gold-400");
                    link.classList.remove("hover:bg-slate-100", "hover:text-gold-600");
                });

                if (navBtn) {
                    navBtn.classList.add("shadow-glow-gold");
                    navBtn.classList.remove("shadow-md");
                }
            }
        });
    </script>
</body>

</html>
