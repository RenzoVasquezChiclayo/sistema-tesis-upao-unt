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
        Schema::table('tipoinvestigacion', function (Blueprint $table) {
            $table->integer('cod_semestre_academico');
            $table->foreign('cod_semestre_academico')
                    ->references('cod_configuraciones')
                    ->on('configuraciones_iniciales')
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
        //
    }
};
