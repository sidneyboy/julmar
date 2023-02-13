<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferToBranchJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_to_branch_jers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->Integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->double('inventory_into_branch',15,4);
            $table->double('inventory_out_origin',15,4);
            $table->string('branch_name');
            
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
        Schema::dropIfExists('transfer_to_branch_jers');
    }
}
