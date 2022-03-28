<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'repository_id','is_active','end_of_experience','cashier_reminder','invoices_count_today','print_prescription','print_additional_recipe','discount_by_percent','discount_by_value', 'discount_change_price',
        'standard_printer','thermal_printer','customer_data',
    ];

    protected $dates = ['created_at', 'updated_at', 'end_of_experience','cashier_reminder'];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
