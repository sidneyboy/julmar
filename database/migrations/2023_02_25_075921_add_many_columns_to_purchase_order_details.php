<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToPurchaseOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Purchase_order_details', function (Blueprint $table) {
            $table->double('freight',15,4)->nullable();
            $table->double('final_unit_cost',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Purchase_order_details', function (Blueprint $table) {
            $table->dropColumn('freight');
            $table->dropColumn('final_unit_cost');
        });
    }
}
