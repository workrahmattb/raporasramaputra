<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rapor_settings', function (Blueprint $table) {
            $table->renameColumn('kepala_sekolah_mts', 'kepala_pengasuhan_asrama');
            $table->renameColumn('kepala_sekolah_ma', 'pimpinan_pondok');
        });
    }

    public function down(): void
    {
        Schema::table('rapor_settings', function (Blueprint $table) {
            $table->renameColumn('kepala_pengasuhan_asrama', 'kepala_sekolah_mts');
            $table->renameColumn('pimpinan_pondok', 'kepala_sekolah_ma');
        });
    }
};
