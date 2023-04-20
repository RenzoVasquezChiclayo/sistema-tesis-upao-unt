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

        DB::connection('mysql')->unprepared('CREATE TRIGGER add_user_estudiante AFTER INSERT ON `estudiante_ct2022` FOR EACH ROW
                BEGIN
                   INSERT INTO `users` (`name`,`password`,`remember_token`,`created_at`,`updated_at`,`rol`) VALUES (CONCAT(NEW.cod_matricula,"-C"),MD5(NEW.cod_matricula),SUBSTR(MD5(RAND()), 1, 10),NOW(),NOW(),"CTesis2022-1");
                END');
    }
    public function down()
    {
        // DB::unprepared('DROP TRIGGER `add_user_estudiante`');
    }
};
