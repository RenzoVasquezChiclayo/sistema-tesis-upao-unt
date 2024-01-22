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
        Schema::create('detalle_obs_sustentacion', function (Blueprint $table) {
            $table->integer('cod_detalleObs')->autoIncrement();
            $table->integer('id_observacion');
            $table->foreign('id_observacion')
                    ->references('id_observacion')
                    ->on('observacion_sustentacion')
                    ->onDelete('cascade');
            $table->string('tema_referido',60);
            $table->text('correccion')->nullable();
            $table->tinyInteger('estado')->default(0);
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
        Schema::dropIfExists('detalle_obs_sustentacion');
    }
};
