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
        Schema::connection('mysql')->create('objetivo', function (Blueprint $table) {
            $table->integer('cod_objetivo')->autoIncrement();
            $table->string('tipo',25);
            $table->text('descripcion');
            $table->integer('cod_proyectotesis');
            $table->foreign('cod_proyectotesis')
                    ->references('cod_proyectotesis')
                    ->on('proyecto_tesis')
                    ->onDelete('cascade');


            // $table->foreign('cod_proyinvestigacion')
            //         ->references('cod_proyinvestigacion')
            //         ->on('proyinvestigacion')
            //         ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('objetivo');

    }
};
