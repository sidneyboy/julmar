<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisbursementOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disbursement_others', function (Blueprint $table) {
            $table->id();
            $table->string('payee');
            $table->date('transaction_date');
            $table->string('invoice_number');
            $table->string('check_ref');
            $table->string('description');
            $table->string('bank');
            $table->date('transaction_date_from');
            $table->date('transaction_date_to');
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
        Schema::dropIfExists('disbursement_others');
    }
}
