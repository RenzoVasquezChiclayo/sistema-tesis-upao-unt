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
        Schema::create('formato_titulo', function (Blueprint $table) {
            $table->integer('codigo')->autoIncrement();
            $table->char('cod_formato',4);

            $table->char('cod_matricula',10);
            $table->string('tit_profesional',60);
            $table->date('fecha_nacimiento');
            $table->string('direccion',70);
            $table->char('tele_fijo',8)->nullable();
            $table->string('tele_celular',12);
            $table->string('correo',50);
            $table->string('modalidad_titulo',30);
            $table->string('sgda_especialidad',50)->nullable();
            $table->string('prog_extraordinario',50)->nullable();
            $table->date('fecha_sustentacion')->nullable();
            $table->date('fecha_colacion')->nullable();
            $table->string('centro_labores',25)->nullable();
            $table->string('colegio',50);
            $table->string('tipo_colegio',15);
            $table->char('cod_escuela',4);
            $table->char('cod_sede',2);
            $table->tinyInteger('estado');
            $table->date('fecha');

            $table->string('firmaIMG',40);

            $table->char('cod_tinvestigacion',4);
            $table->char('cod_docente',4)->nullable();



            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('egresado')
                    ->onDelete('cascade');
            $table->foreign('cod_escuela')
                    ->references('cod_escuela')
                    ->on('escuela')
                    ->onDelete('cascade');
            $table->foreign('cod_sede')
                    ->references('cod_sede')
                    ->on('sede')
                    ->onDelete('cascade');
            $table->foreign('cod_tinvestigacion')
                    ->references('cod_tinvestigacion')
                    ->on('tipoinvestigacion')
                    ->onDelete('cascade');
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor')
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
        Schema::dropIfExists('formato_titulo');
    }
};
