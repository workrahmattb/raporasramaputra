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
        Schema::table('siswas_rapor', function (Blueprint $table) {
            // Drop unique constraint first
            $table->dropUnique('siswas_rapor_nis_unique');
            
            // Make nis nullable
            $table->string('nis')->nullable()->change();
            
            // Add unique constraint back but allowing nulls
            $table->unique('nis', 'siswas_rapor_nis_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas_rapor', function (Blueprint $table) {
            // Drop unique constraint
            $table->dropUnique('siswas_rapor_nis_unique');
            
            // Make nis not nullable again
            $table->string('nis')->nullable(false)->change();
            
            // Add unique constraint back
            $table->unique('nis', 'siswas_rapor_nis_unique');
        });
    }
};
