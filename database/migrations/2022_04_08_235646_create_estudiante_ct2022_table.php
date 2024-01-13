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


        Schema::connection('mysql')->create('estudiante_ct2022', function (Blueprint $table) {
            $table->char('cod_matricula',10)->primary();
            $table->string('dni',8);
            $table->string('apellidos',30);
            $table->string('nombres',30);
            $table->char('cod_escuela',4);
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
        // Schema::connection('mysql')->dropIfExists('estudiante_ct2022');
    }
};
