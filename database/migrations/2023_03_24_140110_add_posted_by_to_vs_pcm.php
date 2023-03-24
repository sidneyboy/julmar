<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostedByToVsPcm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Vs_pcms', function (Blueprint $table) {
            $table->integer('posted_by')->unsigned()->nullable()->index();
            $table->foreign('posted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Vs_pcms', function (Blueprint $table) {
            $table->dropColumn('posted_by');
        });
    }
}
