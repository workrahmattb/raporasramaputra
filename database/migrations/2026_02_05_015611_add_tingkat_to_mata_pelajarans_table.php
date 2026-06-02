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
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->enum('tingkat', ['7', '8', '9', '10', '11', '12'])->nullable()->after('kelompok');
            $table->index('tingkat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropIndex(['tingkat']);
            $table->dropColumn('tingkat');
        });
    }
};
