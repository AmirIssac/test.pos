<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportRecord extends Model
{
    //
    protected $fillable = [
        'export_id','type_id','barcode','name_ar', 'name_en' ,'cost_price','price','quantity','accept_min',
        'stored',
     ];

     public function export(){ 
        return $this->belongsTo(Export::class);
    }
}
