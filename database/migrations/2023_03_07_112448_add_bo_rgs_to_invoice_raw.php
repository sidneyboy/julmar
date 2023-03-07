<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoRgsToInvoiceRaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_raws', function (Blueprint $table) {
            $table->string('rgs')->nullable();
            $table->string('bo')->nullable();
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
            $table->dropColumn('rgs');
            $table->dropColumn('bo');
        });
    }
}
