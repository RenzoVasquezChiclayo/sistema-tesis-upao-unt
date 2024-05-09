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
        Schema::table('referencias', function (Blueprint $table) {
            DB::statement("ALTER TABLE referencias MODIFY titulo text null");
            DB::statement("ALTER TABLE referencias MODIFY fuente text null");
            DB::statement("ALTER TABLE referencias MODIFY editorial text null");
            DB::statement("ALTER TABLE referencias MODIFY title_cap text null");
            DB::statement("ALTER TABLE referencias MODIFY title_revista text null");
            DB::statement("ALTER TABLE referencias MODIFY name_web text null");
            DB::statement("ALTER TABLE referencias MODIFY name_periodista text null");
            DB::statement("ALTER TABLE referencias MODIFY name_institucion text null");
            DB::statement("ALTER TABLE referencias MODIFY subtitle text null");
            DB::statement("ALTER TABLE referencias MODIFY name_editor text null");
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
