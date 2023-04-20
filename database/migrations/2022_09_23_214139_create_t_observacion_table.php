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
        Schema::create('t_observacion', function (Blueprint $table) {
            $table->integer('id_observacion')->autoIncrement();
            $table->integer('cod_historial_observacion');
            $table->foreign('cod_historial_observacion')
                    ->references('cod_historial_observacion')
                    ->on('t_historial_observaciones')
                    ->onDelete('cascade');
            $table->text('presentacion')->nullable();
            $table->text('resumen')->nullable();
            $table->text('keyword')->nullable();
            $table->text('introduccion')->nullable();

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

            $table->text('discusion')->nullable();
            $table->text('conclusiones')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->text('resultados')->nullable();

            $table->text('referencias')->nullable();

            $table->tinyInteger('estado')->default('0');
            $table->date('fecha_create')->nullable();
            $table->date('fecha_update')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('t_observacion');
    }
};
