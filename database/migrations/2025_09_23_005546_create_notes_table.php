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
        Schema::create('notes', function (Blueprint $table) {
            $table->id('id_note');
            $table->enum('category', ['Activity', 'Subproject']);
            $table->unsignedBigInteger('id_user');
            $table->string('activity_name');
            $table->text('description')->nullable();
            $table->float('hours_worked');
            $table->date('note_date');
            $table->string('media')->nullable();
            $table->unsignedBigInteger('id_subproject')->nullable();

            $table->timestamps();
            $table->foreign('id_user')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('id_subproject')->references('id_subproject')->on('subprojects')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
