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
        Schema::create('asesor_semestre', function (Blueprint $table) {
            $table->integer('cod_asesor_semestre')->autoIncrement();
            $table->char('cod_docente',4);
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor_curso')
                    ->onDelete('cascade');
            $table->integer('cod_config_ini');
            $table->foreign('cod_config_ini')
                    ->references('cod_config_ini')
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
        Schema::dropIfExists('asesor_semestre');
    }
};
