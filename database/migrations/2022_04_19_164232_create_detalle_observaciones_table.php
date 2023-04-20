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
        Schema::connection('mysql')->create('detalle_observaciones', function (Blueprint $table) {
            $table->integer('cod_detalleObs')->autoIncrement();
            $table->integer('cod_observaciones');
            $table->foreign('cod_observaciones')
                    ->references('cod_observaciones')
                    ->on('observaciones_proy')
                    ->onDelete('cascade');
            $table->string('tema_referido',60);
            $table->text('correccion')->nullable();
            // $table->foreign('cod_historialObs')
            //         ->references('cod_historialObs')
            //         ->on('historial_observaciones')
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
        // Schema::connection('mysql')->dropIfExists('detalle_observaciones');

    }
};
