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
        Schema::create('designacion_jurados', function (Blueprint $table) {
            $table->integer('cod_designacion_jurados')->autoIncrement();
            $table->integer('cod_tesis');
            $table->foreign('cod_tesis')
                ->references('cod_tesis')
                ->on('tesis_2022')
                ->onDelete('cascade');
            $table->char('cod_jurado1', 4);
            $table->foreign('cod_jurado1')
                ->references('cod_docente')
                ->on('asesor_curso')
                ->onDelete('cascade');
            $table->char('cod_jurado2', 4);
            $table->foreign('cod_jurado2')
                ->references('cod_docente')
                ->on('asesor_curso')
                ->onDelete('cascade');
            $table->char('cod_jurado3', 4);
            $table->foreign('cod_jurado3')
                ->references('cod_docente')
                ->on('asesor_curso')
                ->onDelete('cascade');
            $table->char('cod_jurado4', 4);
            $table->foreign('cod_jurado4')
                ->references('cod_docente')
                ->on('asesor_curso')
                ->onDelete('cascade');
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
        Schema::dropIfExists('designacion_jurados');
    }
};
