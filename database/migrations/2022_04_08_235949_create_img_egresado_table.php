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
        Schema::create('img_egresado', function (Blueprint $table) {
            $table->integer('cod_img')->autoIncrement();
            $table->string('referencia',40);
            $table->char('cod_matricula',10);


            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('egresado')
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
        Schema::dropIfExists('img_egresado');
    }
};
