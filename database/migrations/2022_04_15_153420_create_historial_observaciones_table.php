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
            $table->integer('cod_proyectotesis');
            $table->foreign('cod_proyectotesis')
                    ->references('cod_proyectotesis')
                    ->on('proyecto_tesis')
                    ->onDelete('cascade');
            $table->boolean('sustentacion')->default(false);
            $table->date('fecha')->nullable();
            $table->tinyInteger('estado')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::connection('mysql')->dropIfExists('historial_observaciones');

    }
};
