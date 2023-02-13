<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoAllowanceAdjustmentsJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bo_allowance_adjustments_jers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bo_allowance_id')->unsigned()->index();
            $table->foreign('bo_allowance_id')->references('id')->on('bo_allowance_adjustments');
            $table->double('dr', 15,4);
            $table->double('cr', 15,4);
            $table->date('date')->index();
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
        Schema::dropIfExists('bo_allowance_adjustments_jers');
    }
}
