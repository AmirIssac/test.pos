<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('purchase_id');
            $table->foreignId('user_id');   // the employee who recieve this purchase
            $table->float('pay_amount');
            $table->float('total_price');
            $table->enum('payment',['later','cashier','external']); // آجل او درج أو ميزانية خارجية
            $table->enum('status',['done','retrieved','pending','later']);
            $table->boolean('daily_report_check');
            $table->boolean('monthly_report_check');
            $table->dateTime('created_at');   // old one
            $table->dateTime('transfered_at'); // transfered time
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_processes');
    }
}
