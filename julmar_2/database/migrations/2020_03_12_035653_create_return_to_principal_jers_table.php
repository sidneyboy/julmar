<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnToPrincipalJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_to_principal_jers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('return_to_principal_id')->unsigned()->index();
            $table->foreign('return_to_principal_id')->references('id')->on('return_to_principals');
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
        Schema::dropIfExists('return_to_principal_jers');
    }
}
