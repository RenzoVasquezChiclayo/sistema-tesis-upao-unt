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
        Schema::create('t_detalle_observacion', function (Blueprint $table) {
            $table->integer('id_detalle_observacion')->autoIncrement();
            $table->integer('id_observacion')->nullable(false);
            $table->foreign('id_observacion')
            ->references('id_observacion')
            ->on('t_observacion')
            ->onDelete('cascade');
            $table->string('tema_referido',80)->nullable(false);
            $table->text('correccion')->nullable();
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
        // Schema::dropIfExists('t_detalle_observacion');
    }
};
