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
        Schema::create('t_detalle_keyword', function (Blueprint $table) {
            $table->integer('id_detalle_keyword')->autoIncrement();
            $table->integer('id_keyword')->nullable(false);
            $table->foreign('id_keyword')
                    ->references('id_keyword')
                    ->on('t_keyword')
                    ->onDelete('cascade');
            $table->string('keyword')->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('t_detalle_keyword');
    }
};
