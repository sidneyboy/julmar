<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name');
            $table->bigInteger('location_id')->unsigned()->index();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->string('detailed_location');
            $table->string('credit_term');
            $table->double('credit_line_amount');
            $table->string('contact_person');
            $table->string('contact_number');
            $table->string('kind_of_business');
             $table->string('status');
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
        Schema::dropIfExists('customers');
    }
}
