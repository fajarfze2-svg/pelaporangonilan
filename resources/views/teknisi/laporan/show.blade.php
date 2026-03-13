<x-app-layout>
    <x-slot name="header">
        {{-- TAMBAHAN: CDN Tailwind, Feather Icons & TOASTIFY CSS --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    </x-slot>

    {{-- Background Abu-abu Welcome Page --}}
    <div class="py-12 min-h-screen bg-[#F4F6F6]" x-data="{ imgModalOpen: false, modalImgSrc: '' }">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                {{-- Pastikan route('teknisi.dashboard') atau route('dashboard') sesuai dengan nama route Anda --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#CBA135] transition-colors group/back">
                    <div
                        class="p-1.5 rounded-lg bg-white border border-slate-200 shadow-sm group-hover/back:border-[#CBA135] group-hover/back:bg-yellow-50 transition-all">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                    </div>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="relative group">
                {{-- Decorative Blur Background (Cooler Gold/Yellow Gradient) --}}
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-[#CBA135] to-yellow-200 rounded-[2.5rem] blur opacity-15 group-hover:opacity-30 transition duration-1000 group-hover:duration-200">
                </div>

                <div class="relative bg-white ring-1 ring-slate-200 rounded-[2.5rem] shadow-xl overflow-hidden">

                    {{-- Modern Header --}}
                    <div class="px-8 pt-8 pb-6 bg-white border-b border-slate-100 flex justify-between items-center">
                        <div class="flex flex-col">
                            {{-- Badge dengan warna Cool Gold --}}
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-yellow-50 text-yellow-700 mb-2 border border-yellow-100 w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#CBA135] animate-pulse"></span>
                                Tahap Akhir
                            </span>
                            <p class="text-slate-700 text-base font-bold leading-snug">
                                Dokumentasikan hasil pekerjaan Anda di lokasi, Dengan
                                detail foto yang jelas.
                            </p>
                        </div>
                        {{-- Ikon Kamera formal --}}
                        <div
                            class="w-12 h-12 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center text-slate-700 shrink-0 ml-4">
                            <i data-feather="camera" class="w-6 h-6"></i>
                        </div>
                    </div>

                    <div class="p-8 bg-slate-50/50">

                        {{-- FOTO AWAL DARI ADMIN --}}
                        @if ($laporan->foto_awal)
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-3">
                                    <i data-feather="image" class="w-4 h-4 text-slate-400"></i>
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Foto Laporan Awal
                                    </span>
                                </div>

                                <div class="relative rounded-2xl overflow-hidden shadow-sm border border-slate-200 group/img cursor-pointer"
                                    @click="modalImgSrc = '{{ asset('storage/' . $laporan->foto_awal) }}'; imgModalOpen = true">
                                    <div class="aspect-video bg-slate-100 overflow-hidden relative">
                                        <img src="{{ asset('storage/' . $laporan->foto_awal) }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105"
                                            alt="Foto Awal">

                                        {{-- Overlay Zoom Icon --}}
                                        <div
                                            class="absolute inset-0 bg-black/30 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                            <div class="bg-white text-slate-800 p-2 rounded-full shadow-lg">
                                                <i data-feather="zoom-in" class="w-5 h-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Tampilkan Foto Lama  --}}
                        @if ($laporan->foto_selesai)
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-3">
                                    <i data-feather="check-circle" class="w-4 h-4 text-emerald-500"></i>
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Foto
                                        Tersimpan Saat Ini</span>
                                </div>

                                <div class="relative rounded-2xl overflow-hidden shadow-sm border border-slate-200 group/img cursor-pointer"
                                    @click="modalImgSrc = '{{ asset('storage/' . $laporan->foto_selesai) }}'; imgModalOpen = true">
                                    <div class="aspect-video bg-slate-100 relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $laporan->foto_selesai) }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105"
                                            alt="Bukti Selesai">

                                        {{-- Overlay Zoom Icon & Info --}}
                                        <div
                                            class="absolute inset-0 bg-black/30 opacity-0 group-hover/img:opacity-100 transition-opacity flex flex-col items-center justify-center backdrop-blur-[2px] gap-2">
                                            <div class="bg-white text-slate-800 p-2 rounded-full shadow-lg">
                                                <i data-feather="zoom-in" class="w-5 h-5"></i>
                                            </div>
                                            <span
                                                class="text-white text-[10px] font-bold tracking-wider uppercase bg-black/50 px-3 py-1 rounded-full">
                                                Diunggah {{ $laporan->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mb-6">
                                <div class="h-px bg-slate-200 flex-1"></div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ganti Foto
                                    Baru?</span>
                                <div class="h-px bg-slate-200 flex-1"></div>
                            </div>
                        @endif

                        {{-- FORM UPLOAD --}}
                        <form action="{{ route('teknisi.laporan.upload', ['id' => $laporan->id]) }}" method="POST"
                            enctype="multipart/form-data" id="uploadForm">

                            @csrf
                            <input type="hidden" name="task_id" value="{{ $laporan->id }}">

                            <div class="mb-8">
                                {{-- Dropzone Modern --}}
                                <div class="relative w-full group/drop">
                                    <input type="file" name="bukti_foto" id="fileInput" accept="image/*" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20 focus:outline-none"
                                        onchange="previewImage(this)">

                                    <div id="dropZone"
                                        class="relative flex flex-col items-center justify-center w-full h-56 rounded-[2rem] border-2 border-dashed border-slate-300 bg-white transition-all duration-300 group-hover/drop:border-[#CBA135] group-hover/drop:bg-yellow-50/50 group-focus-within/drop:ring-4 group-focus-within/drop:ring-yellow-100">

                                        {{-- Placeholder Content --}}
                                        <div id="placeholder"
                                            class="text-center p-6 transition-all duration-300 group-hover/drop:scale-105">
                                            <div
                                                class="w-16 h-16 bg-slate-50 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400 group-hover/drop:bg-[#CBA135] group-hover/drop:text-white group-hover/drop:border-[#CBA135] transition-all">
                                                <i data-feather="upload-cloud" class="w-8 h-8"></i>
                                            </div>
                                            <h4 class="text-slate-800 font-bold text-base mb-1">Pilih Foto Bukti</h4>
                                            <p class="text-slate-400 text-xs font-medium">Klik atau tarik file ke area
                                                ini</p>
                                        </div>

                                        {{-- Image Preview Container --}}
                                        <div id="previewContainer"
                                            class="hidden absolute inset-0 bg-white rounded-[2rem] overflow-hidden border border-slate-200 shadow-sm">
                                            <img id="previewImg" src="#" alt="Preview"
                                                class="w-full h-full object-cover">

                                            {{-- Overlay Change Button --}}
                                            <div
                                                class="absolute inset-0 bg-slate-900/50 opacity-0 group-hover/drop:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                                <div
                                                    class="bg-white/20 border border-white/30 text-white px-4 py-2 rounded-xl font-bold text-sm flex items-center gap-2 shadow-lg">
                                                    <i data-feather="refresh-cw" class="w-4 h-4"></i> Ganti Foto
                                                </div>
                                            </div>

                                            {{-- File Name Label --}}
                                            <div
                                                class="absolute top-4 left-4 right-4 flex justify-between items-center gap-2 z-30">
                                                <div
                                                    class="bg-white/95 backdrop-blur shadow-md px-3 py-1.5 rounded-lg flex items-center gap-2 max-w-[70%] border border-slate-100">
                                                    <div
                                                        class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shrink-0">
                                                    </div>
                                                    <span class="text-[10px] font-bold text-slate-800 truncate"
                                                        id="fileName">file.jpg</span>
                                                </div>

                                                {{-- Tombol Zoom --}}
                                                <button type="button"
                                                    @click.stop.prevent="modalImgSrc = document.getElementById('previewImg').src; imgModalOpen = true"
                                                    class="bg-white/95 backdrop-blur shadow-md p-1.5 rounded-lg text-slate-700 hover:text-[#CBA135] border border-slate-100 transition-colors">
                                                    <i data-feather="zoom-in" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Catatan Teknisi (Opsional) --}}
                                <div class="mt-5">
                                    <label
                                        class="text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">Catatan
                                        Tambahan (Opsional)</label>
                                    <textarea name="catatan_teknisi" rows="3"
                                        class="w-full mt-2 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-[#CBA135]/20 focus:border-[#CBA135] p-3 text-sm font-medium text-slate-800 shadow-sm transition-all"
                                        placeholder="Ketik catatan pekerjaan atau kendala di sini..."></textarea>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" id="submitBtn"
                                class="relative w-full py-4 bg-[#CBA135] hover:bg-[#B8902E] text-white font-extrabold text-sm uppercase tracking-wider rounded-xl transition-all duration-300 shadow-[0_8px_20px_rgba(203,161,53,0.3)] hover:shadow-[0_12px_25px_rgba(203,161,53,0.4)] hover:-translate-y-1 active:scale-95 flex items-center justify-center overflow-hidden group/btn">
                                <span class="relative z-10">Unggah & Selesaikan</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Footer Note --}}
                <p
                    class="text-center text-slate-400 text-xs mt-6 font-medium flex items-center justify-center gap-1.5">
                    <i data-feather="info" class="w-3.5 h-3.5"></i> Pastikan foto terlihat jelas dan mencakup area
                    yang telah diperbaiki.
                </p>
            </div>
        </div>

        {{-- ================= IMAGE ZOOM MODAL (Alpine.js) ================= --}}
        <div x-show="imgModalOpen" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <button @click="imgModalOpen = false"
                class="absolute top-6 right-6 text-white/70 hover:text-white bg-black/20 hover:bg-black/40 rounded-full p-2 backdrop-blur-md transition-colors focus:outline-none">
                <i data-feather="x" class="w-6 h-6"></i>
            </button>

            <div class="relative max-w-5xl w-full max-h-[90vh] flex items-center justify-center"
                @click.away="imgModalOpen = false">
                <img :src="modalImgSrc"
                    class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl ring-1 ring-white/10"
                    alt="Zoomed Image">
            </div>
        </div>
    </div>

    {{-- TAMBAHAN: Import library JS Toastify --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Scripts --}}
    <script>
        // Fungsi Global untuk Notifikasi Kapsul Modern
        function showToastNotification(message) {
            Toastify({
                text: message,
                duration: 3500,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "#18181b",
                    color: "#ffffff",
                    borderRadius: "100px",
                    boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
                    padding: "12px 24px",
                    fontFamily: "'Public Sans', 'Inter', system-ui, -apple-system, sans-serif",
                    fontSize: "13px",
                    fontWeight: "600",
                    border: "1px solid #27272a",
                    letterSpacing: "0.025em"
                }
            }).showToast();
        }

        function previewImage(input) {
            const dropZone = document.getElementById('dropZone');
            const placeholder = document.getElementById('placeholder');
            const previewContainer = document.getElementById('previewContainer');
            const previewImg = document.getElementById('previewImg');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const file = input.files[0];

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name;

                    // UI Transition
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');

                    // Add active border state
                    dropZone.classList.add('border-[#CBA135]', 'ring-4', 'ring-yellow-100');
                    dropZone.classList.remove('border-dashed', 'border-slate-300');

                    // Munculkan notifikasi saat foto dipilih
                    showToastNotification("Foto bukti berhasil dipilih!");
                }

                reader.readAsDataURL(file);
            }
        }

        // Tambahkan event listener saat formulir di-submit
        document.getElementById('uploadForm').addEventListener('submit', function() {
            showToastNotification("Mengunggah bukti perbaikan...");
        });

        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-app-layout>
