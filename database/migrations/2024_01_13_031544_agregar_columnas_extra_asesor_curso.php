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
        Schema::table('asesor_curso', function (Blueprint $table) {
            //Drop the oldest columns
            $table->dropColumn('grado_academico');
            $table->dropColumn('titulo_profesional');

            //New columns
            $table->integer('cod_grado_academico')->nullable()->after('orcid');
            $table->foreign('cod_grado_academico')
                    ->references('cod_grado_academico')
                    ->on('grado_academico')
                    ->onDelete('cascade');
            $table->integer('cod_categoria')->nullable()->after('cod_grado_academico');
            $table->foreign('cod_categoria')
                    ->references('cod_categoria')
                    ->on('categoria_docente')
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
