<x-app-layout>
    {{-- LEAFLET CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    {{-- Import Font Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- WRAPPER UTAMA DENGAN ALPINE.JS UNTUK MODAL FOTO --}}
    <div x-data="{ openModal: false, imgSrc: '' }" class="py-6 md:py-10 bg-[#F7F8F0] min-h-screen font-['Inter'] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI KE DASHBOARD --}}
            <div class="mb-4">
                {{-- Sesuaikan route('dashboard') dengan nama route dashboard admin Anda jika berbeda --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-[#0F2854] hover:bg-[#1A3A73] text-white text-xs font-extrabold uppercase tracking-widest rounded-xl active:scale-95 transition-all shadow-md w-fit">
                    Kembali
                </a>
            </div>

            {{-- JUDUL & WAKTU RATA TENGAH --}}
            <div class="text-center mb-8">
                <h2
                    class="font-bold text-2xl md:text-3xl text-slate-900 tracking-tight font-['Montserrat'] leading-tight mb-3">
                    Detail & Lokasi Laporan
                </h2>
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-[11px] md:text-xs font-bold text-slate-600 uppercase tracking-widest shadow-sm">
                    <i data-feather="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                    {{ $laporan->created_at->format('d M Y, H:i') }} WIB
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">

                {{-- KOLOM KIRI: INFO UTAMA & PETA --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- 1. Kartu Informasi --}}
                    <div
                        class="bg-white rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 border border-slate-200 shadow-sm relative overflow-hidden">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6 pb-6 border-b border-slate-100">
                            <div>
                                <p class="text-slate-500 text-xs mt-1 font-medium">Status laporan.</p>
                            </div>
                            @php
                                $statusColor = match ($laporan->status) {
                                    'baru', 'menunggu' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'proses' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'closed' => 'bg-slate-100 text-slate-600 border-slate-200',
                                    'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-50 text-slate-500 border-slate-200',
                                };
                            @endphp
                            <span
                                class="px-4 py-1.5 rounded-full text-[9px] md:text-[10px] font-bold uppercase tracking-widest border shadow-sm {{ $statusColor }}">
                                {{ $laporan->status == 'selesai' ? 'Menunggu Cek' : ucfirst($laporan->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-6">
                            <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                                <p
                                    class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                    Nama Lengkap</p>
                                <p class="text-slate-900 font-bold text-sm">{{ $laporan->nama }}</p>
                            </div>
                            <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                                <p
                                    class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                    WhatsApp</p>
                                <p class="text-slate-900 font-bold text-sm flex items-center gap-2">
                                    <i data-feather="phone" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    {{ $laporan->no_telepon }}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 md:p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                            <p class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">
                                Deskripsi Laporan</p>
                            <p class="text-slate-800 leading-relaxed font-medium text-sm">{{ $laporan->deskripsi }}</p>
                        </div>
                    </div>

                    {{-- 2. PETA LOKASI --}}
                    <div
                        class="bg-white rounded-[1.5rem] md:rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <div
                            class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h3
                                    class="font-bold text-slate-900 flex items-center gap-2 font-['Montserrat'] tracking-tight text-base md:text-lg">
                                    <span
                                        class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                                        <i data-feather="map-pin" class="w-4 h-4"></i>
                                    </span>
                                    Lokasi Kejadian
                                </h3>
                                <p class="text-slate-600 text-xs md:text-sm font-medium mt-2">{{ $laporan->lokasi }}</p>
                            </div>
                            @if ($laporan->latitude && $laporan->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $laporan->latitude }},{{ $laporan->longitude }}"
                                    target="_blank"
                                    class="w-full sm:w-auto px-4 py-2.5 bg-[#0F2854] hover:bg-[#1A3A73] text-white rounded-xl text-[10px] font-bold uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-md active:scale-95">
                                    Buka di Maps <i data-feather="external-link" class="w-3.5 h-3.5"></i>
                                </a>
                            @endif
                        </div>
                        <div class="p-2 bg-slate-50 flex-1">
                            <div id="map"
                                class="h-[300px] md:h-[400px] w-full rounded-xl border border-slate-200 shadow-inner z-0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div class="space-y-6">
                    {{-- 1. Foto Laporan Awal --}}
                    <div class="bg-white rounded-[1.5rem] p-5 md:p-6 border-t-4 border-rose-500 shadow-sm">
                        <h3
                            class="font-bold text-slate-900 flex items-center gap-2 mb-4 font-['Montserrat'] text-base md:text-lg">
                            <i data-feather="camera" class="w-4 h-4 text-rose-600"></i> Foto Laporan Awal
                        </h3>
                        @if ($laporan->foto_awal)
                            <div @click="openModal = true; imgSrc = '{{ asset('storage/' . $laporan->foto_awal) }}'"
                                class="relative group overflow-hidden rounded-xl border border-slate-200 shadow-sm bg-slate-50 cursor-pointer">
                                <img src="{{ asset('storage/' . $laporan->foto_awal) }}" alt="Foto Awal"
                                    class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105">
                                <div
                                    class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <span
                                        class="bg-white px-4 py-2 rounded-lg text-xs font-bold text-slate-800 shadow-lg flex items-center gap-2">
                                        <i data-feather="zoom-in" class="w-4 h-4"></i> Perbesar
                                    </span>
                                </div>
                            </div>
                        @else
                            <div
                                class="h-24 bg-slate-50 rounded-xl border border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                                <i data-feather="image-off" class="w-5 h-5 mb-1"></i>
                                <span class="text-[9px] font-bold uppercase tracking-wider">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                    {{-- 2. Bukti Perbaikan --}}
                    <div class="bg-white rounded-[1.5rem] p-5 md:p-6 border-t-4 border-emerald-500 shadow-sm">
                        <h3
                            class="font-bold text-slate-900 flex items-center gap-2 mb-4 font-['Montserrat'] text-base md:text-lg">
                            <i data-feather="check-square" class="w-4 h-4 text-emerald-600"></i> Bukti Perbaikan
                        </h3>
                        @if (!empty($laporan->bukti_foto))
                            <div class="space-y-4">
                                <div @click="openModal = true; imgSrc = '{{ asset('storage/' . $laporan->bukti_foto) }}'"
                                    class="relative group overflow-hidden rounded-xl border border-emerald-100 bg-emerald-50 cursor-pointer">
                                    <img src="{{ asset('storage/' . $laporan->bukti_foto) }}"
                                        class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-emerald-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                        <span
                                            class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-lg flex items-center gap-2">
                                            <i data-feather="zoom-in" class="w-4 h-4"></i> Perbesar
                                        </span>
                                    </div>
                                </div>
                                @if ($laporan->catatan_teknisi)
                                    <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100/50">
                                        <h4
                                            class="text-[9px] font-bold text-emerald-800 uppercase tracking-widest mb-1">
                                            Catatan Teknisi</h4>
                                        <p class="text-xs text-slate-800 leading-relaxed font-medium">
                                            {{ $laporan->catatan_teknisi }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div
                                class="h-24 bg-slate-50 rounded-xl border border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                                @if (in_array($laporan->status, ['baru', 'menunggu', 'proses']))
                                    <i data-feather="loader" class="w-5 h-5 mb-1 animate-spin text-amber-500"></i>
                                    <span
                                        class="text-[9px] font-bold uppercase tracking-wider text-amber-600 text-center">Menunggu
                                        Teknisi</span>
                                @else
                                    <i data-feather="image-off" class="w-5 h-5 mb-1"></i>
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-center">Tidak ada
                                        bukti</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- 3. ACTIONS ADMIN --}}
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="bg-white rounded-[1.5rem] p-5 md:p-6 border border-slate-200 shadow-sm">
                            @if ($laporan->status == 'selesai')
                                <h3
                                    class="font-bold text-slate-900 mb-4 flex items-center gap-2 font-['Montserrat'] text-base border-b border-slate-100 pb-3">
                                    Validasi Laporan
                                </h3>
                                <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST"
                                    class="space-y-4">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="teknisi_id" value="{{ $laporan->teknisi_id }}">
                                    <div
                                        class="p-3 bg-blue-50 rounded-xl border border-blue-100 text-[11px] text-blue-800 font-medium">
                                        Periksa foto bukti perbaikan dengan teliti sebelum validasi.
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Keputusan</label>
                                        <select name="status"
                                            class="w-full rounded-xl border-slate-200 text-xs font-semibold focus:ring-[#0F2854]"
                                            required>
                                            <option value="" disabled selected>Pilih Tindakan</option>
                                            <option value="closed">SELESAI </option>
                                            <option value="ditolak">REVISI </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Catatan
                                            Khusus Revisi</label>
                                        <textarea name="catatan_admin" rows="2" class="w-full rounded-xl border-slate-200 text-xs focus:ring-[#0F2854]"
                                            placeholder="Berikan komentar jika foto blur, tidak sesuai dll.."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-[#0F2854] hover:bg-[#1A3A73] text-white font-bold py-3 rounded-xl text-[10px] uppercase tracking-wider transition-all shadow-md active:scale-95">
                                        Simpan Validasi
                                    </button>
                                </form>
                            @elseif (in_array($laporan->status, ['menunggu', 'proses', 'baru']))
                                <h3
                                    class="font-bold text-slate-900 mb-4 flex items-center gap-2 font-['Montserrat'] text-base border-b border-slate-100 pb-3">
                                    <i data-feather="user-plus" class="w-4 h-4 text-[#0F2854]"></i> Penugasan
                                </h3>
                                <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST"
                                    class="space-y-4">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="proses">
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Pilih
                                            Teknisi</label>
                                        <select name="teknisi_id"
                                            class="w-full rounded-xl border-slate-200 text-xs font-semibold focus:ring-[#0F2854]"
                                            required>
                                            <option value="" disabled
                                                {{ !$laporan->teknisi_id ? 'selected' : '' }}>-- Pilih Teknisi --
                                            </option>
                                            @foreach ($listTeknisi as $teknisi)
                                                <option value="{{ $teknisi->id }}"
                                                    {{ $laporan->teknisi_id == $teknisi->id ? 'selected' : '' }}>
                                                    👷 {{ $teknisi->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Instruksi</label>
                                        <textarea name="catatan_admin" rows="2" class="w-full rounded-xl border-slate-200 text-xs focus:ring-[#0F2854]"
                                            placeholder="Pesan untuk teknisi..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-[#0F2854] hover:bg-[#1A3A73] text-white font-bold py-3 rounded-xl text-[10px] uppercase tracking-wider transition-all shadow-md active:scale-95">
                                        Kirim Penugasan
                                    </button>
                                </form>
                            @else
                                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 text-center">
                                    <i data-feather="lock" class="w-6 h-6 text-slate-400 mx-auto mb-2"></i>
                                    <p class="font-bold text-slate-800 text-sm">Laporan Ditutup</p>
                                    <p class="text-[10px] text-slate-500 mt-1 uppercase font-bold">
                                        {{ $laporan->status }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- MODAL / LIGHTBOX DENGAN TELEPORT (SUPPORT DESKTOP & MOBILE) --}}
            {{-- ========================================================= --}}
            <template x-teleport="body">
                <div x-show="openModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-[9999] bg-black/95 backdrop-blur-sm flex items-center justify-center p-4 sm:p-8"
                    style="display: none;">

                    {{-- TOMBOL X BULAT DI TENGAH BAWAH --}}
                    <button @click="openModal = false"
                        class="absolute bottom-8 md:bottom-12 left-1/2 transform -translate-x-1/2 flex items-center justify-center w-14 h-14 bg-white/10 hover:bg-rose-500 border border-white/20 text-white rounded-full backdrop-blur-md transition-all shadow-2xl z-[10000] active:scale-95">
                        <i data-feather="x" class="w-6 h-6"></i>
                    </button>

                    {{-- Area Gambar --}}
                    <div class="relative w-full h-full flex items-center justify-center pb-20 md:pb-24"
                        @click.outside="openModal = false">
                        {{-- max-h dinamis: 80vh di mobile, 90vh di desktop agar proporsional --}}
                        <img :src="imgSrc" alt="Foto Perbesar"
                            class="max-w-full max-h-[80vh] md:max-h-[90vh] object-contain rounded-lg shadow-2xl">
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            var lat = {{ $laporan->latitude ?? -6.2 }};
            var lng = {{ $laporan->longitude ?? 106.816666 }};
            var map = L.map('map', {
                scrollWheelZoom: false,
                dragging: !L.Browser.mobile
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            @if ($laporan->latitude)
                var markerIcon = L.divIcon({
                    className: 'custom-marker',
                    html: "<div style='background-color:#EF4444;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);'></div>",
                    iconSize: [18, 18],
                    iconAnchor: [9, 9]
                });
                L.marker([lat, lng], {
                        icon: markerIcon
                    }).addTo(map)
                    .bindPopup('<div class="font-bold text-xs">{{ addslashes($laporan->lokasi) }}</div>')
                    .openPopup();
            @endif
        });
    </script>
</x-app-layout>
