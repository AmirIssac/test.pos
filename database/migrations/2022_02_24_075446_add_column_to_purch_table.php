<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnToPurchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->float('pay_amount')->after('supplier_invoice_num');
        });
        // default value according to specific column value
        DB::statement('UPDATE purchases SET pay_amount = total_price WHERE payment != "later" ');
        DB::statement('UPDATE purchases SET pay_amount = 0 WHERE payment = "later" ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
}
