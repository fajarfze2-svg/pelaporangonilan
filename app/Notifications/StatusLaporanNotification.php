<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Laporan; // Pastikan import model Laporan

class StatusLaporanNotification extends Notification
{
    use Queueable;

    public $laporan;
    public $pesan;

    // Kita terima data laporan dan pesan custom dari Controller
    public function __construct(Laporan $laporan, $pesan)
    {
        $this->laporan = $laporan;
        $this->pesan = $pesan;
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan ke database saja
    }

    // Format data yang akan disimpan ke database
    public function toArray($notifiable)
    {
        return [
            'laporan_id' => $this->laporan->id,
            'tiket' => $this->laporan->tiket,
            'pesan' => $this->pesan, // Contoh: "Laporan Ditolak: Foto buram"
            'url' => route('teknisi.laporan.show', $this->laporan->id), // Link ke detail
            'waktu' => now(),
        ];
    }
}
