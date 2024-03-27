<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('director', function (Blueprint $table) {
            $table->integer('cod_director')->autoIncrement();
            $table->string('nombres',50);
            $table->string('apellidos',50);
            $table->integer('cod_grado_academico');
            $table->char('cod_escuela',4);
            $table->string('direccion',45)->nullable();
            $table->string('correo',80)->nullable();
            $table->string('username')->nullable();
            $table->tinyInteger('estado')->default('1');
            $table->timestamps();

            $table->foreign('cod_grado_academico')
                ->references('cod_grado_academico')
                ->on('grado_academico')
                ->onDelete('cascade');
            $table->foreign('cod_escuela')
                ->references('cod_escuela')
                ->on('escuela')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('director');
    }
};
