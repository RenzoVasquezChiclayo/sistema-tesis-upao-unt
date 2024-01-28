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
        Schema::create('resultado_jurado_tesis', function (Blueprint $table) {
            $table->integer('cod_resultado')->autoIncrement();

            $table->integer('cod_designacion_jurados');
            $table->foreign('cod_designacion_jurados')
                ->references('cod_designacion_jurados')
                ->on('designacion_jurados')
                ->onDelete('cascade');
            $table->integer('cod_jurado');
            $table->foreign('cod_jurado')
                ->references('cod_jurado')
                ->on('jurado')
                ->onDelete('cascade');
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
        Schema::dropIfExists('resultado_jurado_tesis');
    }
};
