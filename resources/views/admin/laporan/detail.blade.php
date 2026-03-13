<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-3xl text-[#4A4947] tracking-tight flex items-center gap-3">
                    <span
                        class="p-3 bg-gradient-to-br from-[#7D8F69] to-[#556B2F] rounded-2xl shadow-lg shadow-stone-200">
                        <i data-feather="file-text" class="text-white w-6 h-6"></i>
                    </span>
                    Detail Laporan
                </h2>
                <p class="text-[#A9A8A3] text-xs font-bold mt-3 ml-1 uppercase tracking-widest">Informasi lengkap
                    mengenai tiket #{{ $laporan->tiket }}</p>
            </div>

            <a href="{{ route('laporan.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-stone-200 text-[#4A4947] text-xs font-black uppercase tracking-widest rounded-xl hover:bg-[#F1EFE7] transition-all shadow-sm">
                <i data-feather="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    {{-- TAMBAHAN: x-data untuk mengaktifkan fitur Zoom Modal Foto --}}
    <div class="py-12 bg-[#F7F8F0] min-h-screen" x-data="{ imgModalOpen: false, modalImgSrc: '' }">
        <div class="max-w-5xl mx-auto px-6">

            <div
                class="bg-white rounded-[3rem] shadow-[0_20px_50px_-15px_rgba(74,73,71,0.08)] border border-stone-100 overflow-hidden">
                {{-- Status Banner --}}
                <div
                    class="px-10 py-6 bg-[#F7F8F0] border-b border-stone-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-black text-[#A9A8A3] uppercase tracking-[0.2em]">Status Saat
                            Ini:</span>

                        @if ($laporan->status == 'menunggu')
                            <span
                                class="px-4 py-1.5 bg-[#FEFAE0] text-[#BC6C25] rounded-full text-[10px] font-black uppercase tracking-widest border border-[#FAEDCD]">Menunggu</span>
                        @elseif($laporan->status == 'diproses')
                            <span
                                class="px-4 py-1.5 bg-[#FAEDCD] text-[#D4A373] rounded-full text-[10px] font-black uppercase tracking-widest border border-[#D4A373]/20">Sedang
                                Diproses</span>
                        @elseif($laporan->status == 'selesai' || $laporan->status == 'closed')
                            <span
                                class="px-4 py-1.5 bg-[#E9EDC9] text-[#7D8F69] rounded-full text-[10px] font-black uppercase tracking-widest border border-[#7D8F69]/20">Selesai</span>
                        @elseif($laporan->status == 'ditolak')
                            <span
                                class="px-4 py-1.5 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-rose-100">Ditolak</span>
                        @endif
                    </div>

                    <div
                        class="text-[#A9A8A3] text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i data-feather="calendar" class="w-3 h-3"></i>
                        {{-- PERBAIKAN: Pengecekan null pada tanggal agar tidak error 500 --}}
                        Dilaporkan: {{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i') : '-' }}
                    </div>
                </div>

                <div class="p-10 md:p-14">
                    <div class="grid md:grid-cols-2 gap-12">

                        {{-- Informasi Pelapor --}}
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[10px] font-black text-[#7D8F69] uppercase tracking-[0.3em] mb-4">
                                    Identitas Pelapor</h4>
                                <div class="space-y-4">
                                    <div class="bg-[#FCFAFA] p-5 rounded-2xl border border-stone-50">
                                        <p class="text-[9px] font-black text-[#A9A8A3] uppercase tracking-widest mb-1">
                                            Nama Lengkap</p>
                                        <p class="text-[#4A4947] font-bold">{{ $laporan->nama }}</p>
                                    </div>
                                    <div class="bg-[#FCFAFA] p-5 rounded-2xl border border-stone-50 text-indigo-600">
                                        <p class="text-[9px] font-black text-[#A9A8A3] uppercase tracking-widest mb-1">
                                            Kontak Person</p>
                                        <p class="font-bold flex items-center gap-2">
                                            <i data-feather="phone" class="w-3 h-3"></i>
                                            {{ $laporan->no_telepon }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[10px] font-black text-[#D4A373] uppercase tracking-[0.3em] mb-4">Lokasi
                                    & Objek</h4>
                                <div class="bg-[#FCFAFA] p-6 rounded-2xl border border-stone-50 flex items-start gap-4">
                                    <div class="p-3 bg-white rounded-xl shadow-sm text-[#D4A373]">
                                        <i data-feather="map-pin" class="w-5 h-5"></i>
                                    </div>
                                    <p class="text-[#4A4947] font-bold text-lg leading-tight">{{ $laporan->lokasi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi & Bukti --}}
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[10px] font-black text-[#BC6C25] uppercase tracking-[0.3em] mb-4">Detail
                                    Kejadian</h4>
                                <div
                                    class="bg-[#FCFAFA] p-8 rounded-[2rem] border border-stone-50 italic text-[#4A4947] leading-relaxed shadow-inner">
                                    "{{ $laporan->deskripsi }}"
                                </div>
                            </div>

                            {{-- PERBAIKAN: Pastikan '$laporan->foto' sesuai dengan nama kolom database Anda --}}
                            @if (!empty($laporan->foto) && file_exists(public_path('storage/' . $laporan->foto_awal)))
                                <div>
                                    <h4 class="text-[10px] font-black text-[#A9A8A3] uppercase tracking-[0.3em] mb-4">
                                        Lampiran Foto Bukti</h4>

                                    {{-- PERBAIKAN: Menambahkan trigger @click untuk membuka modal gambar --}}
                                    <div class="relative group cursor-zoom-in"
                                        @click="modalImgSrc = '{{ asset('storage/' . $laporan->foto) }}'; imgModalOpen = true">
                                        <img src="{{ asset('storage/' . $laporan->foto_awal) }}"
                                            class="w-full h-64 object-cover rounded-[2rem] shadow-md border-4 border-white transition-transform duration-500 group-hover:scale-[1.02]">
                                        <div
                                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 rounded-[2rem] transition-opacity flex items-center justify-center">
                                            <span
                                                class="bg-white px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-[#4A4947]">
                                                Lihat Ukuran Penuh
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Admin/Teknisi Note Section (If Exists) --}}
                    @if ($laporan->catatan_teknisi)
                        <div class="mt-12 pt-10 border-t border-stone-100">
                            <div class="bg-[#E9EDC9]/30 p-8 rounded-[2.5rem] border border-[#E9EDC9]">
                                <div class="flex items-center gap-3 mb-4 text-[#7D8F69]">
                                    <i data-feather="tool" class="w-5 h-5"></i>
                                    <h4 class="text-xs font-black uppercase tracking-[0.2em]">Tanggapan Teknisi</h4>
                                </div>
                                <p class="text-[#4A4947] font-medium leading-relaxed">{{ $laporan->catatan_teknisi }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ================= IMAGE ZOOM MODAL (Alpine.js) ================= --}}
        {{-- Ini wajib ada agar tombol "Lihat Ukuran Penuh" berfungsi --}}
        <div x-show="imgModalOpen" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            {{-- Tombol Close --}}
            <button @click="imgModalOpen = false"
                class="absolute top-6 right-6 text-white/70 hover:text-white bg-black/20 hover:bg-black/40 rounded-full p-2 backdrop-blur-md transition-colors focus:outline-none">
                <i data-feather="x" class="w-6 h-6"></i>
            </button>

            {{-- Image Container --}}
            <div class="relative max-w-5xl w-full max-h-[90vh] flex items-center justify-center"
                @click.away="imgModalOpen = false">
                <img :src="modalImgSrc"
                    class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl ring-1 ring-white/10"
                    alt="Zoomed Image">
            </div>
        </div>

    </div>

    {{-- Script inisialisasi ikon jika diperlukan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-app-layout>
