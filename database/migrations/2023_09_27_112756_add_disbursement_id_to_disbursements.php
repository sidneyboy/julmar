<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisbursementIdToDisbursements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Disbursement_jers', function (Blueprint $table) {
            $table->bigInteger('disbursement_id')->unsigned()->nullable()->index();
            $table->foreign('disbursement_id')->references('id')->on('disbursements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Disbursement_jers', function (Blueprint $table) {
            $table->dropColumn('disbursement_id');
        });
    }
}
