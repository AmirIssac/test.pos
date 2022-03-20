<?php

namespace App\Exports;

use App\DailyReport;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DailyReportExport implements FromCollection , WithHeadings , WithStrictNullComparison
{   
    private $report_id;

    public function __construct($report_id){
         $this->report_id = $report_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return DailyReport::all();
        $report = DailyReport::where('id',$this->report_id)->get()->makeHidden(['id','repository_id','cash_shortage','card_shortage','stc_shortage','cash_plus','card_plus','stc_plus','created_at','updated_at']);
          // use map to modify specific columns values
        // we use map in general to modify collection values
        $report = $report->map(function ($item, $key) {  // $item is the each one report row object
            $employee = User::find($item->user_id)->name;
            $item->user_id = $employee;
        });
        return $report;
    }
    
    public function headings(): array
    {
        return ["employee" , "cash" , "card" , "stc-pay" , "sales" , "purchases" , "close_time"  , "invoices number" , "delivered" , "pending" , "refunded" , "deleted" , "amount in box" , "Pending money for this day sales" , "Total Gained money this day" , "Gained money for this day sales" , "Purchases payed from cashier" , "Purchases Payed from external money"];
    }
}
