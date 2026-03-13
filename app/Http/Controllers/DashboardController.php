<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // =========================================
        // 1. LOGIKA UNTUK ADMIN
        // =========================================
        if ($user->role === 'admin') {

            // Statistik Utama
            $totalLaporan   = Laporan::count();
            $laporanProses = Laporan::whereIn('status', ['proses', 'ditolak'])->count();
            $laporanSelesai = Laporan::whereIn('status', ['closed'])->count();
            $butuhValidasi  = Laporan::where('status', 'selesai')->count();
            $laporanBaru    = Laporan::whereIn('status', ['baru', 'menunggu'])->count();

            // ===============================
            // DATA GRAFIK 7 HARI (FORMAT AMAN)
            // ===============================
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $chartData[$date->format('d M')] = Laporan::whereDate('created_at', $date)->count();
            }

            // Statistik Teknisi
            $teknisiStats = User::where('role', 'teknisi')
                ->withCount(['reports as tugas_aktif' => function ($query) {
                    $query->where('status', 'proses');
                }])
                ->withCount(['reports as tugas_selesai' => function ($query) {
                    $query->whereIn('status', ['selesai', 'closed']);
                }])
                ->get();

            // Laporan Perlu Validasi (5 Terbaru)
            $laporanPerluValidasi = Laporan::where('status', 'selesai')
                ->latest('updated_at')
                ->take(10)
                ->get();
            // ===============================
            // DATA DONUT KATEGORI (NO NULL)
            // ===============================
            $kategoriStats = Laporan::whereNotNull('kategori')
                ->selectRaw('kategori, count(*) as total')
                ->groupBy('kategori')
                ->pluck('total', 'kategori')
                ->toArray();

            return view('admin.dashboard', compact(
                'totalLaporan',
                'laporanBaru',
                'laporanProses',
                'laporanSelesai',
                'butuhValidasi',
                'chartData',
                'teknisiStats',
                'laporanPerluValidasi',
                'kategoriStats',
            ));
        }

        // =========================================
        // 2. LOGIKA UNTUK TEKNISI
        // =========================================
        elseif ($user->role === 'teknisi') {

            $stats = [
                'total' => Laporan::where('teknisi_id', $userId)->count(),
                'pending_action' => Laporan::where('teknisi_id', $userId)
                    ->whereIn('status', ['proses', 'ditolak'])
                    ->count(),
                'completed' => Laporan::where('teknisi_id', $userId)
                    ->whereIn('status', ['selesai', 'closed'])
                    ->whereMonth('updated_at', now()->month)
                    ->count()
            ];

            $tasks = Laporan::where('teknisi_id', $userId)
                ->whereIn('status', ['proses', 'ditolak'])
                ->latest()
                ->get();

            // --- MULAI LOGIKA PENCARIAN & PAGINATION ---
            $query = Laporan::where('teknisi_id', $userId)
                ->whereIn('status', ['selesai', 'closed']);

            // Fungsi request() digunakan agar kita tidak perlu mengubah parameter fungsi utama
            if (request()->filled('search')) {
                $search = request()->search;
                $query->where(function ($q) use ($search) {
                    $q->where('tiket', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            // GANTI get() MENJADI paginate()
            $completedTasks = $query->latest('updated_at')->paginate(5);
            $completedTasks->appends(request()->query());
            // --- SELESAI LOGIKA PENCARIAN ---

            // PERHATIKAN: Pastikan nama view ini sesuai dengan file Blade Anda.
            // Jika file Blade Anda ada di folder teknisi, tulis 'teknisi.dashboard'
            // Jika di luar, biarkan 'dashboard'
            return view('dashboard', compact('stats', 'tasks', 'completedTasks'));
        }

        // Fallback untuk role lain
        return view('dashboard');
    }
}
