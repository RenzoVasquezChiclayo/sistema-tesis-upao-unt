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
        Schema::create('cronograma', function (Blueprint $table) {
            $table->integer('cod_cronograma')->autoIncrement();
            $table->string('actividad',50);
            $table->char('cod_escuela',4);
            $table->foreign('cod_escuela')
                    ->references('cod_escuela')
                    ->on('escuela')
                    ->onDelete('cascade');
            $table->integer('cod_config_ini');
            $table->foreign('cod_config_ini')
                    ->references('cod_config_ini')
                    ->on('configuraciones_iniciales')
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
        Schema::dropIfExists('cronograma');
    }
};
