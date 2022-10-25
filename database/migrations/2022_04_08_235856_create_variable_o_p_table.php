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
        Schema::connection('mysql')->create('variableop', function (Blueprint $table) {
            $table->integer('cod_variable')->autoIncrement();
            $table->string('descripcion',80);
            $table->integer('cod_proyinvestigacion');

            // $table->foreign('cod_proyinvestigacion')
            //         ->references('cod_proyinvestigacion')
            //         ->on('proyInvestigacion')
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
        Schema::connection('mysql')->dropIfExists('variable_o_p');
    }
};
