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
        Schema::table('apontamentos', function (Blueprint $table) {
            $table->string('tarefa')->nullable()->after('descricao');
            $table->string('atividade')->nullable()->after('tarefa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apontamentos', function (Blueprint $table) {
            //
        });
    }
};
