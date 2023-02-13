<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivedJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_jers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('Sku_principals');
            $table->bigInteger('received_id')->unsigned()->index()->nullable();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->double('dr', 15,4);
            $table->double('cr', 15,4);
            $table->date('date')->index();
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
        Schema::dropIfExists('received_jers');
    }
}
