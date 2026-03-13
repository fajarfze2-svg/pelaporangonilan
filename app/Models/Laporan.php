<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $guarded = ['id'];

    // Pastikan fillable sesuai dengan kolom di database Anda
    protected $fillable = [
        'nama',
        'no_telepon',
        'lokasi',
        'status',
        'prioritas',
        'teknisi_id',
        'pelapor_id',
        'bukti_foto',
        'catatan_teknisi',
        'catatan_admin',
        'foto_awal',
        'deskripsi',
        'tiket',
        'latitude',
        'longitude',
        'kategori',
        'dusun',  
        'rt',
        'rw',
    ];

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
}
