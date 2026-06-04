<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop guru_mata_pelajaran table (penugasan system no longer needed)
        Schema::dropIfExists('guru_mata_pelajaran');

        // Remove columns from mata_pelajarans
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropIndex(['tingkat']);
            $table->dropColumn(['kelompok', 'tingkat']);
        });
    }

    public function down(): void
    {
        // Restore columns to mata_pelajarans
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->enum('kelompok', ['A', 'B', 'C'])->after('nama');
            $table->enum('tingkat', ['7', '8', '9', '10', '11', '12'])->nullable()->after('kelompok');
            $table->index('tingkat');
        });

        // Recreate guru_mata_pelajaran table
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus_rapor')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->string('tingkat', 10);
            $table->timestamps();
            $table->unique(['guru_id', 'mata_pelajaran_id', 'tingkat'], 'guru_mapel_tingkat_unique');
        });
    }
};
