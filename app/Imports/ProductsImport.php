<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Throwable;

class ProductsImport implements ToModel , SkipsOnError , WithValidation , SkipsOnFailure , WithBatchInserts , WithChunkReading , WithHeadingRow
{
    use Importable , SkipsErrors , SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $repository_id;

    public function __construct($repo_id){
         $this->repository_id = $repo_id;
         HeadingRowFormatter::default('none');
    }
    

    public function model(array $row)
    {   
        $product = Product::where('repository_id',$this->repository_id)->where('barcode',$row['باركود'])->first();
        if($product)  // found it
        {
        $new_quantity = $product->quantity + $row['الكمية'];
        $new_cost_price = $row['سعر التكلفة'];
        $new_price = $row['سعر المبيع'];
        $product->update([
            'quantity' => $new_quantity,
            'cost_price' => $new_cost_price,
            'price' => $new_price,
        ]);
        }
    else{
        return new Product([
        'repository_id' => $this->repository_id,
           'barcode' => $row['باركود'],
           'name_ar'    => $row['الاسم بالعربية'], 
           'name_en' => $row['الاسم بالانجليزية'],
           'cost_price' => $row['سعر التكلفة'],
           'price'   => $row['سعر المبيع'],
           'quantity'=> $row['الكمية'],
           'accept_min' => false,
        ]);
        }
    }
    public function onError(Throwable $error){

    }


    public function rules(): array
    {
        return [
            '*.باركود' => 'required',
            '*.الاسم بالعربية' => 'required',
            '*.سعر التكلفة' => 'required',
            '*.سعر المبيع' => 'required',
            '*.الكمية' => 'required',
        ];
    }
    
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function batchSize(): int    // we use withBatchInserts interface for the very large files
    {
        return 1000;
    }

    public function chunkSize(): int   // for memory usage for big files
    {
        return 1000;
    }
}
