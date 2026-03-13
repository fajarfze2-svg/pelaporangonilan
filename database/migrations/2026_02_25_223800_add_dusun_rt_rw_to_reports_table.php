<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('dusun')->nullable()->after('lokasi');
            $table->string('rt', 5)->nullable()->after('dusun');
            $table->string('rw', 5)->nullable()->after('rt');
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['dusun', 'rt', 'rw']);
        });
    }
};
