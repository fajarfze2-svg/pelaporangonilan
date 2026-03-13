<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // --- DASHBOARD TEKNISI ---
    public function dashboard()
    {
        dd('HALO SAYA DI SINI');
        // Ambil laporan yang statusnya 'diproses' milik teknisi yang login
        $laporans = Laporan::where('status', 'diproses')
            ->where('teknisi_id', Auth::id())
            ->latest()
            ->get();

        return view('teknisi.dashboard', compact('laporans'));
    }

    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Data Statistik untuk 3 Kartu di atas (Total, Aktif, Selesai)
        $stats = [
            'total'          => Laporan::where('teknisi_id', $userId)->count(),
            'pending_action' => Laporan::where('teknisi_id', $userId)->where('status', 'diproses')->count(),
            'completed'      => Laporan::where('teknisi_id', $userId)->where('status', 'selesai')->count(),
        ];

        // 2. Ambil laporan tugas aktif saat ini
        $tasks = Laporan::where('status', 'diproses')
            ->where('teknisi_id', $userId)
            ->latest()
            ->get();

        // 3. Query untuk Riwayat Pekerjaan (Selesai)
        $query = Laporan::where('teknisi_id', $userId)
            ->where('status', 'selesai');

        // 4. Logika Pencarian untuk Riwayat
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tiket', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 5. Eksekusi Riwayat dengan Pagination (5 data per halaman)
        $completedTasks = $query->latest()->paginate(5);


        $completedTasks->appends($request->query());

        // 6. Kirim ketiga variabel ke tampilan (Blade)
        return view('teknisi.dashboard', compact('stats', 'tasks', 'completedTasks'));
    }

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->teknisi_id != Auth::id()) {
            abort(403, 'Akses Ditolak: Tugas ini bukan milik Anda.');
        }
        return view('teknisi.laporan.show', compact('laporan'));
    }

    // --- MULAI TUGAS (Start) ---
    public function startTask($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Validasi Pemilik Tugas
        if ($laporan->teknisi_id != Auth::id()) {
            return back()->with('error', 'Gagal: Tugas ini bukan milik Anda.');
        }

        // Cek status agar tidak di-start berkali-kali
        if ($laporan->status !== 'menunggu' && $laporan->status !== 'baru') {
            return back()->with('info', 'Status tugas sudah berubah.');
        }


        $laporan->update([
            'status' => 'diproses'
        ]);

        return back()->with('success', 'Tugas dimulai! Waktu pengerjaan dicatat.');
    }
    // --- UPLOAD BUKTI & SELESAI ---

    public function storeBukti(Request $request)
    {
        $request->validate([
            'task_id'         => 'required',
            // Pastikan ini cocok dengan <input type="file" name="bukti_foto"> di HTML Teknisi
            'bukti_foto'      => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'catatan_teknisi' => 'nullable|string|max:500',
        ]);

        $laporan = Laporan::findOrFail($request->task_id);

        // 1. Validasi Security (Wajib)
        if ($laporan->teknisi_id != Auth::id()) {
            return back()->with('error', 'UPLOAD GAGAL. Tugas ini bukan milik akun Anda.');
        }

        // 2. Upload File (Gunakan nama 'bukti_foto' secara konsisten)
        if ($request->hasFile('bukti_foto')) {

            // Hapus foto lama jika sebelumnya sudah ada (misal saat revisi)
            if ($laporan->bukti_foto && Storage::disk('public')->exists($laporan->bukti_foto)) {
                Storage::disk('public')->delete($laporan->bukti_foto);
            }

            // Simpan foto baru
            $path = $request->file('bukti_foto')->store('bukti_pekerjaan', 'public');

            // Simpan path-nya ke kolom 'bukti_foto' di database
            $laporan->bukti_foto = $path;
        }

        // 3. Update Catatan & STATUS SELESAI
        $laporan->catatan_teknisi = $request->catatan_teknisi;
        $laporan->status = 'selesai';

        $laporan->save();

        return redirect()->route('dashboard')->with('success', 'Laporan terkirim! Tugas selesai dan menunggu validasi Admin.');
    }
}
