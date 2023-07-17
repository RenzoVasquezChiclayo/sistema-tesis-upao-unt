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
        Schema::create('detalle_grupo_investigacion', function (Blueprint $table) {
            $table->integer("id_detalle_grupo")->autoIncrement();

            $table->integer("id_grupo_inves"); //Vincular con el grupo de investigacion
            $table->foreign("id_grupo_inves")
                ->references("id_grupo")
                ->on("grupo_investigacion")
                ->onDelete('cascade');

            $table->char('cod_matricula',10); //Vincular con estudiante
            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('estudiante_ct2022')
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
        Schema::dropIfExists('detalle_grupo_investigacion');
    }
};
