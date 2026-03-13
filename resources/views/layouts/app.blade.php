<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="font-sans antialiased bg-[#F7F8F0] text-slate-800" x-data="{ isMobileOpen: false }">

    <div class="flex h-screen overflow-hidden bg-[#F7F8F0]">

        {{-- OVERLAY BACKGROUND (Muncul saat sidebar terbuka) --}}
        <div x-show="isMobileOpen" x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="isMobileOpen = false">
        </div>

        {{-- SIDEBAR: Muncul dari KANAN di Mobile --}}
        <aside :class="isMobileOpen ? 'translate-x-0' : 'translate-x-full'"
            class="fixed inset-y-0 right-0 z-50 w-72 flex flex-col transition-transform duration-300 bg-[#0F2854] border-l border-white/10 shadow-[-10px_0_30px_rgba(15,40,84,0.2)] lg:static lg:translate-x-0 lg:border-l-0 lg:border-r lg:shadow-[10px_0_30px_rgba(15,40,84,0.2)]">
            @include('layouts.navigation')
        </aside>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden relative z-10 w-full">
            {{-- ======================================================= --}}
            {{-- TOPBAR MOBILE --}}
            {{-- ======================================================= --}}
            <div
                class="lg:hidden sticky top-0 flex items-center justify-between px-5 py-4 bg-[#0F2854] z-50 w-full shadow-md">

                {{-- Logo Teks di Kiri --}}
                <div class="flex items-center">
                    {{-- PERUBAHAN: Mengganti font-['Montserrat'] menjadi font-serif --}}
                    <span class="font-black font-serif text-white tracking-tight text-xl">
                        Smart<span class="text-[#CBA135]">PublicFacility</span>
                    </span>
                </div>

                {{-- Tombol Hamburger di Kanan --}}
                <button @click="isMobileOpen = true"
                    class="p-2 bg-white/10 border border-white/20 rounded-lg text-white shadow-sm hover:bg-[#CBA135] hover:text-[#0F2854] hover:border-[#CBA135] transition-all focus:outline-none">
                    <i data-feather="menu" class="w-5 h-5"></i>
                </button>
            </div>
            {{-- Slot Header Utama --}}
            @isset($header)
                <header class="relative w-full z-20">
                    <div class="w-full">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Slot Main Content --}}
            <main class="flex-1 w-full lg:px-4">
                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- SCRIPT NOTIFIKASI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            @if (session('success'))
                Swal.fire({
                    title: "{!! session('success') !!}",
                    icon: 'success',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    background: '#ffffff',
                    customClass: {
                        popup: '!rounded-full !px-8 !py-3 !shadow-2xl !border !border-slate-100 !mt-4',
                        title: '!text-sm !font-bold !text-slate-700',
                        icon: '!text-green-500'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: "{!! session('error') !!}",
                    icon: 'error',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 4000,
                    background: '#FEF2F2',
                    customClass: {
                        popup: '!rounded-full !px-8 !py-3 !shadow-2xl !border !border-red-100 !mt-4',
                        title: '!text-sm !font-bold !text-red-700',
                        icon: '!text-red-500'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif
        });
    </script>
</body>

</html>
