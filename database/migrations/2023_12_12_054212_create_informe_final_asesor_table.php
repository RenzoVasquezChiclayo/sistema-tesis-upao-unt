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
        Schema::create('informe_final_asesor', function (Blueprint $table) {
            $table->integer('cod_informe_final')->autoIncrement();
            $table->string('introduccion');
            $table->string('aporte_investigacion');
            $table->string('metodologia_empleada');
            $table->integer('cod_tesis');
            $table->foreign('cod_tesis')
                ->references('cod_tesis')
                ->on('tesis_2022')
                ->onDelete('cascade');
            $table->string('fecha_informe');
            $table->char('cod_asesor',4);
            $table->foreign('cod_asesor')
                    ->references('cod_docente')
                    ->on('asesor_curso')
                    ->onDelete('cascade');
            $table->tinyInteger('estado')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informe_final_asesor');
    }
};
