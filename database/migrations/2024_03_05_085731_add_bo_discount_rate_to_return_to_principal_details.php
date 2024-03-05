<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoDiscountRateToReturnToPrincipalDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Return_to_principal_details', function (Blueprint $table) {
            $table->float('bo_discount',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Return_to_principal_details', function (Blueprint $table) {
            $table->dropColumn('bo_discount');
        });
    }
}
