<?php


use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;


return new class extends Migration

{

    public function up(): void

    {

        Schema::table('users', function (Blueprint $table) {

            $table->enum('type', ['Student', 'Coordinator'])->after('password')->default('Student');

            $table->string('RA')->after('type')->nullable()->unique();

            $table->string('course')->after('RA')->nullable();

            $table->integer('period')->after('course')->nullable();

            $table->string('address')->after('period')->nullable();

            $table->string('city')->after('address')->nullable();

            $table->string('telephone')->after('city')->nullable();

            $table->date('birth_date')->after('telephone')->nullable();

            $table->string('CPF')->after('birth_date')->nullable()->unique();

            $table->boolean('active')->after('CPF')->default(true);

            $table->string('position')->after('active')->nullable();

            $table->date('admission_date')->after('position')->nullable();

            $table->renameColumn('id', 'id_usuario');

        });

    }


    public function down(): void

    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'type', 'RA', 'course', 'period', 'address', 'city',
                'telephone', 'birth_date', 'CPF', 'active', 'position', 'admission_date'
            ]);
            $table->renameColumn('id_usuario', 'id');
        });

    }

};
