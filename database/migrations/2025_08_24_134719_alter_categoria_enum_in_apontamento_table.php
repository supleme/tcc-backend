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
        Schema::table('apontamentos', function (Blueprint $table) {
            //
        });
        DB::statement("ALTER TABLE apontamentos MODIFY categoria ENUM('Atividade', 'Subprojeto') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apontamentos', function (Blueprint $table) {
            //
        });
        DB::statement("ALTER TABLE apontamentos MODIFY categoria INT NOT NULL");
    }
};
