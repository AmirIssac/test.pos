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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Throwable;

class ProductsImportSpecial implements ToModel , SkipsOnError , WithValidation , SkipsOnFailure , WithBatchInserts , WithChunkReading , WithStartRow 
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
    }
    
    
    public function model(array $row){
        $product = Product::where('repository_id',$this->repository_id)->where('barcode','=',(string)$row[0])->first();
        if($product)  // found it
        {
            $new_quantity = (integer)$product->quantity + $row[5];
            $new_cost_price = $row[3];
            $new_price = $row[4];
            $new_type = $row[6];
            $new_acceptmin = $row[7];
            $new_stored = $row[8];
            $product->update([
                'quantity' => $new_quantity,
                'cost_price' => $new_cost_price,
                'price' => $new_price,
                'type_id' => $new_type,
                'accept_min' => $new_acceptmin,
                'stored' => $new_stored,
            ]);
        }
        else{
            return new Product([
            'repository_id' => $this->repository_id,
            'barcode' => (string)$row[0],
            'name_ar'    => $row[1], 
            'name_en' => $row[2],
            'cost_price' => $row[3],
            'price'   => $row[4],
            'quantity'=> (integer)$row[5],
            'type_id' => $row[6],
            'accept_min' => $row[7],
            'stored' => $row[8],
            ]);
        }
    }
    public function onError(Throwable $error){

    }

    public function startRow(): int
    {
        return 2;
    }


    
    public function rules(): array
    {
        return [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.3' => 'required',
            '*.4' => 'required',
            '*.5' => 'required',
            '*.6' => 'required',
            '*.7' => 'required',
            '*.8' => 'required',
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

    /*
    public function columnFormats(): array
    {
        return [
            'باركود' => '@',
        ];
    }
    */
    
    
}
