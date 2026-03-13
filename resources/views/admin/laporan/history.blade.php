<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
        <div class="max-w-7xl mx-auto space-y-8">
            

         <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <i data-feather="list" class="text-blue-600 w-12 h-12"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">History Laporan</h1>
            <p class="text-gray-600 text-sm">Lihat semua laporan yang telah Anda kirim</p>
        </div>



        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-50/80 backdrop-blur-sm border border-green-200 rounded-xl p-4 shadow-lg flex items-center space-x-3">
                <i data-feather="check-circle" class="text-green-600 w-5 h-5"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif



        <!-- Daftar Laporan -->
        <div class="bg-white/70 backdrop-blur-sm shadow-lg rounded-xl border border-blue-200 overflow-hidden">
            @if ($laporans->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach ($laporans as $laporan)
                        <div class="p-8 hover:bg-blue-50/50 transition duration-200 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Detail Laporan -->
                                <div class="md:col-span-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $laporan->nama }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $laporan->deskripsi }}</p>
                                    <div class="mt-3 space-y-1 text-sm text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            <i data-feather="phone" class="w-4 h-4"></i>
                                            <span>{{ $laporan->no_telepon }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <i data-feather="map-pin" class="w-4 h-4"></i>
                                            <span>{{ $laporan->lokasi }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <i data-feather="calendar" class="w-4 h-4"></i>
                                            <span>{{ $laporan->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                </div>


                                <!-- Foto dan Status -->
                                <div class="flex flex-col items-center space-y-4">
                                    @if ($laporan->foto)
                                        <img src="{{ asset('storage/' . $laporan->foto) }}"
                                            class="w-24 h-24 object-cover rounded-lg border border-gray-300 shadow-sm">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i data-feather="image" class="w-8 h-8 text-gray-400"></i>
                                        </div>
                                    @endif
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if ($laporan->status == 'baru') bg-yellow-100 text-yellow-800
                                        @elseif($laporan->status == 'diproses') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($laporan->status ?? 'baru') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <i data-feather="inbox" class="w-16 h-16 mx-auto mb-4 text-gray-400"></i>
                    <p class="text-gray-600 font-medium text-lg">Belum ada laporan</p>
                    <p class="text-sm text-gray-500 mt-2">Kirim laporan pertama Anda sekarang!</p>
                    <a href="{{ route('laporan.create') }}"
                        class="mt-6 inline-block bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-1 hover:scale-105 flex items-center space-x-2">
                        <i data-feather="plus" class="w-5 h-5"></i>
                        <span>Buat Laporan</span>
                    </a>
                </div>
            @endif
        </div>

<script>
    feather.replace();
</script>
</x-guest-layout>
