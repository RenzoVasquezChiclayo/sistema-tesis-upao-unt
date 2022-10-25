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
        Schema::create('matriz_operacional', function (Blueprint $table) {
            $table->integer('cod_matriz_ope')->autoIncrement();
            $table->integer('cod_tesis');
            $table->text('variable_I')->nullable();
            $table->text('def_conceptual_I')->nullable();
            $table->text('def_operacional_I')->nullable();
            $table->text('dimensiones_I')->nullable();
            $table->text('indicadores_I')->nullable();
            $table->text('escala_I')->nullable();

            $table->text('variable_D')->nullable();
            $table->text('def_conceptual_D')->nullable();
            $table->text('def_operacional_D')->nullable();
            $table->text('dimensiones_D')->nullable();
            $table->text('indicadores_D')->nullable();
            $table->text('escala_D')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriz_operacional');
    }
};
