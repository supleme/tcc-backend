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
        Schema::create('apontamentos', function (Blueprint $table) {
        $table->id('id_apontamento');
        $table->integer('categoria');
        $table->unsignedBigInteger('id_aluno');
        $table->date('data_apontamento');
        $table->float('horas_trabalhadas');
        $table->string('midia')->nullable();;
        $table->unsignedBigInteger('id_subprojeto');
        $table->text('descricao')->nullable(); // pode ser nulo
        $table->date('data_criacao');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apontamento');
    }
};
