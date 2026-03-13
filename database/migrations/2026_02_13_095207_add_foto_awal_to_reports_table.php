<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Cek jika kolom foto_awal BELUM ada, baru buat
            if (!Schema::hasColumn('reports', 'foto_awal')) {
                $table->string('foto_awal')->nullable()->after('lokasi');
            }

            // Cek jika kolom foto_selesai BELUM ada, baru buat
            if (!Schema::hasColumn('reports', 'foto_selesai')) {
                $table->string('foto_selesai')->nullable()->after('foto_awal');
            }
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['foto_awal', 'foto_selesai']);
        });
    }
};
