<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop foreign key pada kolom kelas_id (jika ada)
        $foreignKey = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'guru_mata_pelajaran' 
            AND COLUMN_NAME = 'kelas_id' AND REFERENCED_TABLE_NAME IS NOT NULL 
            LIMIT 1");
        
        if (!empty($foreignKey)) {
            $fkName = $foreignKey[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE guru_mata_pelajaran DROP FOREIGN KEY {$fkName}");
        }

        // 2. Drop index auto-generated dari FK pada kolom kelas_id (jika masih ada)
        $indexOnKelasId = DB::select("SELECT INDEX_NAME FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'guru_mata_pelajaran' 
            AND COLUMN_NAME = 'kelas_id' AND INDEX_NAME != 'PRIMARY' 
            LIMIT 1");
        
        if (!empty($indexOnKelasId)) {
            $idxName = $indexOnKelasId[0]->INDEX_NAME;
            DB::statement("ALTER TABLE guru_mata_pelajaran DROP INDEX {$idxName}");
        }

        // 3. Drop unique key guru_mapel_kelas_unique (jika ada)
        $uniqueKey = DB::select("SELECT INDEX_NAME FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'guru_mata_pelajaran' 
            AND INDEX_NAME = 'guru_mapel_kelas_unique' 
            LIMIT 1");
        
        if (!empty($uniqueKey)) {
            DB::statement('ALTER TABLE guru_mata_pelajaran DROP INDEX guru_mapel_kelas_unique');
        }

        // 4. Ubah kolom kelas_id menjadi tingkat (VARCHAR) untuk menyimpan romawi (VII, VIII, dll)
        DB::statement('ALTER TABLE guru_mata_pelajaran CHANGE COLUMN kelas_id tingkat VARCHAR(10) NOT NULL');

        // 5. Tambah unique constraint baru dengan tingkat
        DB::statement('ALTER TABLE guru_mata_pelajaran ADD UNIQUE KEY guru_mapel_tingkat_unique (guru_id, mata_pelajaran_id, tingkat)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Hapus unique constraint baru (jika ada)
        $newUniqueKey = DB::select("SELECT INDEX_NAME FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'guru_mata_pelajaran' 
            AND INDEX_NAME = 'guru_mapel_tingkat_unique' 
            LIMIT 1");

        if (!empty($newUniqueKey)) {
            DB::statement('ALTER TABLE guru_mata_pelajaran DROP INDEX guru_mapel_tingkat_unique');
        }

        // 2. Kembalikan tingkat ke kelas_id
        DB::statement('ALTER TABLE guru_mata_pelajaran CHANGE COLUMN tingkat kelas_id BIGINT UNSIGNED NOT NULL');

        // 3. Kembalikan foreign key ke kelas_rapor
        DB::statement('ALTER TABLE guru_mata_pelajaran ADD CONSTRAINT guru_mata_pelajaran_kelas_id_foreign FOREIGN KEY (kelas_id) REFERENCES kelas_rapor (id) ON DELETE CASCADE');

        // 4. Kembalikan unique constraint lama
        DB::statement('ALTER TABLE guru_mata_pelajaran ADD UNIQUE KEY guru_mapel_kelas_unique (guru_id, mata_pelajaran_id, kelas_id)');
    }
};
