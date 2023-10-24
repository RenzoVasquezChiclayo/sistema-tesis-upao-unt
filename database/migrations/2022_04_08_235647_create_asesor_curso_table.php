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
        Schema::create('asesor_curso', function (Blueprint $table) {
            $table->char('cod_docente',4)->primary();
            $table->string('nombres',50);
            $table->string('apellidos',50);
            $table->string('grado_academico',30);
            $table->string('titulo_profesional',30);
            $table->string('direccion',45);
            //Con finalidad del CURSO TESIS 2022
            $table->string('username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('asesor_curso');
    }
};
