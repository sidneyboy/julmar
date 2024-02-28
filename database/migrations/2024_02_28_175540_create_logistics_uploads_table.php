<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_uploads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('logistics_id')->unsigned()->nullable()->index();
            $table->foreign('logistics_id')->references('id')->on('logistics');
            $table->bigInteger('sales_invoice_id')->unsigned()->nullable()->index();
            $table->foreign('sales_invoice_id')->references('id')->on('logistics');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('logistics_uploads');
    }
}
