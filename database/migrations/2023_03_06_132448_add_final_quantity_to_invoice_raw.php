<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalQuantityToInvoiceRaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_raws', function (Blueprint $table) {
            $table->Integer('final_quantity')->nullable();
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
            $table->dropColumn('final_quantity');
        });
    }
}
