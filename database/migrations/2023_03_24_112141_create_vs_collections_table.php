<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_collections', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->double('total_amount',15,4);
            $table->string('bank');
            $table->string('reference')->nullable();
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
        Schema::dropIfExists('vs_collections');
    }
}
