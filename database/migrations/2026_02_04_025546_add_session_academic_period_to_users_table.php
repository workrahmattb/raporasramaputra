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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('session_tahun_ajaran_id')->nullable()->after('sekolah_id')->constrained('tahun_ajarans')->onDelete('set null');
            $table->foreignId('session_semester_id')->nullable()->after('session_tahun_ajaran_id')->constrained('semesters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['session_tahun_ajaran_id']);
            $table->dropForeign(['session_semester_id']);
            $table->dropColumn(['session_tahun_ajaran_id', 'session_semester_id']);
        });
    }
};
