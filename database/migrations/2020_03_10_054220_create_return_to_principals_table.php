<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnToPrincipalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_to_principals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->bigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('personnel',150);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('return_to_principals');
    }
}
