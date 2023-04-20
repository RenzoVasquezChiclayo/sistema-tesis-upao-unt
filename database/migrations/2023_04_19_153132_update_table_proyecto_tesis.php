<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            DB::statement("ALTER TABLE proyecto_tesis MODIFY ti_finpersigue char(4) null");
            DB::statement("ALTER TABLE proyecto_tesis MODIFY ti_disinvestigacion char(4) null");
            // $table->char('ti_finpersigue',4)->nullable();
            // $table->foreign('ti_finpersigue')
            //         ->references('cod_fin_persigue')
            //         ->on('fin_persigue')
            //         ->onDelete('cascade');
            // $table->char('ti_disinvestigacion',4)->nullable();
            // $table->foreign('ti_disinvestigacion')
            //         ->references('cod_diseno_investigacion')
            //         ->on('diseno_investigacion')
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
        Schema::table('proyecto_tesis', function (Blueprint $table) {
            // $table->removeColumn('ti_finpersigue');
            // $table->removeColumn('ti_disinvestigacion');
            DB::statement("ALTER TABLE proyecto_tesis MODIFY ti_finpersigue char(4) null");
            DB::statement("ALTER TABLE proyecto_tesis MODIFY ti_disinvestigacion char(4) null");
        });
    }
};
