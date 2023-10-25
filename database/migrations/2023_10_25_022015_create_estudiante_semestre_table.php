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
        Schema::create('estudiante_semestre', function (Blueprint $table) {
            $table->integer('cod_estudiante_semestre')->autoIncrement();
            $table->char('cod_matricula',10);
            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('estudiante_ct2022')
                    ->onDelete('cascade');
            $table->integer('cod_configuraciones');
            $table->foreign('cod_configuraciones')
                    ->references('cod_configuraciones')
                    ->on('configuraciones_iniciales')
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
        Schema::dropIfExists('estudiante_semestre');
    }
};
