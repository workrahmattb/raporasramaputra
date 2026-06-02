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
        Schema::create('siswas_rapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('nisn')->unique();
            $table->string('nis')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('telepon_ortu')->nullable();
            $table->date('tanggal_masuk');
            $table->enum('status', ['Aktif', 'Lulus', 'Pindah', 'Keluar'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('nisn');
            $table->index('nis');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas_rapor');
    }
};
