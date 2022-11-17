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
        //
        Schema::create('tesis_2022', function (Blueprint $table) {
            $table->integer('cod_tesis')->autoIncrement();
            $table->text('titulo')->nullable();

            $table->char('cod_matricula',10);
            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('estudiante_ct2022')
                    ->onDelete('cascade');
            $table->char('cod_docente',4)->nullable();
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor_curso')
                    ->onDelete('cascade');

            $table->text('presentacion')->nullable();
            $table->text('resumen')->nullable();
            $table->text('introduccion')->nullable();
            $table->text('dedicatoria')->nullable();
            $table->text('agradecimiento')->nullable();

            $table->text('real_problematica')->nullable();
            $table->text('antecedentes')->nullable();
            $table->text('justificacion')->nullable();
            $table->text('formulacion_prob')->nullable();

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
            $table->text('anexos')->nullable();

            $table->date('fecha_create')->nullable();
            $table->date('fecha_update')->nullable();
            $table->tinyInteger('estado')->default('0');

            $table->string('condicion',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('tesis_2022');
    }
};
