<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnToPrincipalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_to_principal_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->bigInteger('return_to_principal_id')->unsigned()->index();
            $table->foreign('return_to_principal_id')->references('id')->on('return_to_principals');
            $table->integer('quantity_return');
            $table->double('unit_cost', 15,4);
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
        Schema::dropIfExists('return_to_principal_details');
    }
}
