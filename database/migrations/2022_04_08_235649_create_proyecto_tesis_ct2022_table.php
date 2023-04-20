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

        Schema::connection('mysql')->create('proyecto_tesis', function (Blueprint $table) {
            $table->integer('cod_proyectotesis')->autoIncrement(); //Modificacion de nombre de tabla y codigo

            $table->text('titulo')->nullable();

            $table->char('cod_matricula',10); //Vincular con estudiante
            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('estudiante_ct2022')
                    ->onDelete('cascade');

            /*Agregado*/
            $table->char('cod_docente',4)->nullable();
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor_curso')
                    ->onDelete('cascade');

            $table->char('cod_tinvestigacion',4)->nullable(); //Vinculo con tabla tipoinvestigacion
            $table->foreign('cod_tinvestigacion')
                    ->references('cod_tinvestigacion')
                    ->on('tipoinvestigacion')
                    ->onDelete('cascade');
            $table->string('ti_finpersigue',15)->nullable();
            $table->string('ti_disinvestigacion',15)->nullable();
            $table->string('localidad',40)->nullable();
            $table->string('institucion',50)->nullable();
            $table->integer('meses_ejecucion')->nullable();

            $table->string('t_ReparacionInstrum',30)->nullable();
            $table->string('t_RecoleccionDatos',30)->nullable();
            $table->string('t_AnalisisDatos',30)->nullable();
            $table->string('t_ElaboracionInfo',30)->nullable();

            $table->text('financiamiento')->nullable();

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
            $table->date('fecha')->nullable();
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
        // Schema::dropIfExists('tesis_ct2022');
    }
};
