<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeparatedWeightToSkuAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sku_adds', function (Blueprint $table) {
            $table->double('kilograms',15,4);
            $table->double('grams',15,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Sku_adds', function (Blueprint $table) {
            $table->dropColumn('kilograms');
            $table->dropColumn('grams');
        });
}
}
