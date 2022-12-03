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
        Schema::create('archivos_proy_tesis', function (Blueprint $table) {
            $table->integer('cod_archivos')->autoIncrement();
            $table->integer('cod_tesis');
            $table->foreign('cod_tesis')
                    ->references('cod_tesis')
                    ->on('tesis_2022')
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
        Schema::dropIfExists('archivos_proy_tesis');
    }
};
