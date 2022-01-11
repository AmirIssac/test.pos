<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name_ar','name_en','price',
    ];

    public function repositories(){
        return $this->hasMany(Repository::class);
    }
}
