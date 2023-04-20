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
        DB::connection('mysql')->unprepared('CREATE TRIGGER update_asesor_curso BEFORE INSERT ON `asesor_curso` FOR EACH ROW
                BEGIN
                    SET NEW.username = CONCAT(SUBSTR(NEW.nombres, 1, 3),SUBSTR(NEW.cod_docente,1,2));
                END');
    }
    public function down()
    {
        // DB::connection('mysql')->unprepared('DROP TRIGGER `update_asesor_curso`');
    }
};
