<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDraftDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_draft_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_draft_id')->unsigned()->index()->nullable();
            $table->foreign('invoice_draft_id')->references('id')->on('invoice_drafts');
            $table->integer('sku_id')->unsigned()->index()->nullable();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->double('unit_price',15,4);
            $table->double('line_discount',15,4);
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
        Schema::dropIfExists('invoice_draft_details');
    }
}
