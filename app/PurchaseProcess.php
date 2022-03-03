<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseProcess extends Model
{
    protected $fillable = [
        'repository_id','purchase_id','user_id','pay_amount','total_price','payment','status','daily_report_check','monthly_report_check','created_at','transfered_at'
    ];

    protected $dates = [
        'created_at',
        'transfered_at',
    ];
    public $timestamps = false;

    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
