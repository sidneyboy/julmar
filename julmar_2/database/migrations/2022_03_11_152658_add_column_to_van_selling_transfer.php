<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToVanSellingTransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('van_selling_transfer_inventory_details', function (Blueprint $table) {
            $table->string('sku_type');
            $table->string('butal_equivalent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('van_selling_transfer_inventory_details', function (Blueprint $table) {
            $table->dropColumn('sku_type');
            $table->dropColumn('butal_equivalent');
        });
    }
}
