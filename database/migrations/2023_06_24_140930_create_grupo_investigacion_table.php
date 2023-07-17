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
        Schema::create('grupo_investigacion', function (Blueprint $table) {
            $table->integer("id_grupo")->autoIncrement();
            $table->char("num_grupo",10);
            $table->char('cod_docente',4)->nullable(); //Vincular con el asesor
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor_curso')
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
        Schema::dropIfExists('grupo_investigacion');
    }
};
