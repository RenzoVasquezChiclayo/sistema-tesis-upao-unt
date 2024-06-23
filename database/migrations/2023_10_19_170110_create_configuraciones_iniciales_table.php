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
        Schema::create('configuraciones_iniciales', function (Blueprint $table) {
            $table->integer('cod_config_ini')->autoIncrement();
            $table->char('year',4);
            $table->string('curso',60);
            $table->integer('ciclo');
            $table->tinyInteger('estado')->default('1');
            $table->string('codigo',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuraciones_iniciales');
    }
};
