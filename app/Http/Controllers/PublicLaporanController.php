<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicLaporanController extends Controller
{

    public function index()
    {
        $totalLaporan = Laporan::count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();

        return view('welcome', compact('totalLaporan', 'laporanSelesai'));
    }


    public function create()
    {
        return view('admin.laporan.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required',
            'lokasi'     => 'required|string',
            'deskripsi'  => 'required|string',
            'foto_awal'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'latitude'   => 'nullable',
            'longitude'  => 'nullable',
            'kategori'   => 'required',
            'no_telepon' => 'required|string|max:20',
            'dusun'      => 'required|string',
            'rt'         => 'required|string',
            'rw'         => 'required|string',
        ]);

        // =========================================================
        // VALIDASI GEOFENCING: TOLAK JIKA DI LUAR DESA GONILAN
        // =========================================================
        $lat = $request->latitude;
        $lng = $request->longitude;

        // Gunakan angka batas yang sama persis dengan di JavaScript
        $minLat = -7.561500;
        $maxLat = -7.548000;
        $minLng = 110.762000;
        $maxLng = 110.778000;

        // Cek jika lat/lng ada nilainya, baru lakukan pengecekan batas
        if ($lat && $lng) {
            if ($lat < $minLat || $lat > $maxLat || $lng < $minLng || $lng > $maxLng) {
                return back()
                    ->withInput()
                    ->with('error_duplikat', 'Laporan ditolak! Titik lokasi infrastruktur yang Anda laporkan berada di luar jangkauan wilayah administratif Desa Gonilan.');
            }
        }
        // =========================================================

        $inputFotoHash = null;
        if ($request->hasFile('foto_awal')) {
            $inputFotoHash = md5_file($request->file('foto_awal')->getRealPath());
        }

        $inputDesc     = $this->normalizeString($validated['deskripsi'] ?? '');
        $inputLoc      = $this->normalizeString($validated['lokasi'] ?? '');
        $inputKategori = request('kategori');
        $inputTelepon  = $validated['no_telepon'];

        // ==========================================
        // PERTAHANAN LAPIS 1: Limit Laporan Harian (Rate Limiting)
        // ==========================================
        $laporanHariIni = Laporan::where('no_telepon', $inputTelepon)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($laporanHariIni >= 3) {
            return back()
                ->withInput()
                ->with('error', 'Limit Tercapai: Nomor telepon ini sudah mengirim maksimal 3 laporan hari ini. Silakan coba lagi besok.');
        }

        // ==========================================
        // PERTAHANAN LAPIS 2: ALGORITMA CERDAS (Kombinasi Lokasi & Deskripsi)
        // ==========================================
        $recentReports = Laporan::where('created_at', '>=', now()->subDays(30))->get();

        foreach ($recentReports as $report) {
            $dbDesc = $this->normalizeString($report->deskripsi ?? '');
            $dbLoc  = $this->normalizeString($report->lokasi ?? '');

            // A. Hitung Kemiripan DESKRIPSI (Damerau-Levenshtein)
            $distanceDesc = $this->calculateDamerauLevenshtein($inputDesc, $dbDesc);
            $maxLenDesc   = max(strlen($inputDesc), strlen($dbDesc));
            $simDescPercent = $maxLenDesc > 0 ? (($maxLenDesc - $distanceDesc) / $maxLenDesc) * 100 : 0;

            // B. Hitung Kemiripan LOKASI (Damerau-Levenshtein)
            $distanceLoc = $this->calculateDamerauLevenshtein($inputLoc, $dbLoc);
            $maxLenLoc   = max(strlen($inputLoc), strlen($dbLoc));
            $simLocPercent = $maxLenLoc > 0 ? (($maxLenLoc - $distanceLoc) / $maxLenLoc) * 100 : 0;

            // C. LOGIKA KEPUTUSAN (Hanya dicek jika Kategori sama)
            if ($inputKategori === $report->kategori) {

                $isDuplicate = false;

                // KONDISI 1: Lokasi Sangat Mirip/Sama (>= 90%) DAN Deskripsi lumayan mirip (>= 50%)
                if ($simLocPercent >= 90 && $simDescPercent >= 50) {
                    $isDuplicate = true;
                }
                // KONDISI 2: Deskripsi Sangat Mirip (>= 75%), terlepas dari penulisan lokasinya
                else if ($simDescPercent >= 75) {
                    $isDuplicate = true;
                }

                // JIKA TERDETEKSI DUPLIKAT
                if ($isDuplicate) {
                    if (in_array($report->status, ['selesai', 'closed'])) {
                        $pesanTolak = "Laporan Ditolak! Masalah serupa di lokasi tersebut sudah pernah dilaporkan dan sudah TERATASI (Tiket #{$report->tiket}).";
                    } else {
                        $pesanTolak = "Laporan Ditolak! Masalah serupa di lokasi tersebut sudah dilaporkan sebelumnya dan SEDANG DIPROSES (Tiket #{$report->tiket}).";
                    }

                    return back()->withInput()->with('error_duplikat', $pesanTolak);
                }
            }

            // ==========================================
            // PERTAHANAN LAPIS 3: Foto Identik 100% (MD5 Hash)
            // ==========================================
            if ($inputFotoHash && $report->foto_awal) {
                $namaFile = basename($report->foto_awal);
                $pathFotoLama = public_path('storage/laporan/' . $namaFile);

                if (file_exists($pathFotoLama)) {
                    $dbFotoHash = md5_file($pathFotoLama);
                    if ($inputFotoHash === $dbFotoHash) {
                        return back()
                            ->withInput()
                            ->with('error_duplikat', 'Laporan ditolak: Gambar (foto) yang Anda unggah sudah pernah digunakan pada laporan lain (Tiket #' . $report->tiket . ').');
                    }
                }
            }
        }

        // ==========================================
        // JIKA LOLOS SEMUA PERTAHANAN -> SIMPAN DATA
        // ==========================================
        $fotoPath = null;
        if ($request->hasFile('foto_awal')) {
            $fotoPath = $request->file('foto_awal')->store('laporan', 'public');
        }

        do {
            $tiket = 'LPR-' . strtoupper(Str::random(5));
        } while (Laporan::where('tiket', $tiket)->exists());

        Laporan::create([
            'tiket'      => $tiket,
            'nama'       => $validated['nama'] ?? $request->nama,
            'no_telepon' => $validated['no_telepon'] ?? $request->no_telepon,
            'deskripsi'  => $validated['deskripsi'],
            'lokasi'     => $validated['lokasi'],
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'foto_awal'  => $fotoPath,
            'status'     => 'baru',
            'kategori'   => $request->kategori,
            'dusun'      => $request->dusun,
            'rt'         => $request->rt,
            'rw'         => $request->rw,
        ]);

        // =================================================================
        // FITUR BARU: KIRIM NOTIFIKASI WHATSAPP KE PELAPOR (API FONNTE)
        // =================================================================

        // 1. Pastikan nomor telepon diawali dengan format yang benar (08... atau 628...)
        $targetWA = $request->no_telepon;

        // 2. Format Pesan WA yang Elegan
        $pesanWA = "Halo Bapak/Ibu *{$request->nama}*, 👋\n\n";
        $pesanWA .= "Laporan Anda telah berhasil kami terima dan masuk ke dalam sistem. Silakan pantau perkembangan perbaikan secara real-time hingga selesai melalui tautan dan kode tiket berikut:\n\n";
        $pesanWA .= "🎫 *KODE TIKET: {$tiket}*\n";
        $pesanWA .= "🔗 *Link Pantau:* " . route('laporan.cek') . "?tiket=" . $tiket . "\n\n";
        $pesanWA .= "Terima kasih atas laporan dan kepedulian Anda terhadap fasilitas publik. Tim teknisi kami akan segera menindaklanjuti laporan tersebut.\n\n";
        $pesanWA .= "Salam hangat,\n*Admin Smart Public Facility Desa Gonilan*";

        // 3. Proses Pengiriman menggunakan cURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $targetWA,
                'message' => $pesanWA,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: tWNoDntFdeqVyoJsPFe6'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return redirect()->route('laporan.sukses', $tiket);
    }

    public function sukses($tiket)
    {
        return view('laporan.sukses', compact('tiket'));
    }

    public function cekStatus(Request $request)
    {
        $laporan = null;

        if ($request->filled('tiket')) {
            $inputTiket = $request->tiket;
            $cleanTiket = trim(str_replace('#', '', $inputTiket));
            $cleanTiket = strtoupper($cleanTiket);
            $laporan = \App\Models\Laporan::where('tiket', $cleanTiket)->first();
        }

        return view('laporan.cek', compact('laporan'));
    }


    // -----------------------------------------------------------------
    // PRIVATE HELPER FUNCTIONS
    // -----------------------------------------------------------------

    /**
     * Algoritma Damerau-Levenshtein Distance
     */
    private function calculateDamerauLevenshtein($str1, $str2)
    {
        $len1 = strlen($str1);
        $len2 = strlen($str2);

        if ($len1 == 0) return $len2;
        if ($len2 == 0) return $len1;

        $d = array();

        for ($i = 0; $i <= $len1; $i++) {
            $d[$i][0] = $i;
        }
        for ($j = 0; $j <= $len2; $j++) {
            $d[0][$j] = $j;
        }

        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                $cost = ($str1[$i - 1] == $str2[$j - 1]) ? 0 : 1;

                $d[$i][$j] = min(
                    $d[$i - 1][$j] + 1,                 // Deletion
                    $d[$i][$j - 1] + 1,                 // Insertion
                    $d[$i - 1][$j - 1] + $cost          // Substitution
                );

                // Transposition
                if ($i > 1 && $j > 1 && $str1[$i - 1] == $str2[$j - 2] && $str1[$i - 2] == $str2[$j - 1]) {
                    $d[$i][$j] = min(
                        $d[$i][$j],
                        $d[$i - 2][$j - 2] + $cost
                    );
                }
            }
        }
        return $d[$len1][$len2];
    }

    private function normalizeString($string)
    {
        if (empty($string)) return '';
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9\s]/', '', $string);
        $string = preg_replace('/\s+/', ' ', $string);
        return trim($string);
    }
}
