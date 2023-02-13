<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverHelperChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_helper_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('driver_helper_id')->unsigned()->index();
            $table->foreign('driver_helper_id')->references('id')->on('driver_helpers');
            $table->double('amount',15,4);
            $table->string('remarks');
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
        Schema::dropIfExists('driver_helper_charges');
    }
}
