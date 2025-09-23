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
            $table->integer('id_subprojeto')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apontamentos', function (Blueprint $table) {
            DB::table('apontamentos')->whereNull('id_subprojeto')->update(['id_subprojeto' => 0]);
            $table->integer('id_subprojeto')->nullable(false)->change();
        });
    }
};
