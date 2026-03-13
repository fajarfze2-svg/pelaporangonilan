<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // Menambahkan kolom Tiket (wajib unik biar bisa ditracking)
            $table->string('tiket')->unique();

            // Data Pelapor
            $table->string('nama');       // Sesuai error log
            $table->string('no_telepon'); // Sesuai error log

            // Detail Laporan (Ubah dari description/location ke deskripsi/lokasi)
            $table->text('deskripsi');
            $table->string('lokasi');

            // Status (Sesuaikan dengan value 'menunggu' dari controller)
            // Saya ubah jadi string agar fleksibel, atau bisa pakai enum bahasa indo
            $table->string('status')->default('menunggu');

            // Opsional: Foto bukti (biasanya perlu di laporan masyarakat)
            $table->string('bukti_foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
