<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->unprepared('CREATE TRIGGER update_asesor BEFORE INSERT ON `asesor` FOR EACH ROW
                BEGIN
                    SET NEW.username = CONCAT(SUBSTR(NEW.nombres, 1, 4),SUBSTR(NEW.cod_docente,1,2));
                END');

    }
    public function down()
    {
        DB::unprepared('DROP TRIGGER `update_asesor`');
    }
};
