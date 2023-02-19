<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScannedAndFinalized extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Received_purchase_orders', function (Blueprint $table) {
            $table->integer('scanned_by')->unsigned()->index();
            $table->foreign('scanned_by')->references('id')->on('users');
            $table->integer('finalized_by')->unsigned()->index();
            $table->foreign('finalized_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Received_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('scanned_by');
            $table->dropColumn('finalized_by');
        });
    }
}
