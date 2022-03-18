<?php

namespace App\Exports;

use App\Product;
use App\Type;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements FromCollection , WithHeadings , WithStrictNullComparison
{
    private $repository_id;

    public function __construct($repo_id){
         $this->repository_id = $repo_id;
    }
    

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        $products = Product::where('repository_id',$this->repository_id)->get()
        ->makeHidden(['id','repository_id','measurements']);
        // use map to modify specific columns values
        // we use map in general to modify collection values
        $products_modified = $products->map(function ($item, $key) {  // $item is the each one product object
            $type_name = Type::find($item->type_id)->name_ar;
            $item->type_id = $type_name;
            if($item->accept_min)
                $item->accept_min = 'نعم';
            else
                $item->accept_min = 'لا';
            if($item->stored)
                $item->stored = 'نعم';
            else
                $item->stored = 'لا';
            return $item;
        });
        return $products_modified;
        //return $products;
        //return $this->fromCollection($products, null, 'A1', true);
    }

    public function headings(): array
    {
        return ["Barcode", "Arabic Name", "English Name" , "Cost Price" , "Price" , "Quantity" , "Type" , "Accept Min" , "Stored" , "Created_at" , "Updated_at"];
    }
}
