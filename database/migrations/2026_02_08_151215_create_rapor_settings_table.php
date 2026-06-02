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
        Schema::create('rapor_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_rapor')->nullable();
            $table->string('kepala_sekolah_mts')->nullable();
            $table->string('kepala_sekolah_ma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor_settings');
    }
};
