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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id('id_aluno');
            $table->string('RA')->unique();
            $table->string('nome');
            $table->string('curso');
            $table->string('periodo');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('telefone');
            $table->string('email');
            $table->date('data_nascimento');
            $table->string('CPF');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
