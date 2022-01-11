<?php

use App\Invoice;
use App\Purchase;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class MigrateUUIDs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $invoices = Invoice::all();
        $purchases = Purchase::all();
        foreach($invoices as $invoice){
            $invoice->update([
                'uuid' => Uuid::generate(4), 
            ]);
        }
        foreach($purchases as $purchase){
            $purchase->update([
                'uuid' => Uuid::generate(4), 
            ]);
        }
    }
}
