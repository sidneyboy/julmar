<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmForOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_for_others', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->BigInteger('personnel_id')->unsigned()->index();
            $table->foreign('personnel_id')->references('id')->on('personnel_adds');
            $table->double('total_amount',15,4);
            $table->date('date');
            $table->string('status');
            $table->string('created_by');
            $table->string('approved_by');
            $table->string('transaction_remarks');
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
        Schema::dropIfExists('cm_for_others');
    }
}
