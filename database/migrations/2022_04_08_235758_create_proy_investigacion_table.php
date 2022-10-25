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
        Schema::create('proyinvestigacion', function (Blueprint $table) {
            $table->integer('cod_proyinvestigacion')->autoIncrement();

            $table->text('titulo')->nullable();

            $table->char('cod_matricula',10);
            $table->string('nombres',60);

            $table->string('direccion',70);
            $table->string('escuela',40);

            $table->string('nombre_asesor',80)->nullable();
            $table->string('grado_asesor',40)->nullable();
            $table->string('titulo_asesor',60)->nullable();
            $table->string('direccion_asesor',60)->nullable();

            $table->char('cod_tinvestigacion',4)->nullable();
            $table->string('ti_finpersigue',15)->nullable();
            $table->string('ti_disinvestigacion',15)->nullable();
            $table->string('localidad',30)->nullable();
            $table->string('institucion',30)->nullable();
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

            $table->date('fecha')->nullable();
            $table->tinyInteger('estado')->default(0); // 0: Tesis recien inicializada; 1: Tesis enviada para revision; 2: Tesis revisada por el asesor;
                                                       // 3: Tesis aprobada;            4: Tesis desaprobada;

            $table->text('estg_metodologicas')->nullable();

            $table->string('condicion',20)->nullable(); //APROBADO or DESAPROBADO
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_investigacion');
    }
};
