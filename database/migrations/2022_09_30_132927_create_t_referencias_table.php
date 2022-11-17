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
        Schema::create('t_referencias', function (Blueprint $table) {
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

            $table->string('editorial',60)->nullable();
            $table->string('title_cap',60)->nullable();
            $table->string('num_capitulo',25)->nullable();

            $table->string('title_revista',60)->nullable();
            $table->string('volumen',25)->nullable();

            $table->string('name_web',60)->nullable();

            $table->string('name_periodista',60)->nullable();

            $table->string('name_institucion',60)->nullable();

            $table->string('subtitle',60)->nullable();
            $table->string('name_editor',60)->nullable();

            $table->integer('cod_tesis')->nullable();
            $table->foreign('cod_tesis')
                    ->references('cod_tesis')
                    ->on('tesis_2022')
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
        Schema::dropIfExists('t_referencias');
    }
};
