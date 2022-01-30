<?php

namespace App\Http\Controllers\Manager;

use App\DailyReport;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Purchase;
use App\Repository;
use App\User;
use App\Record;
use App\Action;
use App\Mail\DailyReport as MailDailyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class CashierController extends Controller
{
    //

    /*public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Cashier.index')->with(['repositories'=>$repositories]);    
    }*/

    public function index($id){
        $repository = Repository::find($id);
        return view('manager.Cashier.index')->with(['repository'=>$repository]);    
    }

    public function dailyCashierForm($id){
        $repository = Repository::find($id);
        return view('manager.Cashier.daily_cashier')->with('repository',$repository);
    }

    public function submitCashier(Request $request , $id){
        ini_set('max_execution_time', 500);
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // cashier worker
        $new = true;   // تحدد اذا كان التقرير منشأ او مدمج مع تقرير قديم منذ اقل من ساعتين
        if(!$request->cashNeg)
        $request->cashNeg = 0;
        if(!$request->cardNeg)
        $request->cardNeg = 0;
        if(!$request->stcNeg)
        $request->stcNeg = 0;
        if(!$request->cashPos)
        $request->cashPos = 0;
        if(!$request->cardPos)
        $request->cardPos = 0;
        if(!$request->stcPos)
        $request->stcPos = 0;
        // money out taken by statistics table
        $out_cashier = $repository->statistic->d_out_cashier;
        $out_external = $repository->statistic->d_out_external;

        // we will check if the last daily report submitted by less than two hours so we add this report details to the latest report and dont make new daily report
        $dailyReport = $repository->dailyReports->last();
        if($dailyReport){
        $now = now();
        $created_at = $dailyReport->created_at;
        $hours = $now->diffInHours($created_at);   // the number of hours between last daily report and NOW
        if($hours < 2){  
             $dailyReport->update([
                'user_id' => $user->id,
                'cash_balance' => $dailyReport->cash_balance + $request->cash_balance,
                'card_balance' => $dailyReport->card_balance + $request->card_balance,
                'stc_balance' => $dailyReport->stc_balance + $request->stc_balance,
                'cash_shortage' => $dailyReport->cash_shortage + $request->cashNeg,
                'card_shortage' => $dailyReport->card_shortage + $request->cardNeg,
                'stc_shortage' => $dailyReport->stc_shortage + $request->stcNeg,
                'cash_plus' => $dailyReport->cash_plus + $request->cashPos,
                'card_plus' => $dailyReport->card_plus + $request->cardPos,
                'stc_plus' => $dailyReport->stc_plus + $request->stcPos,
                'out_cashier' => $dailyReport->out_cashier + $out_cashier,
                'out_external' => $dailyReport->out_external + $out_external,
                'box_balance' => $repository->balance,
            ]);
            $new = false;
        }
        else{
            $dailyReport = DailyReport::create(
                [
                    'repository_id' => $repository->id,
                    'user_id' => $user->id,
                    'cash_balance' => $request->cash_balance,
                    'card_balance' => $request->card_balance,
                    'stc_balance' => $request->stc_balance,
                    'cash_shortage' => $request->cashNeg,
                    'card_shortage' => $request->cardNeg,
                    'stc_shortage' => $request->stcNeg,
                    'cash_plus' => $request->cashPos,
                    'card_plus' => $request->cardPos,
                    'stc_plus' => $request->stcPos,
                    'out_cashier' => $out_cashier,
                    'out_external' => $out_external,
                    'box_balance' => $repository->balance,
                ]
                );
        }
        }
        else{
        $dailyReport = DailyReport::create(
            [
                'repository_id' => $repository->id,
                'user_id' => $user->id,
                'cash_balance' => $request->cash_balance,
                'card_balance' => $request->card_balance,
                'stc_balance' => $request->stc_balance,
                'cash_shortage' => $request->cashNeg,
                'card_shortage' => $request->cardNeg,
                'stc_shortage' => $request->stcNeg,
                'cash_plus' => $request->cashPos,
                'card_plus' => $request->cardPos,
                'stc_plus' => $request->stcPos,
                'out_cashier' => $out_cashier,
                'out_external' => $out_external,
                'box_balance' => $repository->balance,
            ]
            );
        }
            // all invoices not taked by DailyReport Yet..
        $invoices = Invoice::where('repository_id',$repository->id)->where('daily_report_check',false)->get();
        
        /* ------ */
        
        // take the invoices that we want use today sales in whatsapp message before (attach)
        $whatsapp_invoices = $repository->invoices()->where('status','!=','retrieved')->
        where('status','!=','deleted')->where('daily_report_check',false)
        ->doesntHave('dailyReports')->get();
        $today_sales = 0 ;
        $today_purchase = 0 ;
        foreach($whatsapp_invoices as $whatsapp_invoice){
            $today_sales += $whatsapp_invoice->total_price;
        }
        $whatsapp_purchases = $repository->purchases()->where('status','!=','retrieved')->where('daily_report_check',false)->doesntHave('dailyReports')->get();
        foreach($whatsapp_purchases as $pur){
            $today_purchase += $pur->total_price;
        }
            /*-----*/
        foreach($invoices as $invoice){
        $dailyReport->invoices()->attach($invoice->id);
        $invoice->update(
            [
                'daily_report_check' => true,
            ]
            );
        }
        // withdraw all the money in the safe
        $repository->update(
            [
                'cash_balance' => 0,
                'card_balance' => 0,
                'stc_balance' => 0,
            ]
            );

        // make the daily_report for the Purchases ((attach))
        $purchases = Purchase::where('repository_id',$repository->id)->where('daily_report_check',false)->get();
        foreach($purchases as $purchase){
            $dailyReport->purchases()->attach($purchase->id);
            $purchase->timestamps = false;
            $purchase->daily_report_check = true;
            $purchase->save();
            /*
            $purchase->update(
                [
                    'daily_report_check' => true,
                ]
                );
            */

            }
        // withdraw the daily out money from statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'd_out_cashier' => 0,
            'd_out_external' => 0,
        ]);

        // update cashier_reminder
        /*
        if($new){
            $setting = $repository->setting;
            $start = '00:00';
            $end = '11:59';
            if(now()->between($start, $end)){   // AM
                $close_time = Carbon::create(now()->year,now()->month,now()->day,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            else{      // PM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+1,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            $cashier_reminder = $close_time->addHours(6);
            $setting->update([
                'cashier_reminder' => $cashier_reminder,
            ]);
        }
        */
        // Update Cashier Warning
        if($new){
            $setting = $repository->setting;
            $daily_report_date = $dailyReport->created_at;
            $close_time_object = Carbon::create(now()->year,now()->month,now()->day,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);   // to convert time to dateTime to can use the method between
            $start = '00:00';
            $end = '11:59';
            if($close_time_object->between($start, $end) && $daily_report_date->between($start, $end)){   // Both AM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+1,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            elseif($close_time_object->between($start, $end) && !$daily_report_date->between($start, $end)){   // close time AM and daily_report is PM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+2,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            elseif(!$close_time_object->between($start, $end) && $daily_report_date->between($start, $end)){   // close time PM and daily_report is AM
                $close_time = Carbon::create(now()->year,now()->month,now()->day,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            else{   // Both PM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+1,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            $cashier_reminder = $close_time->addHours(6);
            $setting->update([
                'cashier_reminder' => $cashier_reminder,
            ]);
        }
        /*
        // send whatsapp notification
        $sid =   env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        // get the owner phone number
        $owner = User::whereHas('repositories', function ($query) use ($repository) {
            $query->where('repositories.id',$repository->id);
        })->role('مالك-مخزن')->first();
        $phone_number = $owner->phone;
        $note = ' تم اغلاق الكاشير في متجرك '.$repository->name.' فرع '.$repository->address.' | بتاريخ '.$dailyReport->updated_at.' | موظف الاغلاق '.$user->name.' | باجمالي مبيعات '.$today_sales.' | ومشتريات '.$today_purchase;
        $message = $twilio->messages
                  ->create("whatsapp:$phone_number", // to
                           [
                               "from" => "whatsapp:+14155238886",
                               "body" => $note,
                           ]
                  );
        */

            $action = Action::where('name_ar','اغلاق الكاشير')->first();
            $info = array('target'=>'cashier','id'=>$dailyReport->id);
            Record::create([
                'repository_id' => $repository->id,
                'user_id' => Auth::user()->id,
                'action_id' => $action->id,
                'note' => serialize($info),
            ]);

            /*
            $owner_details = $repository->owner_details();
            $close_date = now();
            $details = array('repository'=>$repository,'daily_report'=>$dailyReport,'owner'=>$owner_details,'today_sales'=>$today_sales,'today_purchases'=>$today_purchase,'close_date'=>$close_date);
            Mail::to($owner_details->email)->send(new MailDailyReport($details));
            */

            // Send Mail notification
            /*
            $users = $repository->users;
            $close_date = now();
            foreach($users as $user){
                if($user->can('اشعار ايميل باغلاق الكاشير')){
                    $details = array('repository'=>$repository,'daily_report'=>$dailyReport,'user'=>$user,'today_sales'=>$today_sales,'today_purchases'=>$today_purchase,'close_date'=>$close_date);
                    Mail::to($user->email)->send(new MailDailyReport($details));
                }
            }
            */
            //return redirect()->route('cashier.index', ['success' => 'تم إغلاق الكاشير اليومي بنجاح']);
            return redirect()->route('daily.reports.index',$repository->id)->with('success',__('alerts.cashier_closed_success'));
        }

        public function warning($id){
            $repository = Repository::find($id);
            $warning = $repository->CashierWarningDetails(); 
            return view('manager.Cashier.warning')->with(['repository'=>$repository,'warning'=>$warning]);
        }

        public function dailyCashierWarningForm($id){
            $repository = Repository::find($id);
            return view('manager.Cashier.daily_cashier_warning')->with('repository',$repository);
        }

        public function withdraw(Request $request , $id){
            $repository = Repository::find($id);
            if($repository->balance<$request->money)
                return back()->with('fail',__('alerts.money_withdraw_bigger_than_in_cashier'));
            $repository->update([
                'balance' => $repository->balance - $request->money,
            ]);
            $action = Action::where('name_ar','سحب اموال من الصندوق')->first();
            $info = array('target'=>'cashier','amount'=>$request->money);
            Record::create([
                'repository_id' => $repository->id,
                'user_id' => Auth::user()->id,
                'action_id' => $action->id,
                'note' => serialize($info),
            ]);
            return back()->with('success',__('alerts.withdraw_success').$request->money);
        }

        public function deposite(Request $request , $id){
            $repository = Repository::find($id);
            $repository->update([
                'balance' => $repository->balance + $request->money,
            ]);
            // register record of this process
        $action = Action::where('name_ar','اضافة اموال الى الصندوق')->first();
        $info = array('target'=>'cashier','amount'=>$request->money);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        /*
        Log::info('اضافة اموال الى الصندوق',['amount'=>$money]);
        */
            return back()->with('success',__('alerts.deposite_success').$request->money);
        }

        public function cashierReminder($id){
            $repository = Repository::find($id);
            $daily_report = $repository->dailyReports->last();
            return view('manager.Cashier.daily_cashier_warning')->with(['repository'=>$repository,'daily_report'=>$daily_report]);
        }

        public function ignoreCashierReminder($id){
            $repository = Repository::find($id);
            $setting = $repository->setting;
            //$cashier_reminder = $setting->cashier_reminder->addDay();
            $close_time_object = Carbon::create(now()->year,now()->month,now()->day,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);   // to convert time to dateTime to can use the method between
            $start = '00:00';
            $end = '11:59';
            if($close_time_object->between($start, $end) && now()->between($start, $end)){   // BOTH AM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+1,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            elseif($close_time_object->between($start, $end) && !now()->between($start, $end)){   // close time AM and now is PM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+2,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            elseif(!$close_time_object->between($start, $end) && now()->between($start, $end)){   // close time PM and now is AM
                $close_time = Carbon::create(now()->year,now()->month,now()->day,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            else{   // Both PM
                $close_time = Carbon::create(now()->year,now()->month,now()->day+1,substr($repository->close_time, 0, 2),substr($repository->close_time, 3, 2),0);
            }
            $cashier_reminder = $close_time->addHours(6);
            $setting->update([
                'cashier_reminder' => $cashier_reminder,
            ]);
            return redirect(route('in.repository',$id));
        }

        public function dailyCashierFormFromWarning($id){
            $repository = Repository::find($id);
            return view('manager.Cashier.day_cashier_from_warning')->with('repository',$repository);
        }
}
