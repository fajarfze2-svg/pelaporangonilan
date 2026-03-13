<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Laporan;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'must_change_password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke tabel laporans
    public function reports()
    {
        return $this->hasMany(Laporan::class, 'teknisi_id');
    }
}
