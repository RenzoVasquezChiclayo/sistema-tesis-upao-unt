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
        Schema::connection('mysql')->create('escuela', function (Blueprint $table) {
            $table->char('cod_escuela',4)->primary();
            $table->string('nombre',40);
            $table->char('cod_facultad',4);
            $table->foreign('cod_facultad')
                    ->references('cod_facultad')
                    ->on('facultad')
                    ->onDelete('cascade');
            $table->tinyInteger('estado')->default('1');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::connection('mysql')->dropIfExists('escuela');
    }
};
