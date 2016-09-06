<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('record', function (Blueprint $table) {
            $table->dropColumn('access_id');
            //$table->integer('access_id')->nullable();
            $table->dropColumn('note');
            //$table->string('note')->nullable();
            $table->string('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('record', function (Blueprint $table) {
            //$table->dropColumn('access_id');
            $table->integer('access_id');
            //$table->dropColumn('note');
            $table->integer('note');
            $table->dropColumn('ip');
        });
    }
}
