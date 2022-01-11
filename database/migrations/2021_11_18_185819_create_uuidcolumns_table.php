<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUuidcolumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('uuidcolumns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        */

        Schema::table('invoices', function (Blueprint $table) {
            $table->uuid('uuid')->index()->after('id')->default(null);
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->uuid('uuid')->index()->after('id')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uuidcolumns');
    }
}
