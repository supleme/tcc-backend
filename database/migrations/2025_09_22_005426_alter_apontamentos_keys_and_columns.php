<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Adicione esta linha

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apontamentos', function (Blueprint $table) {
        });

        if (Schema::hasColumn('apontamentos', 'id_aluno')) {
            Schema::table('apontamentos', function (Blueprint $table) {
                $table->renameColumn('id_aluno', 'id_usuario');
            });
        }
        Schema::table('apontamentos', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('apontamentos', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->renameColumn('id_usuario', 'id_aluno');
        });
    }
};
