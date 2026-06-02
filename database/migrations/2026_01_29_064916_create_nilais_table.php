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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas_rapor')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas_rapor')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus_rapor')->onDelete('cascade');
            $table->integer('nilai_pengetahuan'); // 0-100
            $table->text('deskripsi_pengetahuan');
            $table->integer('nilai_keterampilan'); // 0-100
            $table->text('deskripsi_keterampilan');
            $table->timestamps();
            
            $table->index(['siswa_id', 'semester_id']);
            $table->unique(['siswa_id', 'mata_pelajaran_id', 'semester_id'], 'siswa_mapel_semester_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
