<x-app-layout>
    {{-- 1. LEAFLET CSS (Peta) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <x-slot name="header">
        {{-- Import Font Google: Montserrat (Judul) & Inter (Teks UI) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        {{-- Wrapper Header: Solid & Statis (Akan ikut ter-scroll) --}}
        <div class="relative pt-6 pb-6 bg-white border-b border-slate-200 overflow-hidden z-10">

            {{-- Pancaran Glow Sangat Halus (Pudar dan Formal) --}}
            <div
                class="absolute top-[-50%] right-[10%] w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[100px] pointer-events-none z-0">
            </div>
            <div
                class="absolute bottom-[-30%] left-[5%] w-[400px] h-[400px] bg-slate-400/10 rounded-full blur-[80px] pointer-events-none z-0">
            </div>

            {{-- Konten Header --}}
            <div
                class="relative z-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-5">

                {{-- KIRI: Judul dan Deskripsi --}}
                <div>
                    {{-- Logika Sapaan Waktu Otomatis --}}
                    @php
                        $hour = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H');
                        if ($hour >= 5 && $hour < 11) {
                            $greeting = 'Selamat Pagi';
                        } elseif ($hour >= 11 && $hour < 15) {
                            $greeting = 'Selamat Siang';
                        } elseif ($hour >= 15 && $hour < 18) {
                            $greeting = 'Selamat Sore';
                        } else {
                            $greeting = 'Selamat Malam';
                        }
                    @endphp

                    {{-- PERUBAHAN 1 & 2: Font Serif & Nama User warna Gold --}}
                    <h2
                        class="text-3xl md:text-4xl font-semibold text-[#0F2854] font-serif tracking-tight leading-tight">
                        {{ $greeting }}, <span class="text-[#CBA135]">{{ auth()->user()->name }}</span>
                    </h2>

                    {{-- Deskripsi menggunakan INTER --}}
                    <p class="mt-2 text-sm font-medium text-slate-500 max-w-xl leading-relaxed font-['Inter']">
                        Daftar tugas harian Anda dan perbarui status penanganan perbaikan secara real-time.
                    </p>
                </div>

                {{-- KANAN: Tanggal Sistem (Modern Date Badge) --}}
                <div class="shrink-0 mt-2 md:mt-0">
                    {{-- PERUBAHAN 3: Background Kotak Tanggal Biru Navy --}}
                    <div
                        class="flex items-center gap-3 px-4 py-2.5 bg-[#0F2854] border border-[#1A3A73] rounded-2xl shadow-md">
                        {{-- Ikon Kalender (Diubah warnanya agar kontras) --}}
                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white border border-white/20">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                        </div>
                        {{-- Format Tanggal Laravel Carbon --}}
                        <div class="flex flex-col pr-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-blue-200 font-['Inter']">
                                Tanggal Sistem
                            </span>
                            <span class="text-sm font-bold text-white font-['Inter'] tracking-wide">
                                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F7F8F0] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= 1. STATS CARD (PROFESSIONAL MONOCHROME STYLE) ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Card 1: Total Tugas --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 flex justify-between items-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-full h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div>
                        <p
                            class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 group-hover:text-blue-600 transition-colors">
                            Total Tugas</p>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i data-feather="folder" class="w-6 h-6 text-slate-800"></i>
                    </div>
                </div>

                {{-- Card 2: Sedang Aktif --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 flex justify-between items-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-full h-1 bg-amber-500 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div>
                        <p
                            class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 group-hover:text-amber-600 transition-colors">
                            Sedang Aktif</p>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                            {{ $stats['pending_action'] ?? 0 }}</h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i data-feather="zap"
                            class="w-6 h-6 text-slate-800 group-hover:text-amber-500 transition-colors"></i>
                    </div>
                </div>

                {{-- Card 3: Tugas Selesai --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 flex justify-between items-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-full h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div>
                        <p
                            class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 group-hover:text-emerald-600 transition-colors">
                            Tugas Selesai</p>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $stats['completed'] ?? 0 }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i data-feather="check-square"
                            class="w-6 h-6 text-slate-800 group-hover:text-emerald-500 transition-colors"></i>
                    </div>
                </div>

            </div>

            {{-- ================= 2. ACTIVE TASKS (TUGAS UTAMA) ================= --}}
            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                        <h3 class="text-lg font-semibold text-gray-800 leading-none">
                            Daftar Tugas Saat Ini
                        </h3>
                    </div>
                    @if (count($tasks) > 0)
                        <span
                            class="text-[10px] font-medium text-gray-500 bg-white px-2.5 py-1 rounded border border-gray-200 uppercase tracking-wider">
                            {{ count($tasks) }} Tersedia
                        </span>
                    @endif
                </div>

                {{-- Grid Tugas --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    @forelse ($tasks as $item)
                        <div
                            class="bg-white rounded-2xl border shadow-sm flex flex-col group transition-all hover:shadow-md {{ $item->status == 'ditolak' ? 'border-[#FF0000]/30' : 'border-gray-100 hover:border-blue-200' }}">

                            {{-- Header Content --}}
                            <div class="p-6 pb-4 border-b border-gray-50 flex-1 relative">

                                {{-- Status Badge --}}
                                <div class="absolute top-6 right-6">
                                    @if ($item->status == 'ditolak')
                                        <span
                                            class="px-2.5 py-1 bg-[#FF0000]/10 text-[#FF0000] border border-[#FF0000]/20 rounded text-[10px] font-semibold uppercase tracking-wider flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#FF0000]"></span> Revisi
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] font-semibold uppercase tracking-wider flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Baru
                                        </span>
                                    @endif
                                </div>

                                {{-- ========================================================= --}}
                                {{-- PERUBAHAN: LOKASI DENGAN DUSUN, RT, RW --}}
                                {{-- ========================================================= --}}
                                <div class="flex items-start gap-4 mb-5 pr-20">
                                    <div
                                        class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-blue-50 text-blue-600 border border-blue-100">
                                        <i data-feather="map-pin" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        {{-- Teks Dusun RT RW --}}
                                        <h4 class="text-base font-bold text-gray-800 leading-tight mb-1">
                                            Dsn. {{ $item->dusun ?? '-' }}, RT {{ $item->rt ?? '-' }}/RW
                                            {{ $item->rw ?? '-' }}
                                        </h4>
                                        {{-- Teks Patokan Detail --}}
                                        <p class="text-xs text-gray-500 font-medium mb-2">
                                            <span class="font-bold text-gray-400">Patokan:</span>
                                            {{ \Illuminate\Support\Str::limit($item->lokasi, 45) }}
                                        </p>
                                        {{-- Nomor Tiket --}}
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-mono text-[10px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded border border-gray-200 tracking-wider">
                                                #{{ $item->tiket }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Body Description --}}
                                <div>
                                    <p
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                                        <i data-feather="info" class="w-3 h-3"></i> Deskripsi Masalah
                                    </p>
                                    <div class="p-4 rounded-xl bg-gray-50/80 border border-gray-100">
                                        <p class="text-sm text-gray-700 font-medium leading-relaxed">
                                            "{{ $item->deskripsi }}"
                                        </p>
                                    </div>

                                    {{-- Admin Note if Rejected --}}
                                    @if ($item->status == 'ditolak')
                                        <div class="mt-3 p-3 rounded-xl bg-[#FF0000]/5 border border-[#FF0000]/20">
                                            <p
                                                class="text-[10px] font-bold text-[#FF0000] uppercase tracking-wider mb-1 flex items-center gap-1">
                                                <i data-feather="alert-circle" class="w-3 h-3"></i> Pesan Admin
                                                (Revisi)
                                                :
                                            </p>
                                            <p class="text-xs font-semibold text-[#FF0000]">{{ $item->catatan_admin }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Action Buttons (Footer) --}}
                            <div class="p-4 bg-gray-50/50 rounded-b-2xl border-t border-gray-100">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    {{-- Tombol Navigasi --}}
                                    @if ($item->latitude && $item->longitude)
                                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                                            target="_blank"
                                            class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-xs font-bold transition-all hover:bg-gray-50 hover:text-gray-900 shadow-sm hover:shadow">
                                            <i data-feather="navigation" class="w-4 h-4 text-blue-500"></i> Rute Lokasi
                                        </a>
                                    @else
                                        <button disabled
                                            class="flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-400 rounded-xl text-xs font-bold cursor-not-allowed">
                                            <i data-feather="map-off" class="w-4 h-4"></i> Tanpa Lokasi
                                        </button>
                                    @endif

                                    {{-- Tombol Eksekusi --}}
                                    <a href="{{ url('/teknisi/laporan/' . $item->id) }}"
                                        class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-md hover:-translate-y-0.5 {{ $item->status == 'ditolak' ? 'bg-[#FF0000] hover:bg-[#CC0000] shadow-[#FF0000]/20' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20' }}">
                                        @if ($item->status == 'ditolak')
                                            <i data-feather="edit-2" class="w-4 h-4"></i> Perbaiki Lagi
                                        @else
                                            <i data-feather="tool" class="w-4 h-4"></i> Proses Sekarang
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- EMPTY STATE --}}
                        <div
                            class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 flex flex-col items-center justify-center text-center shadow-sm">
                            <div
                                class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 text-gray-400 border border-gray-100">
                                <i data-feather="coffee" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-800">Tidak Ada Tugas Aktif</h3>
                            <p class="text-sm text-gray-500 font-medium mt-1.5 max-w-sm">
                                Belum ada laporan baru yang ditugaskan kepada Anda. Silakan standby dan nikmati waktu
                                istirahat Anda.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ================= 3. RIWAYAT SELESAI ================= --}}
            <div class="pt-6" id="riwayat">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <div class="flex items-center gap-3 shrink-0">
                        <div class="w-1.5 h-5 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 leading-none">
                            Riwayat Pekerjaan Saya
                        </h3>
                    </div>

                    {{-- Form Pencarian Glassmorphism --}}
                    <form method="GET" action="{{ url()->current() }}#riwayat"
                        class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-2.5">

                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-feather="search" class="w-4 h-4 text-stone-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari tiket, lokasi..."
                                class="w-full pl-10 pr-4 py-2.5 bg-white/60 backdrop-blur-md border border-white rounded-xl text-sm font-medium text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="submit"
                                class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-900 hover:bg-black text-white rounded-xl text-sm font-bold shadow-sm hover:-translate-y-0.5 transition-all border border-slate-800">
                                Cari
                            </button>

                            @if (request()->filled('search'))
                                <a href="{{ url()->current() }}#riwayat" title="Hapus Pencarian"
                                    class="flex-1 sm:flex-none flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white/60 backdrop-blur-md border border-rose-100 text-rose-500 hover:bg-rose-50 hover:text-rose-600 rounded-xl text-sm font-bold shadow-sm hover:-translate-y-0.5 transition-all">
                                    <i data-feather="x" class="w-4 h-4"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Tabel Riwayat --}}
                @if (isset($completedTasks) && count($completedTasks) > 0)
                    <div
                        class="bg-white/70 backdrop-blur-xl rounded-2xl border border-white shadow-sm flex flex-col overflow-hidden mt-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-white/40 text-gray-500 border-b border-gray-200/50 backdrop-blur-md">
                                    <tr>
                                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">Tanggal
                                            Selesai</th>
                                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">Lokasi & Tiket
                                        </th>
                                        <th class="py-4 px-6 text-center text-xs font-bold uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100/50">
                                    @foreach ($completedTasks as $history)
                                        <tr class="hover:bg-white/50 transition-colors">
                                            <td class="py-4 px-6 align-top">
                                                <div class="font-bold text-gray-800 text-sm">
                                                    {{ $history->updated_at->format('d M Y') }}</div>
                                                <div
                                                    class="text-[11px] font-semibold text-gray-500 mt-0.5 flex items-center gap-1">
                                                    <i data-feather="clock" class="w-3 h-3"></i>
                                                    {{ $history->updated_at->format('H:i') }} WIB
                                                </div>
                                            </td>

                                            {{-- ========================================================= --}}
                                            {{-- PERUBAHAN TABEL RIWAYAT: DUSUN RT RW --}}
                                            {{-- ========================================================= --}}
                                            <td class="py-4 px-6">
                                                <div class="font-bold text-gray-800 text-sm">
                                                    Dsn. {{ $history->dusun ?? '-' }}
                                                </div>
                                                <div
                                                    class="text-xs font-medium text-gray-500 mt-0.5 truncate max-w-[250px] lg:max-w-md">
                                                    RT {{ $history->rt ?? '-' }}/RW {{ $history->rw ?? '-' }} •
                                                    {{ $history->lokasi }}
                                                </div>
                                                <div class="mt-1.5">
                                                    <span
                                                        class="text-[10px] font-mono font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                                        #{{ $history->tiket }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="py-4 px-6 text-center align-top">
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded text-[10px] font-bold uppercase tracking-wider mt-1">
                                                    <i data-feather="check-circle" class="w-3 h-3"></i> Selesai
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="p-4 border-t border-gray-100 bg-white/50">
                            {{ $completedTasks->links() }}
                        </div>
                    </div>
                @else
                    {{-- State jika pencarian tidak ditemukan / Kosong --}}
                    <div
                        class="py-12 bg-white/60 backdrop-blur-xl rounded-2xl border border-white text-center shadow-sm">
                        <div
                            class="w-12 h-12 mx-auto bg-white border border-stone-100 shadow-sm rounded-xl flex items-center justify-center text-stone-400 mb-3">
                            <i data-feather="search" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-stone-800">Tidak ada riwayat ditemukan</h4>
                        <p class="text-sm text-stone-500 font-medium mt-1">Belum ada pekerjaan selesai atau coba kata
                            kunci pencarian lain.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
</x-app-layout>
