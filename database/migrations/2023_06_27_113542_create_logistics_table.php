<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('truck_id')->unsigned()->nullable()->index();
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->BigInteger('driver')->unsigned()->nullable()->index();
            $table->foreign('driver')->references('id')->on('trucks');
            $table->string('contact_number');
            $table->string('helper_1');
            $table->string('helper_2');
            $table->integer('total_outlet');
            $table->string('loading_date', 15)->nullable();
            $table->integer('loading_date_updated_by')->unsigned()->nullable()->index();
            $table->foreign('loading_date_updated_by')->references('id')->on('users');
            $table->string('departure_date', 15)->nullable();
            $table->integer('departure_date_updated_by')->unsigned()->nullable()->index();
            $table->foreign('departure_date_updated_by')->references('id')->on('users');
            $table->string('arrival_date', 15)->nullable();
            $table->integer('arrival_date_updated_by')->unsigned()->nullable()->index();
            $table->foreign('arrival_date_updated_by')->references('id')->on('users');
            $table->string('sg_departure_noted_by')->nullable();
            $table->string('sg_arrival_noted_by')->nullable();
            $table->double('fuel_given_amount', 15, 4)->nullable();
            $table->string('remarks')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('logistics');
    }
}
