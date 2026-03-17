<x-app-layout>
    <x-slot name="header">
        {{-- Import Font Google: Montserrat (Judul) & Inter (Teks UI) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        {{-- Wrapper Header: Formal Glassmorphism --}}
        <div
            class="relative pt-10 pb-6 bg-white/70 backdrop-blur-2xl border-b border-slate-200/80 shadow-[0_2px_15px_rgba(15,23,42,0.03)] overflow-hidden">

            {{-- Pancaran Glow Sangat Halus (Lebih redup dan formal) --}}
            <div
                class="absolute top-[-50%] right-[10%] w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[100px] pointer-events-none z-0">
            </div>
            <div
                class="absolute bottom-[-30%] left-[5%] w-[400px] h-[400px] bg-slate-400/10 rounded-full blur-[80px] pointer-events-none z-0">
            </div>

            {{-- Konten Header --}}
            <div
                class="relative z-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">

                {{-- KIRI: Judul dan Deskripsi --}}
                <div>
                    {{-- Logika Sapaan Waktu Otomatis --}}
                    @php
                        // Memastikan menggunakan zona waktu yang tepat (WIB/Asia Jakarta)
                        $hour = \Carbon\Carbon::now('Asia/Jakarta')->format('H');
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

                    {{-- PERUBAHAN 1 & 2: Font Serif untuk Sapaan, Warna Emas untuk Nama Admin --}}
                    <h2
                        class="text-4xl md:text-5xl font-semibold text-[#0F2854] font-serif tracking-tight leading-tight">
                        {{ $greeting }}, <span class="text-[#CBA135]">{{ auth()->user()->name }}</span>
                    </h2>

                    {{-- Deskripsi menggunakan INTER --}}
                    <p class="mt-3 text-sm font-medium text-slate-500 max-w-xl leading-relaxed font-['Inter']">
                        Pantau seluruh aktivitas laporan masuk, status pengerjaan teknisi, dan performa fasilitas secara
                        real-time.
                    </p>
                </div>

                {{-- KANAN: Tanggal Sistem (Modern Date Badge) --}}
                <div class="shrink-0 mb-1">
                    {{-- PERUBAHAN 3: Background Navy dan border disesuaikan --}}
                    <div
                        class="flex items-center gap-3 px-4 py-2.5 bg-[#0F2854] border border-[#1A3A73] rounded-2xl shadow-md">

                        {{-- Ikon Kalender (Warna Putih Transparan) --}}
                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white border border-white/20">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                        </div>

                        {{-- Format Tanggal Laravel Carbon menggunakan INTER --}}
                        <div class="flex flex-col pr-2">
                            {{-- Teks Label (Biru Muda) --}}
                            <span class="text-[9px] font-black uppercase tracking-widest text-blue-200 font-['Inter']">
                                Tanggal Sistem
                            </span>
                            {{-- Teks Tanggal (Putih Solid) --}}
                            <span class="text-sm font-bold text-white font-['Inter'] tracking-wide">
                                {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Main Container --}}
    <div class="py-8 bg-[#F7F8F0] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ================= 2. MAIN GRID ================= --}}
            <section class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

                {{-- KOLOM KIRI: 2 CARDS (Sedang Proses & Butuh Validasi) --}}
                <div class="flex flex-col gap-6 lg:col-span-1">

                    {{-- Card 1: Total Laporan --}}
                    <div
                        class="bg-white rounded-2xl border border-slate-200 p-6 flex justify-between items-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
                        <div>
                            <p
                                class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 group-hover:text-slate-600 transition-colors">
                                Total Laporan</p>
                            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalLaporan ?? 0 }}</h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                            <i data-feather="folder" class="w-6 h-6 text-slate-800"></i>
                        </div>
                    </div>

                    {{-- Card 2: Perlu Tindakan --}}
                    @php
                        $countBaru = is_numeric($laporanBaru) ? $laporanBaru : $laporanBaru->count();
                    @endphp
                    <div
                        class="rounded-2xl border p-6 flex justify-between items-center transition-all duration-300 group relative overflow-hidden hover:-translate-y-1 {{ $countBaru > 0 ? 'bg-red-50 border-red-200 shadow-[0_8px_30px_rgb(239,68,68,0.2)]' : 'bg-white border-slate-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]' }}">
                        <div
                            class="absolute top-0 left-0 w-full h-1 bg-red-500 transition-opacity {{ $countBaru > 0 ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}">
                        </div>
                        @if ($countBaru > 0)
                            <span class="absolute top-4 right-4 flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                        @endif
                        <div>
                            <p
                                class="text-[11px] font-bold uppercase tracking-widest mb-1 transition-colors {{ $countBaru > 0 ? 'text-red-600' : 'text-slate-400 group-hover:text-red-500' }}">
                                Perlu Tindakan
                            </p>
                            <h3
                                class="text-3xl font-black tracking-tight {{ $countBaru > 0 ? 'text-red-700' : 'text-slate-900' }}">
                                {{ $countBaru }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl border flex items-center justify-center transition-transform duration-300 shadow-sm group-hover:scale-110 {{ $countBaru > 0 ? 'bg-red-100 border-red-200' : 'bg-slate-50 border-slate-100' }}">
                            <i data-feather="alert-octagon"
                                class="w-6 h-6 {{ $countBaru > 0 ? 'text-red-600' : 'text-slate-800' }}"></i>
                        </div>
                    </div>

                    {{-- Card Sedang Proses --}}
                    <div
                        class="bg-white rounded-2xl border border-slate-200 p-6 flex justify-between items-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-full h-1 bg-amber-500 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div>
                            <p
                                class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 group-hover:text-amber-500 transition-colors">
                                Sedang Proses</p>
                            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $laporanProses ?? 0 }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                            <i data-feather="settings" class="w-6 h-6 text-slate-600 group-hover:animate-spin"
                                style="animation-duration: 3s;"></i>
                        </div>
                    </div>


                    {{-- Card Butuh Validasi --}}
                    <a href="{{ route('admin.laporan.index') }}?status=selesai"
                        class="block rounded-2xl border p-6 flex justify-between items-center transition-all duration-300 group relative overflow-hidden hover:-translate-y-1 {{ ($butuhValidasi ?? 0) > 0 ? 'bg-indigo-50 border-indigo-200 shadow-[0_8px_30px_rgb(99,102,241,0.2)]' : 'bg-white border-slate-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)]' }}">
                        <div
                            class="absolute top-0 left-0 w-full h-1 bg-indigo-500 transition-opacity {{ ($butuhValidasi ?? 0) > 0 ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}">
                        </div>
                        @if (($butuhValidasi ?? 0) > 0)
                            <span class="absolute top-4 right-4 flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                            </span>
                        @endif
                        <div>
                            <p
                                class="text-[11px] font-bold uppercase tracking-widest mb-1 transition-colors {{ ($butuhValidasi ?? 0) > 0 ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-500' }}">
                                Butuh Validasi
                            </p>
                            <h3
                                class="text-3xl font-black tracking-tight {{ ($butuhValidasi ?? 0) > 0 ? 'text-indigo-700' : 'text-slate-900' }}">
                                {{ $butuhValidasi ?? 0 }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl border flex items-center justify-center transition-transform duration-300 shadow-sm group-hover:scale-110 {{ ($butuhValidasi ?? 0) > 0 ? 'bg-indigo-100 border-indigo-200' : 'bg-slate-50 border-slate-100' }}">
                            <i data-feather="shield"
                                class="w-6 h-6 {{ ($butuhValidasi ?? 0) > 0 ? 'text-indigo-600' : 'text-slate-800' }}"></i>
                        </div>
                    </a>

                    {{-- Card 3: Selesai --}}
                    <div
                        class="bg-white rounded-2xl border border-slate-200 p-6 flex justify-between items-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-full h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div>
                            <p
                                class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 group-hover:text-emerald-500 transition-colors">
                                Tuntas (Closed)</p>
                            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $laporanSelesai ?? 0 }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                            <i data-feather="check-square" class="w-6 h-6 text-emerald-500"></i>
                        </div>
                    </div>

                    {{-- Ketersediaan Teknisi --}}
                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full min-h-[350px]">
                        <div class="p-6 border-b border-slate-100">
                            <h3 class="font-bold text-slate-800 text-lg tracking-tight">Ketersediaan Teknisi</h3>
                            <p class="text-xs font-medium text-slate-500 mt-1">Status penugasan personel lapangan.
                            </p>
                        </div>
                        <div class="p-4 space-y-2 flex-1 overflow-y-auto max-h-[400px]">
                            @forelse($teknisiStats as $tek)
                                <div
                                    class="flex items-center justify-between p-3 rounded-xl border border-transparent hover:border-slate-100 hover:bg-slate-50 transition-all">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ substr($tek->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 text-sm">{{ $tek->name }}
                                            </div>
                                            <div
                                                class="text-[10px] font-bold uppercase tracking-wider mt-1 flex items-center gap-1.5 {{ $tek->tugas_aktif > 0 ? 'text-amber-500' : 'text-emerald-500' }}">
                                                <span
                                                    class="w-2 h-2 rounded-full {{ $tek->tugas_aktif > 0 ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                                                {{ $tek->tugas_aktif > 0 ? 'Sedang Bertugas' : 'Tersedia' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <div class="text-sm font-black text-slate-800 leading-none">
                                            {{ $tek->tugas_aktif }}
                                        </div>
                                        <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mt-1">
                                            Aktif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="h-full flex flex-col items-center justify-center text-center py-10">
                                    <i data-feather="users" class="w-8 h-8 text-slate-300 mb-3"></i>
                                    <p class="text-xs font-semibold text-slate-500">Data teknisi belum tersedia.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: GRAFIK & (PIE + TEKNISI) --}}
                <div class="flex flex-col gap-6 lg:col-span-3">

                    {{-- Grafik Line --}}
                    <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="mb-4 flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Statistik Laporan Masuk</h3>
                                <p class="text-xs font-medium text-slate-500 mt-1">Volume 7 hari terakhir berdasarkan
                                    tanggal.</p>
                            </div>
                            <div
                                class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-md border border-emerald-200 text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                                Live Data
                            </div>
                        </div>
                        <div id="chart-laporan" class="w-full min-h-[300px]"></div>
                    </div>

                    {{-- Grid 2 Kolom untuk Pie & Teknisi --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- Pie Chart --}}
                        <div
                            class="bg-white p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full min-h-[350px]">
                            <div class="mb-2">
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Distribusi Kategori</h3>
                                <p class="text-xs font-medium text-slate-500 mt-1">Persentase jenis aduan.</p>
                            </div>
                            <div class="relative flex justify-center items-center flex-1 py-4">
                                <div id="chart-kategori" class="z-10"></div>
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none z-0 mt-1">
                                    <span
                                        class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalLaporan ?? 0 }}</span>
                                    <span
                                        class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Total</span>
                                </div>
                            </div>
                            <div class="mt-2 space-y-2.5">
                                @php
                                    // Definisikan mapping warna secara eksplisit agar mudah dibaca
                                    $kategoriColors = [];
                                    foreach ($kategoriStats as $label => $count) {
                                        $kat = strtolower($label);
                                        if (str_contains($kat, 'kerusakan')) {
                                            $kategoriColors[] = '#FF0000'; // Merah
                                        } elseif (str_contains($kat, 'kebersihan')) {
                                            $kategoriColors[] = '#10B981'; // Hijau
                                        } else {
                                            $kategoriColors[] = '#3B82F6'; // Blue default
                                        }
                                    }
                                @endphp
                                @php $index = 0; @endphp
                                @foreach ($kategoriStats as $label => $count)
                                    <div
                                        class="flex justify-between items-center text-sm p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-2.5">
                                            {{-- Gunakan inline style untuk background-color agar tidak terkena PurgeCSS --}}
                                            <span class="w-3 h-3 rounded-full shadow-sm"
                                                style="background-color: {{ $kategoriColors[$index] }}"></span>
                                            <span class="font-medium text-slate-600">{{ $label }}</span>
                                        </div>
                                        <span class="font-bold text-slate-900">{{ $count }}</span>
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                            <div
                                class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-lg tracking-tight">Menunggu Validasi</h3>
                                    <p class="text-xs font-medium text-slate-500 mt-1">Antrean laporan baru yang butuh
                                        persetujuan.</p>
                                </div>
                                <a href="{{ route('admin.laporan.index') }}"
                                    class="px-4 py-2 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold shadow-sm transition-all">
                                    Lihat Semua
                                </a>
                            </div>

                            @if ($laporanPerluValidasi && count($laporanPerluValidasi) > 0)
                                <div class="overflow-x-auto flex-1">
                                    <table class="w-full text-sm text-left">
                                        <thead
                                            class="bg-white text-slate-400 border-b border-slate-100 uppercase tracking-wider text-[10px] font-bold">
                                            <tr>
                                                <th class="px-6 py-4">Tiket</th>
                                                <th class="px-6 py-4">Pelapor & Teknisi</th>
                                                <th class="px-6 py-4 text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($laporanPerluValidasi as $item)
                                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                                    {{-- Kolom Tiket --}}
                                                    <td class="px-6 py-4">
                                                        <span
                                                            class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                                            #{{ $item->tiket }}
                                                        </span>
                                                    </td>

                                                    {{-- Kolom Pelapor, Teknisi & Lokasi --}}
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            {{-- Nama Pelapor --}}
                                                            <span
                                                                class="font-bold text-slate-800">{{ $item->nama }}</span>
                                                        </div>

                                                        {{-- Lokasi --}}
                                                        <div
                                                            class="text-xs font-medium text-slate-500 truncate max-w-[250px] flex items-center gap-1">
                                                            <i data-feather="tool" class="w-3 h-3"></i>

                                                            {{ $item->teknisi->name }}
                                                        </div>
                                                    </td>

                                                    {{-- Kolom Aksi --}}
                                                    <td class="px-6 py-4 text-right">
                                                        <a href="{{ route('admin.laporan.show', $item->id) }}"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors">
                                                            <i data-feather="chevron-right" class="w-4 h-4"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-12 flex flex-col items-center justify-center text-center flex-1">
                                    <div
                                        class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4 text-slate-300">
                                        <i data-feather="check-circle" class="w-8 h-8"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-800">Antrean Kosong</h4>
                                    <p class="text-sm text-slate-500 mt-1">Sistem bersih. Tidak ada laporan baru hari
                                        ini.</p>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>

            </section>

        </div>
    </div>

    {{-- ================= CHART SCRIPT ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const chartData = @json($chartData ?? []);
            const kategoriStats = @json($kategoriStats ?? []);

            // 1. Tren 7 Hari (Laporan Masuk)
            if (Object.keys(chartData).length > 0) {
                new ApexCharts(document.querySelector("#chart-laporan"), {
                    series: [{
                        name: 'Laporan',
                        data: Object.values(chartData)
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit',
                    },
                    colors: ['#FFE100'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.5,
                            opacityTo: 0.05,
                            stops: [0, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: 4,
                        colors: ['#fff'],
                        strokeColors: '#FFE100',
                        strokeWidth: 2,
                        hover: {
                            size: 6
                        }
                    },
                    xaxis: {
                        categories: Object.keys(chartData),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4,
                    }
                }).render();
            }

            // 2. Donut Kategori
            // Di dalam script chart-kategori
            if (Object.keys(kategoriStats).length > 0) {
                const labels = Object.keys(kategoriStats);

                const dynamicColors = labels.map(label => {
                    const labelText = label.toLowerCase();
                    // Gunakan pengecekan yang lebih luas untuk menghindari typo (misal: 'kerusakan fasilitas')
                    if (labelText.includes('rusak') || labelText.includes('kerusakan')) return '#FF0000';
                    if (labelText.includes('bersih') || labelText.includes('kebersihan')) return '#10B981';

                    return '#3B82F6'; // Warna default jika tidak cocok
                });

                new ApexCharts(document.querySelector("#chart-kategori"), {
                    series: Object.values(kategoriStats),
                    labels: labels,
                    chart: {
                        type: 'donut',
                        height: 260,
                        fontFamily: 'Inter, sans-serif' // Pastikan font terpasang
                    },
                    colors: dynamicColors, // Menggunakan array warna yang sudah dibuat di atas
                    // ... sisa konfigurasi lainnya
                }).render();
            }
        });

        // Inisialisasi Feather Icons
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            } else {
                console.error("Feather icons script is not loaded!");
            }
        });
    </script>
</x-app-layout>
