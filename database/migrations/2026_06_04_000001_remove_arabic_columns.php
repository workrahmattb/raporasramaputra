<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas_rapor', function (Blueprint $table) {
            $table->dropColumn('nama_arabic');
        });

        Schema::table('gurus_rapor', function (Blueprint $table) {
            $table->dropColumn('nama_arabic');
        });

        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropColumn('namapelajaran_arabic');
        });
    }

    public function down(): void
    {
        Schema::table('siswas_rapor', function (Blueprint $table) {
            $table->string('nama_arabic')->nullable()->after('nama');
        });

        Schema::table('gurus_rapor', function (Blueprint $table) {
            $table->string('nama_arabic')->nullable()->after('nama');
        });

        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->string('namapelajaran_arabic')->nullable()->after('nama');
        });
    }
};
