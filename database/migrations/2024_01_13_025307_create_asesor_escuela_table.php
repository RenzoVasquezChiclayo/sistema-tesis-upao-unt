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
        Schema::create('asesor_escuela', function (Blueprint $table) {
            $table->integer('cod_asesor_escuela')->autoIncrement();
            $table->char('cod_docente',4);
            $table->foreign('cod_docente')
                    ->references('cod_docente')
                    ->on('asesor_curso')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('asesor_escuela');
    }
};
