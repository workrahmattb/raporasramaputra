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
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_pengetahuan', 'deskripsi_keterampilan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->text('deskripsi_pengetahuan')->nullable()->after('nilai_pengetahuan');
            $table->text('deskripsi_keterampilan')->nullable()->after('nilai_keterampilan');
        });
    }
};
