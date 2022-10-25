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
        Schema::connection('mysql')->create('historial_observaciones', function (Blueprint $table) {
            $table->integer('cod_historialObs')->autoIncrement();
            $table->integer('cod_proyinvestigacion');
            $table->date('fecha')->nullable();
            $table->tinyInteger('estado')->default(0);
            // $table->string('observacionNum',20)->nullable();
            // $table->foreign('cod_proyinvestigacion')
            //         ->references('cod_proyinvestigacion')
            //         ->on('proyinvestigacion')
            //         ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('historial_observaciones');

    }
};
