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
        DB::connection('mysql')->unprepared('CREATE TRIGGER add_user_director AFTER INSERT ON `director` FOR EACH ROW
                BEGIN
                   INSERT INTO `users` (`name`,`password`,`remember_token`,`created_at`,`updated_at`,`rol`) VALUES (CONCAT(SUBSTR(NEW.nombres, 1, 3),SUBSTR(NEW.apellidos,1,3)),MD5("admin"),SUBSTR(RAND(),1,10),NOW(),NOW(),2);
                END');
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
