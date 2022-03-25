<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->foreignId('repository_id');
            $table->foreignId('user_id');   // the cashier who print this invoice
            $table->string('code',8);
            $table->string('details',10000);
            $table->float('total_price');
            $table->float('discount')->default(0.00);   // discount value
            $table->string('phone')->nullable();  // client number
            $table->float('tax')->default(0);   // real value
            $table->string('tax_code')->default('0000');
            $table->string('note')->default(null)->nullable();
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
        Schema::dropIfExists('price_invoices');
    }
}
