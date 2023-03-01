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
        Schema::connection('mysql')->create('observaciones_proy', function (Blueprint $table) {
            $table->integer('cod_observaciones')->autoIncrement();

            $table->integer('cod_historialObs');
            $table->foreign('cod_historialObs')
                    ->references('cod_historialObs')
                    ->on('historial_observaciones')
                    ->onDelete('cascade');

            $table->string('observacionNum',20);

            $table->date('fecha')->nullable();

            $table->text('titulo')->nullable();

            $table->text('linea_investigacion')->nullable();
            $table->text('localidad_institucion')->nullable();
            $table->text('meses_ejecucion')->nullable();

            $table->text('recursos')->nullable();

            $table->text('real_problematica')->nullable();
            $table->text('antecedentes')->nullable();
            $table->text('justificacion')->nullable();
            $table->text('formulacion_prob')->nullable();

            $table->text('objetivos')->nullable();

            $table->text('marco_teorico')->nullable();
            $table->text('marco_conceptual')->nullable();
            $table->text('marco_legal')->nullable();
            $table->text('form_hipotesis')->nullable();

            $table->text('objeto_estudio')->nullable();
            $table->text('poblacion')->nullable();
            $table->text('muestra')->nullable();
            $table->text('metodos')->nullable();

            $table->text('tecnicas_instrum')->nullable();
            $table->text('instrumentacion')->nullable();
            $table->text('estg_metodologicas')->nullable();
            $table->tinyInteger('estado');
            $table->text('variables')->nullable();

            $table->text('referencias')->nullable();
            $table->text('matriz_op')->nullable();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('observaciones_proy');

    }
};
