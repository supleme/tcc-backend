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
        Schema::create('responsible_subproject', function (Blueprint $table) {
            $table->unsignedBigInteger('subproject_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['subproject_id', 'user_id']);

            $table->foreign('subproject_id')->references('id_subproject')->on('subprojects')->onDelete('cascade');
            $table->foreign('user_id')->references('id_usuario')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsible_subproject');
    }
};
