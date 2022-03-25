<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceInvoice extends Model
{
    protected $fillable = [
        'uuid','repository_id','user_id','code', 'details','total_price','discount','tax','tax_code','phone','created_at','transform','note',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
