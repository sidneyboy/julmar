<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingUploadLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_upload_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('van_selling_printed_id')->unsigned()->index();
            $table->foreign('van_selling_printed_id')->references('id')->on('van_selling_printeds');
            $table->BigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('principal');
            $table->string('sku_code');
            $table->string('description');
            $table->string('unit_of_measurement');
            $table->string('sku_type');
            $table->Integer('butal_equivalent');
            $table->string('reference');
            $table->Integer('beg');
            $table->Integer('van_load');
            $table->Integer('sales');
            $table->Integer('end');
            $table->double('unit_price',15,4);
            $table->double('total',15,4);
            $table->double('running_balance',15,4);
            $table->date('date');
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
        Schema::dropIfExists('van_selling_upload_ledgers');
    }
}
