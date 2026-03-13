<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'location'    => 'required|string',
        ]);

        // 2. Normalisasi Input (Hapus spasi ganda, trim, lowercase)
        $cleanDesc = $this->normalizeString($validated['description']);
        $cleanLoc  = $this->normalizeString($validated['location']);

        // 3. AMBIL DATA LAMA (Strategi Lebih Luas)
        // Ambil laporan 30 hari terakhir.
        // Jangan filter 'location' secara ketat di SQL, filter di PHP saja agar lebih aman.
        $recentReports = Report::where('created_at', '>=', now()->subDays(30))
            ->get(['description', 'location']); // Ambil kolom yg butuh aja biar ringan

        foreach ($recentReports as $report) {
            // Normalisasi data dari database
            $dbDesc = $this->normalizeString($report->description);
            $dbLoc  = $this->normalizeString($report->location);

            // Cek Lokasi Dulu (Harus sama persis setelah dinormalisasi)
            // Jika lokasi "Karanganyar" vs "Solo", skip cek deskripsi
            if ($cleanLoc !== $dbLoc) {
                // Opsional: Jika ingin cek radius lokasi (advanced), tapi untuk teks cukup exact match
                // Kita juga bisa pakai levenshtein untuk lokasi jika sering typo
                if ($this->calculateSimilarity($cleanLoc, $dbLoc) < 80) {
                    continue;
                }
            }

            // CEK 1: SAMA PERSIS (100% DUPLIKAT)
            if ($cleanDesc === $dbDesc) {
                return back()
                    ->withInput()
                    ->with('error', 'GAGAL: Laporan ini sudah ada (100% sama). Mohon tidak spam.');
            }

            // CEK 2: MIRIP (FUZZY MATCH / TYPO)
            // Menggunakan similar_text atau levenshtein
            $percent = 0;
            similar_text($cleanDesc, $dbDesc, $percent);

            if ($percent >= 75) {
                return back()
                    ->withInput()
                    ->with('error', 'GAGAL: Laporan serupa sudah ada di lokasi ini.');
            }
        }

        // 4. Jika lolos semua cek, baru simpan
        Report::create($validated);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diterima.');
    }

    // --- HELPER FUNCTION YANG KUAT ---

    /**
     * Membersihkan string sebersih-bersihnya.
     * " Jalan   Rusak! " -> "jalanrusak"
     */
    private function normalizeString($str)
    {
        // 1. Lowercase
        $str = strtolower($str);
        // 2. Hapus semua simbol (hanya angka dan huruf)
        $str = preg_replace('/[^a-z0-9]/', '', $str);
        return $str;
    }

    private function calculateSimilarity($str1, $str2)
    {
        $percent = 0;
        similar_text($str1, $str2, $percent);
        return $percent;
    }
}
