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
        Schema::create('kelas_rapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama'); // VII A, VIII B, etc
            $table->enum('tingkat', ['VII', 'VIII', 'IX', 'X', 'XI', 'XII']);
            $table->string('ruangan')->nullable();
            $table->integer('kapasitas')->default(30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_rapor');
    }
};
