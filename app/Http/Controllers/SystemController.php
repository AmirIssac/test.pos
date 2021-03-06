<?php

namespace App\Http\Controllers;

use App\MonthlyReport;
use App\Repository;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    //

    public function index(){
        return view('system.index');
    }

    
    public function makeMonthlyReport1(){
        ini_set('max_execution_time', 1000);
        $repositories = Repository::all();
        foreach($repositories as $repository){
            if($repository->isSpecial() && $repository->upToDate()){
                $invoices = $repository->invoices()->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
                ->whereMonth('created_at','=',now()->month)->get();  // the invoices that will taken in monthly report
                /*$invoices = $repository->invoices()->where('monthly_report_check',false)
                ->get();*/
                $cash_amount = $repository->statistic->m_in_cash_balance;
                $card_amount = $repository->statistic->m_in_card_balance;
                $stc_amount = $repository->statistic->m_in_stc_balance;

                $purchases = $repository->purchases()->where('monthly_report_check',false)->whereYear('updated_at','=',now()->year)
                ->whereMonth('updated_at','=',now()->month)->get();
                
                $out_cashier = 0 ;
                $out_external = 0 ;
                foreach($purchases as $purchase){
                    if($purchase->payment == 'cashier' && $purchase->status != 'retrieved')
                        $out_cashier = $out_cashier + $purchase->total_price;
                    elseif($purchase->payment == 'external' && $purchase->status != 'retrieved')
                        $out_external = $out_external + $purchase->total_price;
                }
                $monthly_report = MonthlyReport::create([
                    'repository_id' => $repository->id,
                    'cash_balance' => $cash_amount,
                    'card_balance' => $card_amount,
                    'stc_balance' => $stc_amount, 
                    'out_cashier' => $out_cashier,
                    'out_external' => $out_external,
                ]);

                // make statistic for month is Zero because we start new month
                $statistic = $repository->statistic;
                $statistic->update([
                    'm_in_cash_balance' => 0,
                    'm_in_card_balance' => 0,
                    'm_in_stc_balance' => 0,
                ]);
                foreach($invoices as $invoice){
                    $monthly_report->invoices()->attach($invoice->id);
                    $invoice->update(
                        [
                            'monthly_report_check' => true,
                        ]
                        );
                }
                foreach($purchases as $purchase){
                    $monthly_report->purchases()->attach($purchase->id);
                    $purchase->timestamps = false;
                    $purchase->monthly_report_check = true;
                    $purchase->save();
                    /*
                    $purchase->update(
                        [
                            'monthly_report_check' => true,
                        ]
                        );
                        */
                }
            }
        }
        return redirect()->route('system.index')->with('success',__('alerts.monthly_report_create_success')); 
    }

    // Ramadan procedure
    public function makeMonthlyReport(){
        ini_set('max_execution_time', 1000);
        $repositories = Repository::all();
        foreach($repositories as $repository){
            if($repository->upToDate()){
                $invoices = $repository->invoices()->where('monthly_report_check',false)->
        whereYear('created_at','=', now()->year)
        ->where(function($query){
            $query->whereMonth('created_at','=',now()->month)->orWhereMonth('created_at','=',now()->month - 1);
        })
        ->get();  // the invoices that will taken in monthly report
                /*$invoices = $repository->invoices()->where('monthly_report_check',false)
                ->get();*/
                $cash_amount = $repository->statistic->m_in_cash_balance;
                $card_amount = $repository->statistic->m_in_card_balance;
                $stc_amount = $repository->statistic->m_in_stc_balance;

                $purchases = $repository->purchases()->where('monthly_report_check',false)->whereYear('updated_at','=',now()->year)
                ->where(function($query){
                    $query->whereMonth('updated_at','=',now()->month)->orWhereMonth('updated_at','=',now()->month - 1);
                })->get();

                $out_cashier = 0 ;
                $out_external = 0 ;
                foreach($purchases as $purchase){
                    if($purchase->payment == 'cashier' && $purchase->status != 'retrieved')
                        $out_cashier = $out_cashier + $purchase->total_price;
                    elseif($purchase->payment == 'external' && $purchase->status != 'retrieved')
                        $out_external = $out_external + $purchase->total_price;
                }
                /*
                $monthly_report = MonthlyReport::create([
                    'repository_id' => $repository->id,
                    'cash_balance' => $cash_amount,
                    'card_balance' => $card_amount,
                    'stc_balance' => $stc_amount, 
                    'out_cashier' => $out_cashier,
                    'out_external' => $out_external,
                ]);
                */
                // report custom date
                $report_custom_date = Carbon::create(now()->year,now()->month - 1 , 30 , 23 , 59 , 00 );
                $monthly_report = new MonthlyReport();
                $monthly_report->timestamps = false; // disable timestamps for this creation
                $monthly_report->repository_id = $repository->id ;
                $monthly_report->cash_balance = $cash_amount ;
                $monthly_report->card_balance = $card_amount ;
                $monthly_report->stc_balance = $stc_amount ;
                $monthly_report->out_cashier = $out_cashier ;
                $monthly_report->out_external = $out_external ;
                $monthly_report->created_at = $report_custom_date ;
                $monthly_report->updated_at = $report_custom_date ;
                $monthly_report->save();

                // make statistic for month is Zero because we start new month
                $statistic = $repository->statistic;
                $statistic->update([
                    'm_in_cash_balance' => 0,
                    'm_in_card_balance' => 0,
                    'm_in_stc_balance' => 0,
                ]);
                foreach($invoices as $invoice){
                    $monthly_report->invoices()->attach($invoice->id);
                    $invoice->update(
                        [
                            'monthly_report_check' => true,
                        ]
                        );
                }
                foreach($purchases as $purchase){
                    $monthly_report->purchases()->attach($purchase->id);
                    $purchase->timestamps = false;
                    $purchase->monthly_report_check = true;
                    $purchase->save();
                    /*
                    $purchase->update(
                        [
                            'monthly_report_check' => true,
                        ]
                        );
                        */
                }
            }
        }
        return redirect()->route('system.index')->with('success',__('alerts.monthly_report_create_success')); 
    }
    public function showRepositoryStatus($id){
        $repository = Repository::find($id);
        $setting = $repository->setting;
        return view('dashboard.Repositories.status')->with(['repository'=>$repository,'setting'=>$setting]);
    }

    public function editRepositoryStatus(Request $request,$id){
        $repository = Repository::find($id);
        $setting = $repository->setting;
        $activate = 1;
        if($request->activate == 0){
            $activate = 0;
        }
        if($request->end_at){    // ?????????? ?????? ????????????
            if($request->end_at > now()){
                $setting->update([
                    'is_active' => true,
                    'end_of_experience' => $request->end_at,
                ]);
            }
            else{
                $setting->update([
                    'is_active' => false,
                    'end_of_experience' => $request->end_at,
                ]);
            }
        }
        else{   // ?????? ?????????? ?????? ????????????
            $setting->update([
                'is_active' => $activate,
            ]); 
        }
        return back()->with('success','???? ?????????? ???????? ????????????');
    }

    public function factoryReset($id){
        ini_set('max_execution_time', 500);
        $repository = Repository::find($id);
        /*
        User::where('id','<',11)->delete();
        $visits = Visit::find($id);
        $visits->products()->detach($product_id);
        */
        $purchases = $repository->purchases;
        $invoices = $repository->invoices;
        $daily_reports = $repository->dailyReports;
        $monthly_reports = $repository->monthlyReports;
        foreach($daily_reports as $dayrep){
            $dayrep->invoices()->sync([]);
            $dayrep->purchases()->sync([]);
        }
        foreach($monthly_reports as $monthrep){
            $monthrep->invoices()->sync([]);
            $monthrep->purchases()->sync([]);
        }
        foreach($invoices as $invoice){
            $invoice->invoiceProcesses()->delete();
        }
        foreach($purchases as $purchase){
            $purchase->purchaseRecords()->delete();
        }
        $repository->invoices()->delete();
        $repository->purchases()->delete();
        $repository->dailyReports()->delete();
        $repository->monthlyReports()->delete();
        $repository->records()->delete();
        /*
        $customers = $repository->customers;
        foreach($customers as $customer){
            $cu_ids[] = $customer->id;
        }
        $repository->customers()->detach($cu_ids);
        */
        $repository->customers()->sync([]);
        $repository->savedRecipes()->delete();
        /*
        $suppliers = $repository->suppliers;
        foreach($suppliers as $supplier){
            $su_ids[] = $supplier->id;
        }
        $repository->suppliers()->detach($su_ids);
        */
        $repository->suppliers()->sync([]);
        $repository->update([
            'cash_balance' => 0,
            'card_balance' => 0,
            'stc_balance' => 0,
            'balance' => 0,
        ]);
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => 0,
            'm_in_card_balance' => 0,
            'm_in_stc_balance' => 0,
            'd_out_cashier' => 0,
            'd_out_external' => 0,
        ]);
        $setting = $repository->setting;
        $setting->update([
            'invoices_count_today' => 0,
        ]);
        //return '?????? ?????????? ?????????? ??????????';
        return back()->with('success','???? ?????????? ?????????? ???????????? ??????????');
        //return '???????????? ?????? ?????????? ?????? (?????? ??????????????)';
    }

    public function resetInvociesCounter(){
        $settings = Setting::all();
        foreach($settings as $setting)
            $setting->update([
                'invoices_count_today' => 0 ,
            ]);
        return back()->with('success','?????? ?????????? ?????????? ???????? ???????????????? ??????????');
    }

    public function ourClients(){
        $users = User::orderBy('created_at','DESC')->paginate(20);
        $count = User::count();
        return view('dashboard.Repositories.our_clients')->with(['users'=>$users,'count'=>$count]);
    }

}

