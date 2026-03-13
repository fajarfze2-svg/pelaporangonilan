<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\StatusLaporanNotification;

class LaporanController extends Controller
{
    // 1. MENAMPILKAN DAFTAR LAPORAN
    public function index(Request $request)
    {
        // 1. Mulai query dengan memuat relasi (eager loading)
        $query = Laporan::with(['teknisi', 'pelapor']);

        // 2. Ambil data teknisi untuk keperluan dropdown/modal di halaman view
        $listTeknisi = User::where('role', 'teknisi')->get();

        // 3. Logika Pencarian Teks
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tiket', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        // 4. Logika Filter Status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('dusun') && $request->dusun !== 'semua') {
            $query->where('dusun', $request->dusun);
        }

        // 5. Eksekusi query dengan urutan terbaru dan pagination
        $laporans = $query->latest()->paginate(10);

        // 6. Menyimpan parameter URL agar saat pindah halaman (pagination), filternya tidak hilang
        $laporans->appends($request->query());

        return view('admin.laporan.index', compact('laporans', 'listTeknisi'));
    }

    // 2. MENAMPILKAN DETAIL LAPORAN (Form Penugasan ada di sini)
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        $listTeknisi = User::where('role', 'teknisi')->get();

        return view('admin.laporan.show', compact('laporan', 'listTeknisi'));
    }
    // 3. UPDATE STATUS & PENUGASAN (Manual, Tolak, Selesai)
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        // --- SKENARIO A: ADMIN MENOLAK LAPORAN (REVISI) ---
        if ($request->status == 'ditolak') {
            $request->validate([
                'catatan_admin' => 'required|string|max:255'
            ], [
                'catatan_admin.required' => 'Wajib mengisi alasan penolakan agar teknisi paham.'
            ]);

            $laporan->update([
                'status' => 'ditolak',
                'catatan_admin' => $request->catatan_admin
            ]);

            // Kirim Notifikasi ke Teknisi
            if ($laporan->teknisi) {
                $laporan->teknisi->notify(new StatusLaporanNotification($laporan, "⚠️ Laporan #{$laporan->tiket} DITOLAK. Alasan: {$request->catatan_admin}"));
            }

            return back()->with('success', 'Laporan ditolak. Teknisi diminta melakukan revisi.');
        }

        // --- SKENARIO B: ADMIN MENERIMA LAPORAN (FINAL/CLOSED) ---
        if ($request->status == 'closed') {
            $laporan->update([
                'status' => 'closed'
            ]);

            // Kirim Notifikasi ke Teknisi
            if ($laporan->teknisi) {
                $laporan->teknisi->notify(new StatusLaporanNotification($laporan, "✅ Pekerjaan #{$laporan->tiket} telah DISETUJUI & SELESAI."));
            }

            return back()->with('success', 'Laporan berhasil divalidasi dan ditutup.');
        }

        // --- SKENARIO C: ADMIN MEMILIH TEKNISI MANUAL (ASSIGN) ---
        if ($request->teknisi_id) {
            $request->validate([
                'teknisi_id' => 'exists:users,id',
                'catatan_admin' => 'nullable|string'
            ]);

            $laporan->update([
                'status' => 'proses', // Otomatis jadi proses jika ditugaskan
                'teknisi_id' => $request->teknisi_id,
                'catatan_admin' => $request->catatan_admin // Instruksi awal (opsional)
            ]);

            // Kirim Notifikasi ke Teknisi Baru
            $teknisi = User::find($request->teknisi_id);
            $teknisi->notify(new StatusLaporanNotification($laporan, "🛠️ Tugas Baru! Laporan #{$laporan->tiket} ditugaskan kepada Anda."));

            return back()->with('success', "Berhasil menugaskan teknisi {$teknisi->name}.");
        }

        return back()->with('error', 'Tidak ada perubahan yang disimpan.');
    }

    // 4. HAPUS LAPORAN
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hanya izinkan hapus jika status sudah final (selesai/closed/ditolak)
        // Laporan yang sedang 'proses' atau 'menunggu' tidak boleh dihapus sembarangan
        if (!in_array($laporan->status, ['selesai', 'closed', 'ditolak'])) {
            return back()->with('error', 'Laporan yang sedang aktif tidak dapat dihapus.');
        }

        if ($laporan->bukti_foto) {
            Storage::disk('public')->delete($laporan->bukti_foto);
        }

        $laporan->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    // 5. EXPORT PDF
    public function exportPdf()
    {
        $laporan = Laporan::with(['teknisi', 'pelapor'])->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengaduan-' . date('Y-m-d') . '.pdf');
    }
}
