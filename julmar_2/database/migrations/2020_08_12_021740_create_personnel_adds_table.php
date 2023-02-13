<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonnelAddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnel_adds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('principal_id');
            $table->bigInteger('personnel_description_id')->unsigned()->index();
            $table->foreign('personnel_description_id')->references('id')->on('personnel_descriptions');
            $table->string('gender');
            $table->string('contact_number');
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
        Schema::dropIfExists('personnel_adds');
    }
}
