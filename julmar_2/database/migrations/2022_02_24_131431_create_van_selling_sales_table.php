<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
 */
    public function up()
    {
        Schema::create('van_selling_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('vs_upload_id')->unsigned()->index();
            $table->foreign('vs_upload_id')->references('id')->on('van_selling_uploads');
            $table->BigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('principal');
            $table->string('sku_code');
            $table->string('description');
            $table->string('unit_of_measurement');
            $table->string('sku_type');
            $table->Integer('butal_equivalent');
            $table->string('reference');
            $table->string('store_name');
            $table->Integer('sales');
            $table->double('unit_price',15,4);
            $table->double('total',15,4);
            $table->date('date');
            $table->string('date_sold')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('van_selling_sales');
    }
}
