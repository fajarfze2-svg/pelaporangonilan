<x-app-layout>
    <x-slot name="header">
        {{-- Import Font Google: Montserrat (Judul) & Inter (Teks UI) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        {{-- Wrapper Header: Formal Glassmorphism (Sesuai Dashboard Admin) --}}
        <div
            class="relative pt-10 pb-6 bg-white/70 backdrop-blur-2xl border-b border-slate-200/80 shadow-[0_2px_15px_rgba(15,23,42,0.03)] overflow-hidden">

            {{-- Pancaran Glow Sangat Halus --}}
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
                    {{-- PERUBAHAN 1: Judul Utama dengan Font Serif & Ukuran disamakan dengan Dashboard --}}
                    <h2
                        class="text-4xl md:text-5xl font-semibold text-[#0F2854] font-serif tracking-tight leading-snug">
                        Data <span class="text-[#CBA135]">Laporan Terkini</span>
                    </h2>

                    {{-- Deskripsi menggunakan INTER --}}
                    <p class="text-sm text-slate-500 mt-3 max-w-2xl leading-relaxed font-['Inter']">
                        Daftar seluruh pengaduan masyarakat yang masuk ke sistem.
                    </p>
                </div>

                {{-- Tombol Export --}}
                @if (Route::has('admin.laporan.export'))
                    <div class="shrink-0 mb-1">
                        <a href="{{ route('admin.laporan.export') }}" target="_blank"
                            class="flex items-center justify-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-full text-sm font-bold shadow-sm transition-all duration-300 border border-red-600 hover:border-red-700 hover:shadow-md hover:-translate-y-0.5">
                            <i data-feather="printer" class="w-4 h-4"></i>
                            Export Data
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    {{-- KONTEN UTAMA DENGAN FONT INTER --}}
    <div class="py-10 bg-[#F7F8F0] min-h-screen font-['Inter']">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ================= FILTER & SEARCH BAR ================= --}}
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <form method="GET" action="{{ route('admin.laporan.index') }}"
                    class="flex flex-col sm:flex-row items-center gap-3">

                    {{-- Dropdown Filter Dusun --}}
                    <select name="dusun" onchange="this.form.submit()"
                        class="text-sm font-semibold rounded-xl border-slate-300 py-2.5 px-4 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer shadow-sm text-slate-600">
                        <option value="semua" {{ request('dusun') == 'semua' ? 'selected' : '' }}>Semua Dusun</option>
                        <option value="Gonilan" {{ request('dusun') == 'Gonilan' ? 'selected' : '' }}>Dusun Gonilan
                        </option>
                        <option value="Morodipan" {{ request('dusun') == 'Morodipan' ? 'selected' : '' }}>Dusun
                            Morodipan</option>
                        <option value="Nilagraha" {{ request('dusun') == 'Nilagraha' ? 'selected' : '' }}>Dusun
                            Nilagraha</option>
                        <option value="Nilasari" {{ request('dusun') == 'Nilasari' ? 'selected' : '' }}>Dusun Nilasari
                        </option>
                        <option value="Nilasari Kulon" {{ request('dusun') == 'Nilasari Kulon' ? 'selected' : '' }}>
                            Dusun Nilasari Kulon</option>
                        <option value="Tanuragan" {{ request('dusun') == 'Tanuragan' ? 'selected' : '' }}>Dusun
                            Tanuragan</option>
                        <option value="Tuwak Lor" {{ request('dusun') == 'Tuwak Lor' ? 'selected' : '' }}>Dusun Tuwak
                            Lor</option>
                        <option value="Tuwak Kulon" {{ request('dusun') == 'Tuwak Kulon' ? 'selected' : '' }}>Dusun
                            Tuwak Kulon</option>
                        <option value="Tuwak Wetan" {{ request('dusun') == 'Tuwak Wetan' ? 'selected' : '' }}>Dusun
                            Tuwak Wetan</option>
                    </select>

                    {{-- Kolom Pencarian --}}
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="search" class="w-4 h-4 text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari tiket, nama, telepon, atau lokasi..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-inner">
                    </div>

                    {{-- Dropdown Status --}}
                    <div class="relative w-full sm:w-56 shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="filter" class="w-4 h-4 text-slate-400"></i>
                        </div>
                        <select name="status"
                            class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none cursor-pointer shadow-inner">
                            <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status
                            </option>
                            <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru / Masuk
                            </option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak /
                                Revisi</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i data-feather="chevron-down" class="w-4 h-4 text-slate-400"></i>
                        </div>
                    </div>

                    {{-- Tombol Cari & Reset --}}
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none px-6 py-3 bg-[#0F2854] hover:bg-[#1A3A73] text-white rounded-xl text-sm font-bold shadow-sm transition-all flex justify-center items-center gap-2">
                            Cari
                        </button>

                        @if (request()->filled('search') || (request()->filled('status') && request('status') != 'semua'))
                            <a href="{{ route('admin.laporan.index') }}"
                                class="p-3 bg-white border border-slate-200 text-slate-400 hover:text-red-500 hover:bg-red-50 hover:border-red-200 rounded-xl transition-colors shadow-sm"
                                title="Reset Filter">
                                <i data-feather="x" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ================= TABEL DATA ================= --}}
            <div
                class="bg-white rounded-2xl shadow-[0_4px_24px_-4px_rgba(25,30,29,0.04)] border border-slate-200 overflow-hidden">

                {{-- Header Tabel & Total Info --}}
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div class="flex items-center gap-2.5">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        <h3 class="font-bold text-slate-800 text-lg tracking-tight font-['Montserrat']">Data Laporan
                        </h3>
                    </div>
                    <span
                        class="px-3 py-1.5 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold shadow-sm">
                        Total: {{ $laporans->total() }} Data
                    </span>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-4 w-24">Tiket</th>
                                <th class="px-6 py-4 w-48">Pelapor & Kontak</th>
                                <th class="px-6 py-4 w-40">Kategori & Foto</th>
                                <th class="px-6 py-4">Informasi Laporan</th>
                                <th class="px-6 py-4 w-60">Penugasan & Bukti</th>
                                <th class="px-6 py-4 w-36 text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($laporans as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors group">

                                    {{-- 1. TIKET --}}
                                    <td class="px-6 py-4 align-top">
                                        <div
                                            class="inline-flex items-center px-2.5 py-1 rounded bg-slate-100 border border-slate-200 text-slate-700 font-mono text-xs font-bold mt-1 shadow-sm">
                                            #{{ $item->tiket }}
                                        </div>
                                    </td>

                                    {{-- 2. PELAPOR & KONTAK --}}
                                    <td class="px-6 py-4 align-top">
                                        <div class="font-bold text-slate-900 text-sm mb-1.5 mt-0.5"
                                            style="font-style: normal;">
                                            {{ $item->nama }}
                                        </div>
                                        <div class="flex items-center gap-1.5 text-slate-600 text-xs font-medium">
                                            <i data-feather="phone" class="w-3 h-3 text-slate-400"></i>
                                            {{ $item->no_telepon ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- 3. KATEGORI & FOTO AWAL --}}
                                    <td class="px-6 py-4 align-top">
                                        @php
                                            $kat = strtolower($item->kategori ?? 'umum');
                                            $badgeKategori = str_contains($kat, 'kerusakan')
                                                ? 'bg-red-50 text-red-600 border-red-100'
                                                : (str_contains($kat, 'kebersihan')
                                                    ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                                                    : 'bg-slate-100 text-slate-600 border-slate-200');
                                        @endphp
                                        <div class="mb-3 mt-0.5">
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold border tracking-wider uppercase {{ $badgeKategori }}">
                                                {{ $item->kategori ?? 'Umum' }}
                                            </span>
                                        </div>

                                        @if (!empty($item->foto_awal))
                                            <button type="button"
                                                onclick="openModal('{{ Storage::url($item->foto_awal) }}')"
                                                class="inline-flex items-center gap-1.5 text-[10px] font-bold text-blue-600 hover:text-blue-800 transition-colors uppercase tracking-wider mt-2">
                                                <i data-feather="image" class="w-3.5 h-3.5"></i> FOTO LAPORAN
                                            </button>
                                        @else
                                            <span
                                                class="text-[10px] text-slate-400 font-medium flex items-center gap-1">
                                                <i data-feather="image" class="w-3 h-3"></i> Tanpa Foto
                                            </span>
                                        @endif
                                    </td>

                                    {{-- 4. INFORMASI LAPORAN (Lokasi & Masalah) --}}
                                    <td class="px-6 py-4 align-top">
                                        <div class="flex items-start gap-2 mb-2 mt-0.5">
                                            <i data-feather="map-pin"
                                                class="w-4 h-4 text-rose-500 shrink-0 mt-0.5"></i>
                                            <div class="flex flex-col">
                                                {{-- Menampilkan Dusun, RT, dan RW (Format Tebal) --}}
                                                <span class="text-sm font-bold text-slate-800 leading-tight">
                                                    Dsn. {{ $item->dusun ?? '-' }}, RT {{ $item->rt ?? '-' }}/RW
                                                    {{ $item->rw ?? '-' }}
                                                </span>
                                                {{-- Menampilkan Patokan Detail (Format Lebih Kecil) --}}
                                                <span class="text-[11px] font-medium text-slate-500 mt-0.5">
                                                    Patokan: {{ $item->lokasi }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="bg-[#F4F6F6] p-3 rounded-xl border border-slate-200 mt-2">
                                            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                                {{ $item->deskripsi }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- 5. PENUGASAN TEKNISI & BUKTI PEKERJAAN --}}
                                    <td class="px-6 py-4 align-top">
                                        @if ($item->status == 'baru' || $item->status == 'menunggu' || !$item->teknisi_id)
                                            <form action="{{ route('admin.laporan.update', $item->id) }}"
                                                method="POST" class="flex flex-col gap-2 w-full mt-0.5">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="proses">
                                                <select name="teknisi_id" required
                                                    class="text-xs font-semibold rounded-lg border-slate-300 py-2 px-2.5 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-full cursor-pointer shadow-sm">
                                                    <option value="">Pilih Teknisi</option>
                                                    @foreach ($listTeknisi as $t)
                                                        <option value="{{ $t->id }}">👷 {{ $t->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit"
                                                    class="bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider py-2 rounded-lg transition-colors shadow-sm w-full flex items-center justify-center gap-1.5">
                                                    Tugaskan <i data-feather="arrow-right" class="w-3 h-3"></i>
                                                </button>
                                            </form>
                                        @else
                                            <div class="flex flex-col gap-2 mt-0.5">
                                                <div
                                                    class="flex items-center gap-2.5 p-2 rounded-xl border border-slate-200 bg-slate-50 shadow-sm w-full">
                                                    <div
                                                        class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-[#0F2854] font-black text-xs border border-slate-200 shadow-sm shrink-0">
                                                        {{ substr($item->teknisi->name ?? '?', 0, 1) }}
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Dikerjakan
                                                            Oleh</span>
                                                        <span style="font-style: normal;"
                                                            class="text-xs font-bold text-slate-800 truncate max-w-[120px]">
                                                            {{ $item->teknisi->name ?? '-' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="px-1 mt-1">
                                                    {{-- LOGIKA REVISI: Sembunyikan bukti jika statusnya revisi/ditolak --}}
                                                    @if ($item->status == 'revisi' || $item->status == 'ditolak')
                                                        <span
                                                            class="text-[10px] text-red-500 font-medium flex items-center gap-1.5">
                                                            <i data-feather="alert-circle" class="w-3.5 h-3.5"></i>
                                                            Menunggu Perbaikan (Revisi)
                                                        </span>
                                                    @elseif (!empty($item->bukti_foto))
                                                        <button type="button"
                                                            onclick="openModal('{{ Storage::url($item->bukti_foto) }}')"
                                                            class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 hover:text-emerald-800 transition-colors uppercase tracking-wider mt-2">
                                                            <i data-feather="check-circle" class="w-3.5 h-3.5"></i>
                                                            Bukti Selesai
                                                        </button>
                                                    @else
                                                        <span
                                                            class="text-[10px] text-slate-400 font-medium flex items-center gap-1.5">
                                                            <i data-feather="clock" class="w-3.5 h-3.5"></i> Belum ada
                                                            bukti
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- 6. STATUS LAPORAN --}}
                                    <td class="px-6 py-4 align-middle text-center">
                                        @if ($item->status == 'baru' || $item->status == 'menunggu')
                                            {{-- Status Baru Masuk --}}
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-200 shadow-sm">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                                Baru
                                            </span>
                                        @elseif ($item->status == 'proses')
                                            {{-- Sedang Dikerjakan Teknisi --}}
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-200 shadow-sm">
                                                <i data-feather="tool" class="w-3 h-3"></i> Diproses
                                            </span>
                                        @elseif ($item->status == 'selesai')
                                            {{-- Teknisi Selesai, TAPI Belum Divalidasi Admin (Tetap tampil sebagai DIPROSES) --}}
                                            <div class="flex flex-col items-center gap-1">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-200 shadow-sm">
                                                    <i data-feather="loader" class="w-3 h-3 animate-spin"></i>
                                                    Diproses
                                                </span>
                                                <span
                                                    class="text-[8px] font-bold text-amber-600 bg-amber-100/50 px-2 py-0.5 rounded uppercase tracking-wider">
                                                    Butuh Validasi
                                                </span>
                                            </div>
                                        @elseif ($item->status == 'closed')
                                            {{-- SUDAH DIVALIDASI ADMIN (Baru boleh pakai kata SELESAI) --}}
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-200 shadow-sm">
                                                <i data-feather="check-circle" class="w-3 h-3"></i> Selesai
                                            </span>
                                        @elseif ($item->status == 'ditolak' || $item->status == 'revisi')
                                            {{-- Ditolak / Disuruh Perbaiki Ulang --}}
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-200 shadow-sm">
                                                <i data-feather="alert-triangle" class="w-3 h-3"></i> Revisi
                                            </span>
                                        @endif
                </div>
                </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                <i data-feather="inbox" class="w-6 h-6 text-slate-400"></i>
                            </div>
                            <p class="text-slate-800 font-bold text-sm font-['Montserrat']">Tidak Ada
                                Laporan</p>
                            <p class="text-slate-500 text-xs mt-1 font-medium">Data laporan atau hasil
                                pencarian tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-6 border-t border-slate-100 bg-slate-50">
                {{ $laporans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    </div>

    {{-- ========================================================= --}}
    {{-- MODAL LIGHTBOX (Pop-up Gambar untuk Admin) --}}
    {{-- ========================================================= --}}
    <div id="imageModal"
        class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm flex-col items-center justify-center p-4 transition-opacity">
        {{-- Tombol Tutup / Kembali --}}
        <button type="button" onclick="closeModal()"
            class="absolute top-6 right-6 px-5 py-2.5 bg-white/10 hover:bg-red-500 text-white rounded-xl font-bold uppercase tracking-widest text-xs flex items-center gap-2 border border-white/20 transition-all shadow-lg z-50">
            <i data-feather="x" class="w-4 h-4"></i> Kembali
        </button>

        {{-- Gambar yang Diperbesar --}}
        <img id="modalImage" src=""
            class="max-w-full max-h-[85vh] rounded-2xl object-contain shadow-2xl border border-white/10">
    </div>

    {{-- Script Icons & Modal --}}
    <script>
        // 1. Inisialisasi Icon Feather
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }); // <-- Tanda tutup ini sebelumnya tertinggal

        // 2. Fungsi Modal (Harus di luar DOMContentLoaded agar bisa dipanggil dari HTML)
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');

            modalImg.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Kunci scroll halaman belakang
        }

        // Fungsi Untuk Menutup Foto
        function closeModal() {
            const modal = document.getElementById('imageModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; // Kembalikan scroll admin
        }

        // Tutup modal secara otomatis jika Admin menekan tombol "Escape" di keyboard
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeModal();
            }
        });
    </script>
</x-app-layout>
