<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrincipalToInvoiceRaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_raws', function (Blueprint $table) {
            $table->string('principal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Invoice_raws', function (Blueprint $table) {
            $table->dropColumn('principal');
        });
    }
}
