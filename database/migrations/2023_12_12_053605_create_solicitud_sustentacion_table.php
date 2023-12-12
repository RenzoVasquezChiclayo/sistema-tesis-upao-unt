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
        Schema::create('solicitud_sustentacion', function (Blueprint $table) {
            $table->integer('cod_solicitud_sustentacion')->autoIncrement();
            $table->string('razon_solicitud');
            $table->string('fecha_solicitud');
            $table->integer('cod_tesis');
            $table->foreign('cod_tesis')
                ->references('cod_tesis')
                ->on('tesis_2022')
                ->onDelete('cascade');
            $table->string('voucher');
            $table->tinyInteger('estado')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_sustentacion');
    }
};
