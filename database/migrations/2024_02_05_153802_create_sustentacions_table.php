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
        Schema::create('sustentacion', function (Blueprint $table) {
            $table->integer("cod")->autoIncrement();
            $table->integer("cod_tesis");
            $table->foreign('cod_tesis')
                ->references('cod_tesis')
                ->on('tesis_2022')
                ->onDelete('cascade');
            $table->text("modalidad")->nullable();
            $table->text("comentario")->nullable();
            $table->dateTime("fecha_stt");
            $table->tinyInteger("estado")->default(0);
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
        Schema::dropIfExists('sustentacions');
    }
};
