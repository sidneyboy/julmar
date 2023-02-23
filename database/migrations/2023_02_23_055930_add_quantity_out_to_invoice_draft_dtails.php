<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityOutToInvoiceDraftDtails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_draft_details', function (Blueprint $table) {
            $table->integer('quantity_out')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Invoice_draft_details', function (Blueprint $table) {
            $table->dropColumn('quantity_out');
        });
    }
}
