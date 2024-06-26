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
        Schema::table('proyecto_tesis', function (Blueprint $table) {
            $table->dropColumn('t_ReparacionInstrum');
            $table->dropColumn('t_RecoleccionDatos');
            $table->dropColumn('t_AnalisisDatos');
            $table->dropColumn('t_ElaboracionInfo');
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
