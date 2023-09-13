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
        Schema::table('tesis_2022', function (Blueprint $table) {
            $table->integer('id_grupo_inves')->after('titulo');
            $table->foreign('id_grupo_inves')
                    ->references('id_grupo')
                    ->on('grupo_investigacion')
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
