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
        DB::unprepared('CREATE TRIGGER add_user_egresado AFTER INSERT ON `egresado` FOR EACH ROW
                BEGIN
                   INSERT INTO `users` (`name`,`password`,`remember_token`,`created_at`,`updated_at`,`rol`) VALUES (NEW.cod_matricula,MD5(NEW.cod_matricula),SUBSTR(MD5(RAND()), 1, 10),NOW(),NOW(),"estudiante");
                END');
    }
    public function down()
    {
        DB::unprepared('DROP TRIGGER `add_user_egresado`');
    }
};
