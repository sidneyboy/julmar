<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToVsPcm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Vs_pcms', function (Blueprint $table) {
            $table->string('pcm_type',20);
            $table->string('store_name');
            $table->string('remitted_by');
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
            $table->dropColumn('pcm_type');
            $table->dropColumn('store_name');
            $table->dropColumn('remitted_by');
        });
    }
}
