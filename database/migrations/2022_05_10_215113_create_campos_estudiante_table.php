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
        Schema::connection('mysql')->create('campos_estudiante', function (Blueprint $table) {

            $$table->integer('cod_proyectotesis');
            $table->foreign('cod_proyectotesis')
                    ->references('cod_proyectotesis')
                    ->on('proyecto_tesis')
                    ->onDelete('cascade');

            $table->boolean('titulo')->default(1);
            $table->boolean('tipo_investigacion')->default(0);
            $table->boolean('localidad_institucion')->default(0);
            $table->boolean('duracion_proyecto')->default(0);
            $table->boolean('recursos')->default(0);
            $table->boolean('presupuesto')->default(0);
            $table->boolean('financiamiento')->default(0);
            $table->boolean('rp_antecedente_justificacion')->default(0);
            $table->boolean('formulacion_problema')->default(0);
            $table->boolean('objetivos')->default(0);
            $table->boolean('marcos')->default(0);
            $table->boolean('formulacion_hipotesis')->default(0);
            $table->boolean('diseño_investigacion')->default(0);
            $table->boolean('referencias_b')->default(0);

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('campos_estudiante');

    }
};
