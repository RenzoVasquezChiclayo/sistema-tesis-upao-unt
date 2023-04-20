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
        Schema::create('t_objetivo', function (Blueprint $table) {
            $table->integer('cod_objetivo')->autoIncrement();
            $table->string('tipo',25);
            $table->text('descripcion');
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
        // Schema::dropIfExists('t_objetivo');
    }
};
