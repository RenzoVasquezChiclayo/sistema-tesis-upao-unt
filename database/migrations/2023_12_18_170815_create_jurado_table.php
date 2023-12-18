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
        Schema::create('jurado', function (Blueprint $table) {
            $table->integer('cod_jurado')->autoIncrement();
            $table->integer('cod_diseno_investigacion');
            $table->foreign('cod_diseno_investigacion')
                    ->references('cod_diseno_investigacion')
                    ->on('diseno_investigacion')
                    ->onDelete('cascade');
            $table->char('cod_docente',4);
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor_curso')
                    ->onDelete('cascade');
            $table->string('username')->nullable();
            $table->tinyInteger('estado')->default('1');
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
        Schema::dropIfExists('jurado');
    }
};
