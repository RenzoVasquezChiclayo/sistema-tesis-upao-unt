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
        Schema::create('fin_persigue', function (Blueprint $table) {
            $table->integer('cod_fin_persigue')->autoIncrement();
            $table->string('descripcion',50);
            $table->char('cod_escuela',4);
            $table->foreign('cod_escuela')
                    ->references('cod_escuela')
                    ->on('escuela')
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
        // Schema::dropIfExists('fin_persigue');
    }
};
