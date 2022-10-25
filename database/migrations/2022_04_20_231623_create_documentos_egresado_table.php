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
        Schema::create('documentos_egresado', function (Blueprint $table) {
            $table->integer('cod_documentos')->autoIncrement();
            $table->char('cod_matricula',10);
            $table->string('fut',40);
            $table->string('constancia',40);
            $table->string('recibo',40);


            $table->foreign('cod_matricula')
                    ->references('cod_matricula')
                    ->on('egresado')
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
        Schema::dropIfExists('documentos_egresado');
    }
};
