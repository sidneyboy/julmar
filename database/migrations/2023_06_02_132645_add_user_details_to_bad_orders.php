<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDetailsToBadOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            $table->string('verified_date',20)->nullable();
            $table->integer('verified_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            //
        });
    }
}
