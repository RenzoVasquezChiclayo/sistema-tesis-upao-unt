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
        Schema::create('cronograma_proyecto', function (Blueprint $table) {
            $table->integer('cod_cronoProyecto')->autoIncrement();
            $table->string('descripcion',15);
            $table->integer('cod_cronograma');
            $table->foreign('cod_cronograma')
                    ->references('cod_cronograma')
                    ->on('cronograma')
                    ->onDelete('cascade');

            $table->integer('cod_proyectotesis');
            $table->foreign('cod_proyectotesis')
                    ->references('cod_proyectotesis')
                    ->on('proyecto_tesis')
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
        Schema::dropIfExists('cronograma_proyecto');
    }
};
