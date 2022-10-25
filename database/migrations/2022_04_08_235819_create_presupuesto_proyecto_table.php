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
        Schema::connection('mysql')->create('presupuesto_proyecto', function (Blueprint $table) {
            $table->integer('cod_presProyecto')->autoIncrement();
            $table->float('precio');
            $table->integer('cod_presupuesto');
            $table->integer('cod_proyinvestigacion');

            $table->foreign('cod_presupuesto')
                    ->references('cod_presupuesto')
                    ->on('presupuesto')
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
        Schema::connection('mysql')->dropIfExists('presupuesto_proyecto');

    }
};
