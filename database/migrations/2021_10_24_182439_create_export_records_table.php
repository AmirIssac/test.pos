<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('export_id');
            $table->foreignId('type_id')->nullable();  // null able for original products
            $table->string('barcode');
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->float('cost_price')->default(0);
            $table->float('price');
            $table->integer('quantity');
            $table->boolean('accept_min')->default(1);   // يقبل الحد الأدنى  
            $table->boolean('stored')->default(true);  // هنالك نوعين نوع يتم تخزينه ونوع لا
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
        Schema::dropIfExists('export_records');
    }
}
