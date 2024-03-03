<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToBoAllowanceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bo_allowance_adjustments_details', function (Blueprint $table) {
            $table->float('bo_cost_adjustment',15,4)->nullable();
            $table->float('bo_discount',15,4)->nullable();
            $table->float('freight',15,4)->nullable();
            $table->float('vat',15,4)->nullable();
            $table->float('total_cost',15,4)->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Bo_allowance_adjustments_details', function (Blueprint $table) {
            $table->dropColumn('bo_cost_adjustment');
            $table->dropColumn('bo_discount');
            $table->dropColumn('freight');
            $table->dropColumn('vat');
            $table->dropColumn('total_cost');  
        });
    }
}
