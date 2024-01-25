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
        Schema::create('resultado_jurado_proyecto', function (Blueprint $table) {
            $table->integer('cod_resultado')->autoIncrement();

            $table->integer('cod_designacion_proyecto');
            $table->foreign('cod_designacion_proyecto')
                ->references('cod_designacion_proyecto')
                ->on('designacion_jurado_proyecto')
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
        Schema::dropIfExists('resultado_jurado_proyecto');
    }
};
