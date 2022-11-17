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
        Schema::create('t_keyword', function (Blueprint $table) {
            $table->integer('id_keyword')->autoIncrement();
            $table->integer('cod_tesis')->nullable(false);
            $table->foreign('cod_tesis')
                    ->references('cod_tesis')
                    ->on('tesis_2022')
                    ->onDelete('cascade');
            $table->date('fecha_update')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_keyword');
    }
};
