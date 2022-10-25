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
        Schema::create('t_historial_observaciones', function (Blueprint $table) {
            $table->integer('cod_historial_observacion')->autoIncrement();
            $table->integer('cod_Tesis');
            $table->date('fecha')->nullable();
            $table->tinyInteger('estado')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_historial_observaciones');
    }
};
