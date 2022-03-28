<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'name', 'phone','points','tax_code','tax_address',
    ];

    public function repositories(){
        return $this->belongsToMany(Repository::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function savedRecipes(){
        return $this->hasMany(SavedRecipe::class);
    }
}
