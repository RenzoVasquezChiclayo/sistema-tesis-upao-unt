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
        Schema::table('grupo_investigacion', function (Blueprint $table) {
            $table->string('cod_docente_tesis',4)->nullable()->after('cod_docente');
            $table->foreign('cod_docente_tesis')
                    ->references('cod_docente')
                    ->on('asesor_curso')
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
        //
    }
};
