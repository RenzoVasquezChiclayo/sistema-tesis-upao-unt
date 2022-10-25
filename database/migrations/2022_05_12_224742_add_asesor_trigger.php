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
        DB::connection('mysql')->unprepared('CREATE TRIGGER add_user_asesor AFTER INSERT ON `asesor` FOR EACH ROW
                BEGIN
                   INSERT INTO `users` (`name`,`password`,`remember_token`,`created_at`,`updated_at`,`rol`) VALUES (CONCAT(SUBSTR(NEW.nombres, 1, 4),SUBSTR(NEW.cod_docente,1,2)),MD5(NEW.cod_docente),SUBSTR(RAND(),1,10),NOW(),NOW(),"asesor");
                END');


    }
    public function down()
    {
        DB::unprepared('DROP TRIGGER `add_user_asesor`');
    }
};
