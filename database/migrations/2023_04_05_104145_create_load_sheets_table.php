<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('load_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('load_sheet_id');
            $table->string('agent')->nullable();
            $table->string('customer')->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->bigInteger('agent_id')->unsigned()->nullable()->index();
            $table->foreign('agent_id')->references('id')->on('agents');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('principal_id')->unsigned()->nullable()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('load_sheets');
    }
}
