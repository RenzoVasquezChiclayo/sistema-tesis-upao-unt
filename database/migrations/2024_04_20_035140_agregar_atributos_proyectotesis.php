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
        Schema::table('proyecto_tesis', function (Blueprint $table) {
            $table->string('unidad_academica',50)->nullable()->after('ti_disinvestigacion');
            $table->date('fecha_inicio')->nullable()->after('institucion');
            $table->date('fecha_termino')->nullable()->after('fecha_inicio');
            $table->text('diseño_contrastacion')->nullable()->after('metodos');
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
