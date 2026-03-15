<x-guest-layout>
    {{-- Import Font Sesuai Landing Page --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        /* Animasi kilauan tombol */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }

        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0) 100%);
            transform: rotate(45deg);
            transition: all 0.5s;
            opacity: 0;
        }

        .btn-shine:hover::after {
            left: 100%;
            opacity: 1;
            transition: all 0.7s ease-in-out;
        }
    </style>

    <div class="min-h-screen bg-[#F7F8F0] py-8 md:py-12 px-4 sm:px-6 font-['Inter'] flex justify-center antialiased">
        <div class="max-w-5xl w-full relative z-10">

            @if (!$laporan)

                @if (request()->has('tiket'))
                    {{-- ========================================================= --}}
                    {{-- KONDISI 1A: TIKET DICARI TAPI TIDAK DITEMUKAN (ERROR) --}}
                    {{-- ========================================================= --}}

                    {{-- Tampilan murni hanya error, form pencarian dihilangkan --}}
                    <div
                        class="max-w-md mx-auto bg-white rounded-[2rem] shadow-xl p-8 text-center mt-10 border border-rose-100">

                        {{-- Ikon Silang Merah --}}
                        <div
                            class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner animate-[pulse_1s_ease-in-out]">
                            <i data-feather="x-circle" class="w-10 h-10"></i>
                        </div>

                        <h2 class="text-2xl font-black text-slate-800 mb-6 font-['Montserrat'] tracking-tight">Data
                            Tidak Ditemukan</h2>

                        {{-- Pesan Error Sesuai Request --}}
                        <div
                            class="mb-8 p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 text-left">
                            <i data-feather="alert-circle" class="w-5 h-5 text-rose-600 shrink-0 mt-0.5"></i>
                            <p class="text-xs font-semibold text-rose-700 leading-relaxed font-['Inter']">
                                Kode yang Anda kirim tidak sesuai. Silahkan sesuaikan dengan kode yang sudah terkirim sebelumnya.
                            </p>
                        </div>

                        {{-- Tombol Kembali Langsung ke Landing Page --}}
                        <a href="{{ url('/') }}"
                            class="btn-shine w-full py-4 bg-[#0F2854] hover:bg-[#1A3A73] text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2 font-['Montserrat']">
                            <i data-feather="home" class="w-4 h-4"></i> Kembali ke Beranda
                        </a>
                    </div>
                @else
                    {{-- ========================================================= --}}
                    {{-- KONDISI 1B: FORM PENCARIAN TIKET (AWAL MULA BUKA HALAMAN) --}}
                    {{-- ========================================================= --}}
                    <div class="mb-6">
                        <a href="{{ url('/') }}"
                            class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-600 hover:bg-[#0F2854] hover:text-white transition-all">
                            <i data-feather="arrow-left" class="w-5 h-5"></i>
                        </a>
                    </div>

                    <div
                        class="max-w-md mx-auto bg-white rounded-[2rem] shadow-xl p-8 text-center mt-10 border border-slate-100">
                        <div
                            class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <i data-feather="search" class="w-8 h-8"></i>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800 mb-2 font-['Montserrat'] tracking-tight">Lacak
                            Laporan</h2>
                        <p class="text-sm text-slate-500 font-medium mb-8">Masukkan Kode Tiket unik Anda di bawah ini.
                        </p>

                        <form action="{{ route('laporan.cek') }}" method="GET">
                            <div class="relative group mb-5">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0F2854]">
                                    <i data-feather="hash" class="w-5 h-5"></i>
                                </div>
                                <input type="text" name="tiket" required placeholder="LPR-XXXXX" autocomplete="off"
                                    class="w-full pl-12 pr-5 py-4 rounded-2xl bg-slate-50 border-2 border-slate-100 focus:bg-white focus:border-[#0F2854] focus:ring-4 focus:ring-[#0F2854]/20 outline-none font-bold text-lg text-slate-800 placeholder-slate-400 text-center uppercase tracking-widest transition-all font-mono">
                            </div>
                            <button type="submit"
                                class="btn-shine w-full py-4 bg-[#0F2854] hover:bg-[#1A3A73] text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2 font-['Montserrat']">
                                Lacak Sekarang <i data-feather="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @endif
            @else
                {{-- ========================================================= --}}
                {{-- KONDISI 2: HASIL PELACAKAN (TIKET DITEMUKAN) --}}
                {{-- ========================================================= --}}

                {{-- HEADER STATUS --}}
                <div class="bg-[#0F2854] rounded-t-[2rem] px-6 py-8 text-white relative overflow-hidden shadow-md">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/4">
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row justify-between md:items-end gap-4">
                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-widest text-blue-200 mb-1.5 font-['Montserrat']">
                                No. Tiket Pengaduan</p>
                            <h2 class="text-4xl font-black font-mono tracking-wider drop-shadow-md text-[#CBA135]">
                                #{{ $laporan->tiket }}</h2>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-xl w-fit">
                            <p class="text-[9px] uppercase tracking-widest text-blue-200 font-bold mb-0.5">Tanggal Lapor
                            </p>
                            <p class="text-sm font-bold">{{ $laporan->created_at->format('d M Y • H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                {{-- KONTEN BAWAH (SPLIT LAYOUT) --}}
                <div
                    class="bg-white rounded-b-[2rem] shadow-xl p-4 md:p-8 flex flex-col lg:flex-row gap-8 border border-t-0 border-slate-100">

                    {{-- KOLOM KIRI: INFO & TIMELINE --}}
                    <div class="lg:w-1/2 space-y-6">

                        {{-- Kartu Info --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                    <i data-feather="user" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pelapor
                                    </p>
                                    <p class="font-bold text-slate-800 text-sm">{{ $laporan->nama ?? 'Anonim' }}</p>
                                    <span
                                        class="inline-block mt-1 px-2.5 py-0.5 bg-[#0F2854]/10 text-[#0F2854] text-[9px] font-bold uppercase tracking-wider rounded-md">
                                        {{ $laporan->kategori }}
                                    </span>
                                </div>
                            </div>

                            <hr class="border-slate-200">

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                                    <i data-feather="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi
                                        Kejadian</p>
                                    <p class="font-bold text-slate-800 text-sm mb-0.5">Dsn.
                                        {{ $laporan->dusun ?? '-' }}, RT {{ $laporan->rt ?? '-' }}/RW
                                        {{ $laporan->rw ?? '-' }}</p>
                                    <p class="text-xs text-slate-500 font-medium leading-snug">{{ $laporan->lokasi }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- TIMELINE VERTIKAL DENGAN WAKTU REALTIME --}}
                        {{-- ========================================================= --}}
                        @php
                            $status = $laporan->status;
                            $step1 = true;
                            $step2 = in_array($status, ['proses', 'selesai', 'closed', 'revisi', 'ditolak']);
                            $step3 = $status == 'closed';
                        @endphp

                        <div class="pt-4 px-2">
                            <h3 class="font-black text-slate-800 text-lg mb-6 font-['Montserrat'] tracking-tight">Status
                                Pengerjaan</h3>

                            <div class="space-y-0 ml-2">
                                {{-- STEP 1: DITERIMA --}}
                                <div class="relative pl-10 pb-8">
                                    <div class="absolute left-[15px] top-8 bottom-0 w-[2px] bg-slate-200"></div>
                                    <div class="absolute left-[15px] top-8 w-[2px] bg-emerald-500 transition-all duration-1000"
                                        style="height: {{ $step2 ? '100%' : '0%' }}"></div>

                                    <div
                                        class="absolute left-0 top-0 w-8 h-8 rounded-full bg-emerald-500 border-4 border-white flex items-center justify-center text-white shadow-sm z-10">
                                        <i data-feather="check" class="w-4 h-4"></i>
                                    </div>
                                    <div class="pt-1">
                                        <h4
                                            class="font-bold text-slate-800 text-sm uppercase tracking-wider font-['Montserrat']">
                                            Laporan Diterima</h4>
                                        <p class="text-xs text-slate-500 mt-1">Laporan Anda telah masuk ke sistem dan
                                            menunggu antrean teknisi.</p>
                                        {{-- Waktu Step 1 --}}
                                        <span
                                            class="inline-flex items-center gap-1 mt-2 text-[10px] font-bold px-2 py-1 bg-slate-100 text-slate-500 rounded border border-slate-200">
                                            <i data-feather="clock" class="w-3 h-3"></i>
                                            {{ $laporan->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                </div>

                                {{-- STEP 2: DIPROSES TEKNISI --}}
                                <div class="relative pl-10 pb-8">
                                    <div class="absolute left-[15px] top-8 bottom-0 w-[2px] bg-slate-200"></div>
                                    <div class="absolute left-[15px] top-8 w-[2px] bg-emerald-500 transition-all duration-1000"
                                        style="height: {{ $step3 ? '100%' : '0%' }}"></div>

                                    <div
                                        class="absolute left-0 top-0 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center z-10 shadow-sm transition-colors {{ $step2 ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-transparent' }}">
                                        @if ($status == 'selesai')
                                            <i data-feather="loader" class="w-4 h-4 animate-spin"></i>
                                        @elseif ($step2)
                                            <i data-feather="check" class="w-4 h-4"></i>
                                        @endif
                                    </div>
                                    <div class="pt-1">
                                        <h4
                                            class="font-bold text-sm uppercase tracking-wider font-['Montserrat'] {{ $step2 ? 'text-slate-800' : 'text-slate-400' }}">
                                            Diproses Teknisi</h4>
                                        <p
                                            class="text-xs {{ $step2 ? 'text-slate-500' : 'text-slate-400' }} mt-1 leading-relaxed">
                                            @if ($status == 'selesai')
                                                <span class="text-amber-600 font-semibold">Bukti perbaikan telah
                                                    dikirim.</span> Menunggu validasi dari Admin Pusat.
                                            @elseif ($step2)
                                                Teknisi telah ditugaskan dan sedang mengerjakan perbaikan di lokasi.
                                            @else
                                                Menunggu penugasan teknisi.
                                            @endif
                                        </p>
                                        {{-- Waktu Step 2 --}}
                                        @if ($step2 && !$step3)
                                            <span
                                                class="inline-flex items-center gap-1 mt-2 text-[10px] font-bold px-2 py-1 bg-slate-100 text-slate-500 rounded border border-slate-200">
                                                <i data-feather="clock" class="w-3 h-3"></i> Terakhir diupdate:
                                                {{ $laporan->updated_at->format('d M Y, H:i') }} WIB
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- STEP 3: SELESAI --}}
                                <div class="relative pl-10">
                                    <div
                                        class="absolute left-0 top-0 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center z-10 shadow-sm transition-colors {{ $step3 ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-transparent' }}">
                                        @if ($step3)
                                            <i data-feather="check" class="w-4 h-4"></i>
                                        @endif
                                    </div>
                                    <div class="pt-1">
                                        <h4
                                            class="font-bold text-sm uppercase tracking-wider font-['Montserrat'] {{ $step3 ? 'text-slate-800' : 'text-slate-400' }}">
                                            Selesai Divalidasi</h4>
                                        <p class="text-xs {{ $step3 ? 'text-slate-500' : 'text-slate-400' }} mt-1">
                                            @if ($step3)
                                                Perbaikan telah selesai sepenuhnya dan divalidasi oleh Admin.
                                            @else
                                                Laporan belum ditutup.
                                            @endif
                                        </p>
                                        {{-- Waktu Step 3 --}}
                                        @if ($step3)
                                            <span
                                                class="inline-flex items-center gap-1 mt-2 text-[10px] font-bold px-2 py-1 bg-emerald-50 text-emerald-700 rounded border border-emerald-200">
                                                <i data-feather="check-circle" class="w-3 h-3"></i> Ditutup pada:
                                                {{ $laporan->updated_at->format('d M Y, H:i') }} WIB
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: FOTO BEFORE AFTER --}}
                    <div class="lg:w-1/2 border-t lg:border-t-0 lg:border-l border-slate-100 pt-8 lg:pt-0 lg:pl-8">
                        <h3 class="font-black text-slate-800 text-lg mb-6 font-['Montserrat'] tracking-tight">Foto
                            Kondisi</h3>

                        <div class="space-y-6">
                            {{-- FOTO SEBELUM --}}
                            <div>
                                <span
                                    class="inline-flex px-3 py-1 bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-widest rounded-t-lg font-['Montserrat']">⚠️
                                    Sebelum</span>
                                <div class="w-full h-48 sm:h-56 bg-slate-100 rounded-b-2xl rounded-tr-2xl overflow-hidden relative group cursor-pointer border border-slate-200 shadow-sm"
                                    @if ($laporan->foto_awal) onclick="openModal('{{ Storage::url($laporan->foto_awal) }}')" @endif>
                                    @if ($laporan->foto_awal)
                                        <img src="{{ Storage::url($laporan->foto_awal) }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-[#0F2854]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <i data-feather="zoom-in" class="text-white w-8 h-8"></i>
                                        </div>
                                    @else
                                        <div
                                            class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                            <i data-feather="image-off" class="w-6 h-6 mb-2"></i>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-widest font-['Montserrat']">Tidak
                                                ada foto</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- FOTO SESUDAH --}}
                            <div>
                                <span
                                    class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-t-lg font-['Montserrat']">✅
                                    Sesudah</span>

                                {{-- FOTO HANYA BISA DIKLIK JIKA STATUS CLOSED --}}
                                <div class="w-full h-48 sm:h-56 bg-slate-100 rounded-b-2xl rounded-tr-2xl overflow-hidden relative border border-slate-200 shadow-sm {{ $laporan->bukti_foto && $laporan->status == 'closed' ? 'cursor-pointer group' : '' }}"
                                    @if ($laporan->bukti_foto && $laporan->status == 'closed') onclick="openModal('{{ Storage::url($laporan->bukti_foto) }}')" @endif>

                                    @if ($laporan->bukti_foto && $laporan->status == 'closed')
                                        <img src="{{ Storage::url($laporan->bukti_foto) }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-[#0F2854]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <i data-feather="zoom-in" class="text-white w-8 h-8"></i>
                                        </div>
                                    @else
                                        <div
                                            class="w-full h-full flex flex-col items-center justify-center bg-[#0F2854] text-slate-300 relative overflow-hidden">
                                            <div
                                                class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')]">
                                            </div>

                                            {{-- Jika status = selesai, tampilkan Menunggu Validasi --}}
                                            @if ($laporan->status == 'selesai')
                                                <i data-feather="loader"
                                                    class="w-8 h-8 mb-3 text-[#CBA135] animate-spin"></i>
                                                <p
                                                    class="font-bold text-[10px] uppercase tracking-widest text-center px-4 font-['Montserrat'] text-white">
                                                    Menunggu Validasi<br><span class="text-[#CBA135]">Admin
                                                        Pusat</span></p>
                                            @else
                                                <i data-feather="tool"
                                                    class="w-8 h-8 mb-3 text-slate-400 animate-pulse"></i>
                                                <p
                                                    class="font-bold text-[10px] uppercase tracking-widest text-center px-4 font-['Montserrat'] text-slate-400">
                                                    Sedang Dikerjakan</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TOMBOL KEMBALI BAWAH --}}
                <div class="mt-8 px-4 md:px-0">
                    <a href="{{ url('/') }}"
                        class="block w-full py-4 bg-[#0F2854] hover:bg-[#1A3A73] text-white text-center rounded-2xl font-bold uppercase tracking-widest text-sm transition-all shadow-md active:scale-95 font-['Montserrat']">
                        Kembali
                    </a>
                </div>

            @endif

        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- MODAL LIGHTBOX FOTO (Tombol X di KANAN ATAS) --}}
    {{-- ========================================================= --}}
    <div id="imageModal"
        class="fixed inset-0 z-[9999] hidden bg-black/95 backdrop-blur-sm flex-col items-center justify-center p-4 transition-opacity">

        {{-- Tombol X di Pojok Kanan Atas --}}
        <button onclick="closeModal()"
            class="absolute top-6 right-6 md:top-8 md:right-8 flex items-center justify-center w-12 h-12 bg-white/10 hover:bg-rose-500 border border-white/20 text-white rounded-full backdrop-blur-md transition-all shadow-2xl z-[10000] active:scale-95">
            <i data-feather="x" class="w-6 h-6"></i>
        </button>

        <div class="relative w-full h-full flex items-center justify-center">
            <img id="modalImage" src="" class="max-w-full max-h-[85vh] rounded-lg object-contain shadow-2xl">
        </div>
    </div>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });

        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modalImg.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeModal();
        });
    </script>
</x-guest-layout>
