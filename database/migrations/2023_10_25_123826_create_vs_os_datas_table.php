<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsOsDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_os_datas', function (Blueprint $table) {
            $table->id();
            $table->string('export_code', 50);
            $table->Integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('vs_os_datas');
    }
}
