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
        Schema::table('kelas_rapor', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['wali_kelas_id']);
            
            // Add new foreign key constraint to gurus_rapor table
            $table->foreign('wali_kelas_id')
                ->references('id')
                ->on('gurus_rapor')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_rapor', function (Blueprint $table) {
            // Drop foreign key to gurus_rapor
            $table->dropForeign(['wali_kelas_id']);
            
            // Restore foreign key to users table
            $table->foreign('wali_kelas_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }
};
