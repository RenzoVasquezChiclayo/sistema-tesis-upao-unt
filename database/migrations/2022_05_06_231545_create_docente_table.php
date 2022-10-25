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
        Schema::create('docente', function (Blueprint $table) {
            $table->char('cod_docente',4)->primary();
            $table->string('dni',8)->nullable();
            $table->string('nombres',50)->nullable();
            $table->string('celular',9)->nullable();
            $table->string('correo',50)->nullable();
            $table->string('direccion',30)->nullable();
            $table->string('grado_academico',30)->nullable();
            $table->string('titulo_profesional',30)->nullable();
            $table->char('cod_escuela',4)->nullable();

            $table->foreign('cod_escuela')
                    ->references('cod_escuela')
                    ->on('escuela');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docente');
    }
};
