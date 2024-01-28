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
        Schema::create('detalle_archivos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('cod_archivos');
            $table->foreign('cod_archivos')
                    ->references('cod_archivos')
                    ->on('archivos_proy_tesis')
                    ->onDelete('cascade');
            $table->string('tipo')->nullable();
            $table->integer('grupo')->nullable();
            $table->integer('orden')->nullable();
            $table->string('ruta')->nullable();
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
        // Schema::dropIfExists('detalle_archivos');
    }
};
