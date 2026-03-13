<x-guest-layout>
    {{-- Custom Styles untuk Animasi Latar Belakang --}}
    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0)
            }

            25% {
                transform: translateX(-6px)
            }

            75% {
                transform: translateX(6px)
            }
        }

        .animate-shake {
            animation: shake .5s cubic-bezier(.36, .07, .19, .97) both
        }
    </style>

    {{-- Latar belakang utama dengan palet Monokrom Minimalis (gray-50) --}}
    <div
        class="min-h-screen bg-[#F7F8F0] py-12 md:py-20 px-4 sm:px-6 font-sans selection:bg-gray-900 selection:text-white relative flex justify-center">

        <div class="max-w-7xl w-full relative z-10">

            {{-- CARD WRAPPER --}}
            <div
                class="bg-white rounded-[2rem] md:rounded-[3rem] shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-200 overflow-hidden">

                {{-- HEADER FORM --}}
                <div
                    class="bg-white/90 backdrop-blur-xl border-b border-gray-100 px-8 md:px-12 py-6 md:py-8 flex items-center justify-between sticky top-0 z-30">
                    <div class="flex items-center gap-4 md:gap-5">
                        <a href="{{ url('/') }}"
                            class="w-10 h-10 md:w-12 md:h-12 shrink-0 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-900 hover:border-gray-900 hover:text-white transition-all duration-300 hover:scale-105 shadow-sm">
                            <i data-feather="arrow-left" class="w-4 h-4 md:w-5 md:h-5"></i>
                        </a>
                        <div>
                            <h1 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight">Buat Laporan Baru
                            </h1>
                            <p class="text-xs md:text-sm text-gray-500 mt-0.5 font-medium">Bantu kami mengetahui masalah
                                di sekitar Anda.</p>
                        </div>
                    </div>

                    {{-- STEP INDICATOR (Clean Monokrom) --}}
                    <div class="hidden lg:flex items-center gap-3 text-[10px] font-black uppercase tracking-widest">
                        <span
                            class="text-gray-900 flex items-center gap-1.5 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-900 animate-pulse"></span> Isi Data
                        </span>
                        <div class="w-6 h-[2px] bg-gray-200"></div>
                        <span class="text-gray-400">Verifikasi</span>
                        <div class="w-6 h-[2px] bg-gray-200"></div>
                        <span class="text-gray-400">Selesai</span>
                    </div>
                </div>

                {{-- ERROR NOTIFICATION --}}
                @if (session('error') || session('error_duplikat'))
                    <link rel="stylesheet" type="text/css"
                        href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Toastify({
                                text: "⚠️ Laporan Ditolak: {!! session('error') ?? session('error_duplikat') !!}",
                                duration: 8000,
                                gravity: "top",
                                position: "center",
                                stopOnFocus: true,
                                style: {
                                    background: "#18181b",
                                    color: "#ffffff",
                                    borderRadius: "100px",
                                    boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1)",
                                    padding: "12px 24px",
                                    fontFamily: "'Inter', system-ui, -apple-system, sans-serif",
                                    fontSize: "14px",
                                    fontWeight: "500",
                                    border: "1px solid #27272a"
                                }
                            }).showToast();
                        });
                    </script>
                @endif

                <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data"
                    class="grid grid-cols-1 lg:grid-cols-12">
                    @csrf

                    {{-- ================= LEFT SIDE (MAP & LOKASI) ================= --}}
                    <div
                        class="lg:col-span-5 bg-gray-50/50 p-8 md:p-12 border-r border-gray-100 flex flex-col relative">

                        <div class="mb-6">
                            <h3 class="text-lg font-black text-gray-900 mb-1 flex items-center gap-2">
                                <i data-feather="map" class="w-5 h-5 text-gray-900"></i> Titik Lokasi & Wilayah
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">Geser pin merah dan lengkapi data wilayah.</p>
                        </div>

                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

                        {{-- Peta Container --}}
                        <div
                            class="relative flex-grow min-h-[300px] lg:min-h-[350px] rounded-2xl md:rounded-3xl overflow-hidden border border-gray-200 shadow-inner group">
                            <div id="map" class="absolute inset-0 z-10"></div>
                            <div
                                class="absolute inset-0 bg-gray-100 flex items-center justify-center text-gray-400 z-0">
                                <i data-feather="map-pin" class="w-8 h-8 animate-bounce"></i>
                            </div>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        {{-- Patokan Detail --}}
                        <div class="mt-6">
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">
                                Patokan Lokasi Detail
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-feather="navigation"
                                        class="w-4 h-4 text-gray-400 group-focus-within:text-gray-900 transition-colors"></i>
                                </div>
                                <input type="text" name="lokasi" id="lokasi_text" value="{{ old('lokasi') }}"
                                    required
                                    class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-white border border-gray-200 focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none text-sm font-bold text-gray-900 placeholder-gray-400 transition-all shadow-sm"
                                    placeholder="Contoh: Depan Balai Desa, dekat tiang listrik">
                            </div>
                        </div>

                        {{-- Dusun, RT, RW (Ditambahkan di sini agar rapi) --}}
                        <div class="mt-5">
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">
                                Wilayah Administratif (Desa Gonilan)
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                                {{-- Dropdown Dusun --}}
                                <div class="relative group sm:col-span-3">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-feather="map"
                                            class="w-4 h-4 text-gray-400 group-focus-within:text-gray-900 transition-colors"></i>
                                    </div>
                                    <select name="dusun" required
                                        class="w-full pl-11 pr-8 py-3.5 rounded-xl bg-white border border-gray-200 focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all shadow-sm">
                                        <option value="" disabled selected class="text-gray-400">Pilih Dusun /
                                            Dukuh...</option>
                                        <option value="Gonilan">Gonilan</option>
                                        <option value="Morodipan">Morodipan</option>
                                        <option value="Nilagraha">Nilagraha</option>
                                        <option value="Nilasari">Nilasari</option>
                                        <option value="Nilasari Kulon">Nilasari Kulon</option>
                                        <option value="Tanuragan">Tanuragan</option>
                                        <option value="Tuwak Lor">Tuwak Lor</option>
                                        <option value="Tuwak Kulon">Tuwak Kulon</option>
                                        <option value="Tuwak Wetan">Tuwak Wetan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>

                                {{-- Dropdown RT --}}
                                <div class="relative group sm:col-span-1">
                                    <select name="rt" required
                                        class="w-full px-4 py-3.5 rounded-xl bg-white border border-gray-200 focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all shadow-sm">
                                        <option value="" disabled selected class="text-gray-400">RT...</option>
                                        @for ($i = 1; $i <= 34; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">RT
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>

                                {{-- Dropdown RW --}}
                                <div class="relative group sm:col-span-1">
                                    <select name="rw" required
                                        class="w-full px-4 py-3.5 rounded-xl bg-white border border-gray-200 focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all shadow-sm">
                                        <option value="" disabled selected class="text-gray-400">RW...</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">RW
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>

                                {{-- Spacing dummy for visual balance on grid --}}
                                <div class="hidden sm:block sm:col-span-1"></div>

                            </div>
                        </div>
                    </div>

                    {{-- ================= RIGHT SIDE (FORM PELAPOR) ================= --}}
                    <div class="lg:col-span-7 p-8 md:p-12 lg:p-14 bg-white">
                        <div class="max-w-2xl mx-auto space-y-10">

                            {{-- IDENTITAS --}}
                            <div>
                                <h4
                                    class="flex items-center gap-2 text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-5 border-b border-gray-100 pb-3">
                                    <div
                                        class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-900">
                                        <i data-feather="user" class="w-3.5 h-3.5"></i>
                                    </div>
                                    Identitas Pelapor
                                </h4>

                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i data-feather="user"
                                                class="w-4 h-4 text-gray-400 group-focus-within:text-gray-900 transition-colors"></i>
                                        </div>
                                        <input type="text" name="nama" value="{{ old('nama') }}" required
                                            placeholder="Nama Lengkap"
                                            class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 placeholder-gray-400 transition-all">
                                    </div>

                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i data-feather="phone"
                                                class="w-4 h-4 text-gray-400 group-focus-within:text-gray-900 transition-colors"></i>
                                        </div>
                                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                                            required placeholder="Nomor WhatsApp (Aktif)"
                                            class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 placeholder-gray-400 transition-all">
                                    </div>
                                </div>
                            </div>

                            {{-- DETAIL LAPORAN --}}
                            <div>
                                <h4
                                    class="flex items-center gap-2 text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-5 border-b border-gray-100 pb-3">
                                    <div
                                        class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-900">
                                        <i data-feather="file-text" class="w-3.5 h-3.5"></i>
                                    </div>
                                    Detail Masalah
                                </h4>

                                <div class="space-y-5">
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i data-feather="layers"
                                                class="w-4 h-4 text-gray-400 group-focus-within:text-gray-900 transition-colors"></i>
                                        </div>
                                        <select name="kategori" required
                                            class="w-full pl-11 pr-10 py-3.5 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all">
                                            <option value="" disabled selected class="text-gray-400">Pilih
                                                Kategori Masalah...</option>
                                            <option value="Masalah Kerusakan">Masalah Kerusakan Fasilitas</option>
                                            <option value="Masalah Kebersihan">Masalah Kebersihan / Sampah</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                    </div>

                                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan kondisi di lapangan secara detail..."
                                        class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none text-sm font-medium text-gray-900 placeholder-gray-400 transition-all resize-none">{{ old('deskripsi') }}</textarea>
                                </div>
                            </div>

                            {{-- FOTO BUKTI --}}
                            <div>
                                <h4
                                    class="flex items-center gap-2 text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-5 border-b border-gray-100 pb-3">
                                    <div
                                        class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-900">
                                        <i data-feather="camera" class="w-3.5 h-3.5"></i>
                                    </div>
                                    Foto Kejadian
                                </h4>

                                <label
                                    class="relative flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-gray-300 bg-gray-50 rounded-2xl hover:border-gray-900 hover:bg-gray-100/50 transition-all cursor-pointer overflow-hidden group">
                                    <div id="upload-placeholder"
                                        class="text-center space-y-2 text-gray-400 group-hover:text-gray-900 transition-colors z-10 p-6">
                                        <div
                                            class="w-14 h-14 bg-white rounded-full shadow-sm border border-gray-200 flex items-center justify-center mx-auto mb-3">
                                            <i data-feather="image"
                                                class="w-6 h-6 text-gray-400 group-hover:text-gray-900 transition-colors"></i>
                                        </div>
                                        <p class="text-[11px] font-black uppercase tracking-widest">Pilih Foto Bukti
                                        </p>
                                        <p class="text-xs font-medium text-gray-400">Maksimal ukuran file 5MB</p>
                                    </div>
                                    <input type="file" name="foto_awal" class="hidden" accept="image/*" required
                                        onchange="previewImage(this)">
                                    <div id="preview-container" class="hidden absolute inset-0 bg-white z-20">
                                        <img id="preview-img" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                            <div
                                                class="bg-white/20 text-white border border-white/40 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2">
                                                <i data-feather="refresh-cw" class="w-4 h-4"></i> Ganti Foto
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- SUBMIT BUTTON --}}
                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-bold uppercase tracking-widest text-[11px] shadow-lg shadow-gray-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 group relative overflow-hidden">
                                    <span class="relative z-10">Kirim Laporan</span>
                                    <div
                                        class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent z-0">
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') feather.replace();
        });

        function previewImage(input) {
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.getElementById('preview-img');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // =================================================================
        // 1. DEFINISIKAN BATAS WILAYAH (BOUNDING BOX) DESA GONILAN
        // =================================================================
        // Koordinat ini mencakup ujung paling bawah-kiri dan atas-kanan Gonilan
        var batasSelatanBarat = L.latLng(-7.561500, 110.762000);
        var batasUtaraTimur = L.latLng(-7.548000, 110.778000);
        var wilayahGonilan = L.latLngBounds(batasSelatanBarat, batasUtaraTimur);

        // Titik Tengah Desa Gonilan (Sebagai default jika GPS tidak aktif)
        var titikTengahGonilan = [-7.555000, 110.770000];

        // =================================================================
        // 2. INISIALISASI PETA DENGAN PENGUNCIAN WILAYAH
        // =================================================================
        var map = L.map('map', {
            maxBounds: wilayahGonilan, // KUNCI: Peta tidak bisa digeser keluar dari kotak Gonilan
            maxBoundsViscosity: 1.0, // Membuat peta memantul jika ditarik paksa
            minZoom: 15 // KUNCI: Batasi zoom out agar tidak melihat kota lain
        }).setView(titikTengahGonilan, 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var marker;

        function updateInputs(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Setel Marker Awal di Tengah Gonilan
        marker = L.marker(titikTengahGonilan, {
            draggable: true
        }).addTo(map);
        updateInputs(titikTengahGonilan[0], titikTengahGonilan[1]);

        // =================================================================
        // 3. DETEKSI LOKASI GPS PENGGUNA
        // =================================================================
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                var userLokasi = L.latLng(userLat, userLng);

                // Cek apakah lokasi GPS warga tersebut ADA DI DALAM Gonilan
                if (wilayahGonilan.contains(userLokasi)) {
                    map.setView(userLokasi, 16);
                    marker.setLatLng(userLokasi);
                    updateInputs(userLat, userLng);
                } else {
                    // Jika warga lapor dari luar kota, berikan notifikasi peringatan
                    alert(
                        "Lokasi Anda saat ini terdeteksi di luar Desa Gonilan.\n\nPin penanda telah dikunci secara default di dalam batas wilayah Desa Gonilan.");
                }
            });
        }

        // =================================================================
        // 4. VALIDASI SAAT PIN DITARIK (DRAG)
        // =================================================================
        marker.on('dragend', function() {
            var pos = marker.getLatLng();

            // Jika pin dilepas di luar batas Gonilan
            if (!wilayahGonilan.contains(pos)) {
                alert(
                    "⚠️ MOHON MAAF!\nTitik lokasi berada di luar batas administratif Desa Gonilan. Pin akan dikembalikan.");

                // Kembalikan paksa pin ke titik tengah Gonilan
                marker.setLatLng(titikTengahGonilan);
                map.setView(titikTengahGonilan, 16);
                updateInputs(titikTengahGonilan[0], titikTengahGonilan[1]);
            } else {
                updateInputs(pos.lat, pos.lng);
            }
        });

        // =================================================================
        // 5. VALIDASI SAAT PETA DIKLIK
        // =================================================================
        map.on('click', function(e) {
            // Jika yang diklik berada di area abu-abu (luar batas Gonilan)
            if (!wilayahGonilan.contains(e.latlng)) {
                alert("⚠️ Titik tersebut berada di luar wilayah Desa Gonilan.");
            } else {
                marker.setLatLng(e.latlng);
                updateInputs(e.latlng.lat, e.latlng.lng);
            }
        });
    </script>
</x-guest-layout>
