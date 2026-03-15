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

    <div
        class="min-h-screen bg-[#F7F8F0] py-12 md:py-20 px-4 sm:px-6 font-sans selection:bg-gray-900 selection:text-white relative flex justify-center">
        <div class="max-w-7xl w-full relative z-10">
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

                {{-- ERROR NOTIFICATION (GLOBAL) --}}
                @if (session('error') || session('error_duplikat') || $errors->any())
                    <div
                        class="mx-8 md:mx-12 mt-6 p-5 bg-red-50/80 backdrop-blur-sm border border-red-200 rounded-2xl flex items-start gap-4 animate-shake shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                        <div
                            class="w-10 h-10 rounded-full bg-red-100 border border-red-200 flex items-center justify-center shrink-0">
                            <i data-feather="alert-octagon" class="w-5 h-5 text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-red-900 tracking-tight">PERINGATAN!</h3>
                            <div class="text-xs md:text-sm text-red-700 mt-1 font-medium leading-relaxed">
                                {!! session('error') ?? session('error_duplikat') !!}
                                @if ($errors->any())
                                    <p>Terdapat beberapa kesalahan pengisian. Silakan periksa kolom di bawah yang wajib anda isi.</p>
                                @endif
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.style.display='none'"
                            class="text-red-400 hover:text-red-900 transition-colors p-1">
                            <i data-feather="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data"
                    class="grid grid-cols-1 lg:grid-cols-12">
                    @csrf

                    {{-- LEFT SIDE (MAP & LOKASI) --}}
                    <div
                        class="lg:col-span-5 bg-gray-50/50 p-8 md:p-12 border-r border-gray-100 flex flex-col relative">
                        <div class="mb-6">
                            <h3 class="text-lg font-black text-gray-900 mb-1 flex items-center gap-2">
                                <i data-feather="map" class="w-5 h-5 text-gray-900"></i> Titik Lokasi & Wilayah
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">Geser pin merah dan lengkapi data wilayah.</p>
                        </div>

                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                        <div
                            class="relative flex-grow min-h-[300px] lg:min-h-[350px] rounded-2xl md:rounded-3xl overflow-hidden border @error('latitude') border-red-500 @else border-gray-200 @enderror shadow-inner group">
                            <div id="map" class="absolute inset-0 z-10"></div>
                            <div
                                class="absolute inset-0 bg-gray-100 flex items-center justify-center text-gray-400 z-0">
                                <i data-feather="map-pin" class="w-8 h-8 animate-bounce"></i>
                            </div>
                        </div>
                        @error('latitude')
                            <p class="text-[10px] text-red-600 mt-1 font-bold italic">* Mohon tentukan titik lokasi pada
                                peta</p>
                        @enderror

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                        {{-- Patokan Detail --}}
                        <div class="mt-6">
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">
                                Patokan Lokasi Detail <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-feather="navigation"
                                        class="w-4 h-4 @error('lokasi') text-red-400 @else text-gray-400 @enderror group-focus-within:text-gray-900 transition-colors"></i>
                                </div>
                                <input type="text" name="lokasi" id="lokasi_text" value="{{ old('lokasi') }}"
                                    class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-white border @error('lokasi') border-red-500 @else border-gray-200 @enderror focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none text-sm font-bold text-gray-900 placeholder-gray-400 transition-all shadow-sm"
                                    placeholder="Contoh: Depan Balai Desa, dekat tiang listrik">
                            </div>
                            @error('lokasi')
                                <p class="text-[10px] text-red-600 mt-1 font-bold italic">* {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dusun, RT, RW --}}
                        <div class="mt-5">
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">
                                Wilayah Administratif (Desa Gonilan) <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="relative group sm:col-span-3">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-feather="map"
                                            class="w-4 h-4 @error('dusun') text-red-400 @else text-gray-400 @enderror group-focus-within:text-gray-900 transition-colors"></i>
                                    </div>
                                    <select name="dusun"
                                        class="w-full pl-11 pr-8 py-3.5 rounded-xl bg-white border @error('dusun') border-red-500 @else border-gray-200 @enderror focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all shadow-sm">
                                        <option value="" disabled selected>Pilih Dusun / Dukuh...</option>
                                        @foreach (['Gonilan', 'Morodipan', 'Nilagraha', 'Nilasari', 'Nilasari Kulon', 'Tanuragan', 'Tuwak Lor', 'Tuwak Kulon', 'Tuwak Wetan'] as $d)
                                            <option value="{{ $d }}"
                                                {{ old('dusun') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    @error('dusun')
                                        <p class="text-[10px] text-red-600 mt-1 font-bold italic">* Dusun wajib dipilih</p>
                                    @enderror
                                </div>

                                <div class="relative group sm:col-span-1">
                                    <select name="rt"
                                        class="w-full px-4 py-3.5 rounded-xl bg-white border @error('rt') border-red-500 @else border-gray-200 @enderror focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all shadow-sm">
                                        <option value="" disabled selected>RT...</option>
                                        @for ($i = 1; $i <= 34; $i++)
                                            @php $val = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                            <option value="{{ $val }}"
                                                {{ old('rt') == $val ? 'selected' : '' }}>RT {{ $val }}
                                            </option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    @error('rt')
                                        <p class="text-[10px] text-red-600 mt-1 font-bold italic">* RT wajib</p>
                                    @enderror
                                </div>

                                <div class="relative group sm:col-span-1">
                                    <select name="rw"
                                        class="w-full px-4 py-3.5 rounded-xl bg-white border @error('rw') border-red-500 @else border-gray-200 @enderror focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all shadow-sm">
                                        <option value="" disabled selected>RW...</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            @php $val = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                            <option value="{{ $val }}"
                                                {{ old('rw') == $val ? 'selected' : '' }}>RW {{ $val }}
                                            </option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    @error('rw')
                                        <p class="text-[10px] text-red-600 mt-1 font-bold italic">* RW wajib</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT SIDE (FORM PELAPOR) --}}
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
                                                class="w-4 h-4 @error('nama') text-red-400 @else text-gray-400 @enderror group-focus-within:text-gray-900 transition-colors"></i>
                                        </div>
                                        <input type="text" name="nama" value="{{ old('nama') }}"
                                            placeholder="Nama Lengkap *"
                                            class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-gray-50 border @error('nama') border-red-500 @else border-gray-200 @enderror focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 placeholder-gray-400 transition-all">
                                        @error('nama')
                                            <p class="text-[10px] text-red-600 mt-1 font-bold italic">*
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i data-feather="phone"
                                                class="w-4 h-4 @error('no_telepon') text-red-400 @else text-gray-400 @enderror group-focus-within:text-gray-900 transition-colors"></i>
                                        </div>
                                        <input type="tel" inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="no_telepon"
                                            value="{{ old('no_telepon') }}" placeholder="Nomor WhatsApp *"
                                            class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-gray-50 border @error('no_telepon') border-red-500 @else border-gray-200 @enderror focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 placeholder-gray-400 transition-all">
                                        @error('no_telepon')
                                            <p class="text-[10px] text-red-600 mt-1 font-bold italic">*
                                                {{ $message }}</p>
                                        @enderror
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
                                                class="w-4 h-4 @error('kategori') text-red-400 @else text-gray-400 @enderror group-focus-within:text-gray-900 transition-colors"></i>
                                        </div>
                                        <select name="kategori"
                                            class="w-full pl-11 pr-10 py-3.5 rounded-xl bg-gray-50 border @error('kategori') border-red-500 @else border-gray-200 @enderror focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none font-bold text-sm text-gray-900 appearance-none cursor-pointer transition-all">
                                            <option value="" disabled selected>Pilih Kategori Masalah... *
                                            </option>
                                            <option value="Masalah Kerusakan"
                                                {{ old('kategori') == 'Masalah Kerusakan' ? 'selected' : '' }}>Masalah
                                                Kerusakan Fasilitas</option>
                                            <option value="Masalah Kebersihan"
                                                {{ old('kategori') == 'Masalah Kebersihan' ? 'selected' : '' }}>Masalah
                                                Kebersihan / Sampah</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                        @error('kategori')
                                            <p class="text-[10px] text-red-600 mt-1 font-bold italic">* Pilih salah satu
                                                kategori</p>
                                        @enderror
                                    </div>
                                    <div class="relative">
                                        <textarea name="deskripsi" rows="4" placeholder="Jelaskan kondisi di lapangan secara detail... *"
                                            class="w-full px-5 py-4 rounded-xl bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-200 @enderror focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 outline-none text-sm font-medium text-gray-900 placeholder-gray-400 transition-all resize-none">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <p class="text-[10px] text-red-600 mt-1 font-bold italic">*
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
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
                                    class="relative flex flex-col items-center justify-center w-full h-56 border-2 border-dashed @error('foto_awal') border-red-400 bg-red-50/30 @else border-gray-300 bg-gray-50 @enderror rounded-2xl hover:border-gray-900 hover:bg-gray-100/50 transition-all cursor-pointer overflow-hidden group">
                                    <div id="upload-placeholder"
                                        class="text-center space-y-2 @error('foto_awal') text-red-400 @else text-gray-400 @enderror group-hover:text-gray-900 transition-colors z-10 p-6">
                                        <div
                                            class="w-14 h-14 bg-white rounded-full shadow-sm border border-gray-200 flex items-center justify-center mx-auto mb-3">
                                            <i data-feather="image" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-[11px] font-black uppercase tracking-widest">Pilih Foto Bukti
                                            <span class="text-red-500">*</span></p>
                                        <p class="text-xs font-medium opacity-70">Maksimal ukuran file 5MB</p>
                                    </div>
                                    <input type="file" name="foto_awal" class="hidden" accept="image/*"
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
                                @error('foto_awal')
                                    <p class="text-[10px] text-red-600 mt-2 font-bold italic text-center">*
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- SUBMIT --}}
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

    {{-- Scripts tetap sama seperti sebelumnya --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        // ... (Logika script leaflet & preview image Anda sama seperti sebelumnya) ...
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
                    if (typeof feather !== 'undefined') feather.replace();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Inisialisasi peta Gonilan
        var batasSelatanBarat = L.latLng(-7.561500, 110.762000);
        var batasUtaraTimur = L.latLng(-7.548000, 110.778000);
        var wilayahGonilan = L.latLngBounds(batasSelatanBarat, batasUtaraTimur);
        var titikTengahGonilan = [-7.555000, 110.770000];

        // Gunakan nilai old() jika ada, jika tidak gunakan default
        var initialLat = document.getElementById('latitude').value || titikTengahGonilan[0];
        var initialLng = document.getElementById('longitude').value || titikTengahGonilan[1];

        var map = L.map('map', {
            maxBounds: wilayahGonilan,
            maxBoundsViscosity: 1.0,
            minZoom: 15
        }).setView([initialLat, initialLng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        function updateInputs(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        marker.on('dragend', function() {
            var pos = marker.getLatLng();
            if (!wilayahGonilan.contains(pos)) {
                alert("⚠️ Titik lokasi berada di luar Desa Gonilan!");
                marker.setLatLng(titikTengahGonilan);
                map.setView(titikTengahGonilan, 16);
                updateInputs(titikTengahGonilan[0], titikTengahGonilan[1]);
            } else {
                updateInputs(pos.lat, pos.lng);
            }
        });

        map.on('click', function(e) {
            if (wilayahGonilan.contains(e.latlng)) {
                marker.setLatLng(e.latlng);
                updateInputs(e.latlng.lat, e.latlng.lng);
            }
        });
    </script>
</x-guest-layout>
