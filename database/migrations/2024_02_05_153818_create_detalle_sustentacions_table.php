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
        Schema::create('detalle_sustentacion', function (Blueprint $table) {
            $table->integer("cod")->autoIncrement();
            $table->integer("cod_sustentacion");
            $table->foreign('cod_sustentacion')
                ->references('cod')
                ->on('sustentacion')
                ->onDelete('cascade');
            $table->integer("cod_jurado");
            $table->foreign('cod_jurado')
                ->references('cod_jurado')
                ->on('jurado')
                ->onDelete('cascade');
            $table->string("pos_jurado", 50)->nullable();
            $table->integer("nota")->nullable();
            $table->text("comentario")->nullable();
            $table->tinyInteger("estado")->default(0);
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
        Schema::dropIfExists('detalle_sustentacions');
    }
};
