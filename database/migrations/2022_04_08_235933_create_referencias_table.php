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
        Schema::connection('mysql')->create('referencias', function (Blueprint $table) {
            $table->integer('cod_referencias')->autoIncrement();
            $table->integer('cod_tiporeferencia');
            $table->foreign('cod_tiporeferencia')
                    ->references('cod_tiporeferencia')
                    ->on('tiporeferencia')
                    ->onDelete('cascade');


            $table->text('autor')->nullable();
            $table->string('fPublicacion',30)->nullable();
            $table->string('titulo',60)->nullable();
            $table->string('fuente',60)->nullable();

            $table->string('editorial',25)->nullable();
            $table->string('title_cap',25)->nullable();
            $table->string('num_capitulo',20)->nullable();

            $table->string('title_revista',25)->nullable();
            $table->string('volumen',20)->nullable();

            $table->string('name_web',25)->nullable();

            $table->string('name_periodista',25)->nullable();

            $table->string('name_institucion',25)->nullable();

            $table->string('subtitle',25)->nullable();
            $table->string('name_editor',25)->nullable();
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
        // Schema::connection('mysql')->dropIfExists('referencias');

    }
};
