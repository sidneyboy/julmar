<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationDetailsIdToCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Customers', function (Blueprint $table) {
            $table->BigInteger('location_details_id')->unsigned()->nullable()->index();
            $table->foreign('location_details_id')->references('id')->on('location_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Customers', function (Blueprint $table) {
            $table->dropColumn('location_details_id');
        });
    }
}
