<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_send_id');  // sender
            $table->foreignId('repository_recieve_id');  // reciever
            $table->foreignId('user_sender_id'); // sender
            $table->foreignId('user_reciever_id')->default(null)->nullable(); // reciever
            $table->string('code',8);
            $table->float('total_price');
            $table->enum('status',['pending','delivered','refused','retrieved']);
            $table->boolean('daily_report_check')->default(false);
            $table->boolean('monthly_report_check')->default(false);
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
        Schema::dropIfExists('exports');
    }
}
