<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('Posx');
            $table->dropColumn('posy');
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device', function (Blueprint $table) {
          $table->dropColumn('x');
          $table->dropColumn('y');
          $table->integer('Posx');
          $table->integer('posy');
        });
    }
}
