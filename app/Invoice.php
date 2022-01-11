<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'uuid','repository_id','user_id','customer_id','code', 'details','recipe','total_price','discount','cash_check','card_check','stc_check','cash_amount','card_amount','stc_amount','tax','tax_code','status','phone','created_at','transform','daily_report_check','monthly_report_check','note',
    ];
    /*
    protected $hidden = [
        'id'
    ];
    */

    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
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

    public function dailyReports(){
        return $this->belongsToMany(DailyReport::class,'daily_report_invoice');
    }

    public function monthlyReports(){
        return $this->belongsToMany(MonthlyReport::class,'invoice_monthly_report');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function invoiceProcesses(){
        return $this->hasMany(InvoiceProcess::class);
    }
}
