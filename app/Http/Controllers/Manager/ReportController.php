<?php

namespace App\Http\Controllers\Manager;

use App\Customer;
use App\DailyReport;
use App\Encoding\Encode;
use App\Exports\DailyReportExport;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\MonthlyReport;
use App\PriceInvoice;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Prgayman\Zatca\Facades\Zatca;
use Prgayman\Zatca\Utilis\QrCodeOptions; // Optional

class ReportController extends Controller
{
   

    public function index($id){
        $repository = Repository::find($id);
        $invoices_count = $repository->invoices()->count();
        return view('manager.Reports.index')->with(['repository'=>$repository,'invoices_count'=>$invoices_count]);   
    }

    public function showInvoices($id){
        $repository = Repository::find($id);
        $invoices = $repository->invoicesDesc()->paginate(20);
        /*$re = $invoices->first();
        $re = unserialize($re->details);
        return $re;*/
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function invoiceDetails($uuid){
        $invoice = Invoice::where('uuid',$uuid)->first();
        $repository = $invoice->repository;
        $invoice_processes = $invoice->invoiceProcesses;
        return view('manager.Reports.invoice_details')->with(['repository'=>$repository,'invoice'=>$invoice,'invoice_processes'=>$invoice_processes]);
    }

    // post
    public function invoiceDetailsByLog(Request $request){
        $invoice = Invoice::find($request->inv);
        $repository = $invoice->repository;
        $invoice_processes = $invoice->invoiceProcesses;
        return view('manager.Reports.invoice_details')->with(['repository'=>$repository,'invoice'=>$invoice,'invoice_processes'=>$invoice_processes]);
    }

    public function printInvoice($uuid){
        //$invoice = Invoice::find($id);
        $invoice = Invoice::where('uuid',$uuid)->first();
        $repository = $invoice->repository;
        // Encode QRCode
        $encode = new Encode();
            if($invoice->status != 'retrieved'){
                $base64 = $encode->sellerName($repository->name)
                ->vatRegistrationNumber($invoice->tax_code)
                ->timestamp($invoice->created_at)
                ->totalWithVat($invoice->total_price)
                ->vatTotal($invoice->tax)
                ->toBase64();
            }
            else{     // retrieved invoice
                $base64 = $encode->sellerName($repository->name)
                ->vatRegistrationNumber($invoice->tax_code)
                ->timestamp($invoice->created_at)
                ->totalWithVat($invoice->total_price)
                ->vatTotal($invoice->tax)
                ->invoiceStatus('مسترجعة')
                ->toBase64();
            }
        if($repository->isSpecial()){
        // send recipe
        $recipe = unserialize($invoice->recipe);   // it was array in old version and now its a array of array so we will handle both way to display recipe in old version invoices
         // send new recipe sourced  NEW VERSION
         $re = array();
         if(count($recipe)<7){   // new version  array of arrays (impossible to have more than 6 recipes)
             // check if recipe values 0 so we dont print the recipe
             // send to printing just the valuable recipes
             for($i=0;$i<count($recipe);$i++){
            if(isset($r[$i]['ipd2'])){   // old version
             if($recipe[$i]['add_r']=='0' && $recipe[$i]['axis_r']=='0' && $recipe[$i]['cyl_r']=='0' && $recipe[$i]['sph_r']=='0' && $recipe[$i]['add_l']=='0' && $recipe[$i]['axis_l']=='0' && $recipe[$i]['cyl_l']=='0' && $recipe[$i]['sph_l']=='0' && $recipe[$i]['ipd']=='0' && $recipe[$i]['ipd2']=='0' )
                 continue;
            }
            else{
                if($recipe[$i]['add_r']=='0' && $recipe[$i]['axis_r']=='0' && $recipe[$i]['cyl_r']=='0' && $recipe[$i]['sph_r']=='0' && $recipe[$i]['add_l']=='0' && $recipe[$i]['axis_l']=='0' && $recipe[$i]['cyl_l']=='0' && $recipe[$i]['sph_l']=='0' && $recipe[$i]['ipd']=='0')
                 continue;
            }
             // insert dynamic users names by their ID's
                if(array_key_exists('recipe_source', $recipe[$i])){
                 $s1 = $recipe[$i]['recipe_source'];
                 if($s1 != 'customer'){
                     $employee = User::find($s1);
                     $recipe[$i]['recipe_source'] = $employee->name;
                 }
                 }
                 if(array_key_exists('ipd_source', $recipe[$i])){
                 $s2 = $recipe[$i]['ipd_source'];
                 if($s2 != 'customer'){
                     $employee = User::find($s2);
                     $recipe[$i]['ipd_source'] = $employee->name;
                 }
                }
                 $re[] = $recipe[$i]; // input array into array so we get array of arrays
             }
         }
        /*
        $recipe = array();
        if(count($r)<7){   // new version  array of arrays (impossible to have more than 6 recipes)
            // check if recipe values 0 so we dont print the recipe
            // send to printing just the valuable recipes
            for($i=0;$i<count($r);$i++){
            if($r[$i]['add_r']=='0' && $r[$i]['axis_r']=='0' && $r[$i]['cyl_r']=='0' && $r[$i]['sph_r']=='0' && $r[$i]['add_l']=='0' && $r[$i]['axis_l']=='0' && $r[$i]['cyl_l']=='0' && $r[$i]['sph_l']=='0' && $r[$i]['ipd']=='0' && $r[$i]['ipd2']=='0' )
                continue;
                $recipe[] = $r[$i]; // input array into array so we get array of arrays
            }
        }
        */
        else{   // old version
            $r[] = $recipe;
        }
       /*
        $dataToEncode = [
            [1, $repository->name],
            [2, $invoice->created_at],
            [3, $invoice->tax_code],
            [4, $invoice->tax],
            [5, $invoice->total_price]
        ];
        $__TLV = Encode::__getTLV($dataToEncode);
        return $__TLV;
        $qrcode = base64_encode($__TLV);
        */
         //return $qrcode;

        
            // result by zatca package
            /*
            $base64 = Zatca::sellerName($repository->name)
            ->vatRegistrationNumber($invoice->tax_code)
            ->timestamp($invoice->created_at)
            ->totalWithVat($invoice->total_price)
            ->vatTotal($invoice->tax)
            ->toBase64();
            */
            if($repository->setting->standard_printer) 
            return view('manager.Reports.print_invoice')->with(['repository'=>$repository,'invoice'=>$invoice,'recipe'=>$re,'qrcode'=>$base64]);
            else
            return view('manager.Sales.epson_recipe_data')->with(['repository'=>$repository,'invoice'=>$invoice,'recipe'=>$re,'qrcode'=>$base64]);
        }  // end of special
        else{  // basic repository
            if($repository->setting->standard_printer) 
            return view('manager.Reports.print_invoice')->with(['repository'=>$repository,'invoice'=>$invoice,'qrcode'=>$base64]);
            else
            return view('manager.Sales.epson_recipe_data')->with(['repository'=>$repository,'invoice'=>$invoice,'qrcode'=>$base64]);
        }
    }

    public function filterPending(Request $request,$id){
        $repository = Repository::find($id);
        if(!$request->filter)
            return back();
        if($request->filter == 'payed'){
        $invoices = $repository->invoices()->where('status','pending')
        ->whereRaw('total_price','cash_amount+card_amount+stc_amount')->orderBy('created_at','DESC')->paginate(20)->withQueryString();
        }
        elseif($request->filter == 'notpayed'){
            $invoices = $repository->invoices()->where('status','pending')
            ->whereRaw('total_price > cash_amount+card_amount+stc_amount')->orderBy('created_at','DESC')->paginate(20)->withQueryString();
        }
       // return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
       return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function showTodayInvoices($id){
        $repository = Repository::find($id);
        $invoices = $repository->dailyInvoices()->orderBy('created_at','DESC')->paginate(5);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function showMonthInvoices($id){  // show invoices of this month
        $repository = Repository::find($id);
        $invoices = $repository->monthlyInvoices()->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }
    
    public function searchInvoicesByDate(Request $request,$id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)->whereDate('created_at',$request->dateSearch)->paginate(10)->withQueryString();
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function searchInvoicesByCode(Request $request , $id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)->where('code',$request->code)->paginate(10)->withQueryString();
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function searchPending(Request $request , $id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)->where('status','pending')
        ->where(function($query) use ($request) {
            $query->where('phone','like', '%' . $request->search . '%')
                  ->orWhere('code', $request->search); })
                  ->orderBy('created_at','DESC')
        ->paginate(20)->withQueryString();
        //return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }
    public function viewCustomerInvoices(Request $request,$id){
        $customer = Customer::find($id);
        $repository = Repository::find($request->repo_id);
        $invoices = Invoice::where('repository_id',$repository->id)->where('customer_id',$customer->id)
        ->where('status','pending')
        ->whereRaw('total_price > cash_amount+card_amount+stc_amount')->paginate(20)->withQueryString();
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);  
    }
    /*public function dailyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->dailyReportsDesc()->paginate(1);
        return view('manager.Reports.daily_reports')->with('repository',$repository)->with('reports',$reports);
    }*/
    public function dailyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->dailyReportsDesc()->paginate(30);
        // retrieve current day invoices to display sales for current day in main page table
        $invoices = $repository->invoices()->where('daily_report_check',false)->doesntHave('dailyReports')->get();
        $purchases =  $repository->purchases()->where('daily_report_check',false)->doesntHave('dailyReports')->get(); // for current day
        return view('manager.Reports.daily_reports')->with(['repository'=>$repository,'reports'=>$reports,'invoices'=>$invoices,'purchases'=>$purchases]);
    }
    public function dailyReportDetails($id){
        $report = DailyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.daily_report_details')->with(['report' => $report,'repository'=>$repository]);
    }
    public function dailyPurchaseReportDetails($id){
        $report = DailyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.daily_purchase_report_details')->with(['report' => $report,'repository'=>$repository]);
    }
    public function reportDetailsCurrentDay($id){   // for current dynamic day (( not created report yet))
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->where('daily_report_check',false)->get();
        $purchases = $repository->purchases()->where('daily_report_check',false)->get();  //لعرض قيمة المشتريات حتى في تقرير المبيعات
        return view('manager.Reports.current_day_details')->with(['invoices'=>$invoices,'repository'=>$repository,'purchases'=>$purchases]);
    }
    public function reportPurchaseDetailsCurrentDay($id){   // for current dynamic day (( not created report yet))
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->where('daily_report_check',false)->get();
        return view('manager.Reports.current_purchase_day')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }
    /*public function makeMonthlyReport($id){
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // worker
        $invoices = $repository->invoices()->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->get();  // the invoices that will taken in monthly report
        $cash_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('cash_amount');
        $card_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('card_amount');
        $stc_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('stc_amount');
        
        $monthly_report = MonthlyReport::create([
            'repository_id' => $repository->id,
            'user_id' => $user->id,
            'cash_balance' => $cash_amount,
            'card_balance' => $card_amount,
            'stc_balance' => $stc_amount,
        ]);

        foreach($invoices as $invoice){
            $monthly_report->invoices()->attach($invoice->id);
            $invoice->update(
                [
                    'monthly_report_check' => true,
                ]
                );
        }
        return redirect()->route('view.monthly.reports',$repository->id)->with('success','تم انشاء تقرير شهري بنجاح'); 
    } */

    public function makeMonthlyReport($id){
        ini_set('max_execution_time', 500);
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // worker
        $invoices = $repository->invoices()->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->get();  // the invoices that will taken in monthly report
        $invoices = $repository->invoices()->where('monthly_report_check',false)
        ->get();
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
            'user_id' => $user->id,
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
        return redirect()->route('view.monthly.reports',$repository->id)->with('success',__('alerts.monthly_report_create_success')); 
    }
   /* public function viewMonthlyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->monthlyReports()->orderBy('created_at','DESC')->paginate(1);
        return view('manager.Reports.monthly_reports')->with(['repository'=>$repository,'reports'=>$reports]);
    } */
    public function viewMonthlyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->monthlyReports()->orderBy('created_at','DESC')->paginate(30);
        // retrieve current month invoices to display sales for current month in main page table
        $invoices = $repository->invoices()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        // retrieve current month purchases to display purchases for current month in main page table
        $purchases = $repository->purchases()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        return view('manager.Reports.monthly_reports')->with(['repository'=>$repository,'reports'=>$reports,'invoices' => $invoices,'purchases'=>$purchases]);
    }

    public function monthlyReportDetails($id){
        $report = MonthlyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.monthly_report_details')->with(['report' => $report,'repository'=>$repository]);
    }


    public function monthlyPurchaseReportDetails($id){
        $report = MonthlyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.purchase_monthly_report_details')->with(['report' => $report,'repository'=>$repository]);
    }

    public function reportDetailsCurrentMonth($id){   // for current dynamic month (( not created report yet))
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        $statistics = $repository->statistic;
        return view('manager.Reports.current_month_details')->with(['invoices'=>$invoices,'statistics'=>$statistics,'repository'=>$repository]);
    }

    public function purchaseReportDetailsCurrentMonth($id){
        //
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        //$statistics = $repository->statistic;
        return view('manager.Reports.purchase_current_month')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }

    public function printAdditionalRecipe($id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        // prepare to send data to print page
        // records
        $products = unserialize($invoice->details);
        $records = array(array());
        for($i=0;$i<count($products);$i++){   
         if(isset($products[$i]['barcode'])){
             if($products[$i]['quantity'] == $products[$i]['delivered'])
                 $del = 'نعم';
             else
                 $del = 'لا';
         $records[]=array('barcode'=>$products[$i]['barcode'],'name_ar'=>$products[$i]['name_ar'],'name_en'=>$products[$i]['name_en'],'cost_price'=>$products[$i]['cost_price'],'price'=>$products[$i]['price'],'quantity'=>$products[$i]['quantity'],'del'=>$del);
         }
       }
        // الوصفة الطبية
        $recipe = unserialize($invoice->recipe);
         // send new recipe sourced  NEW VERSION
         $re = array();
         if(count($recipe)<7){   // new version  array of arrays (impossible to have more than 6 recipes)
             // check if recipe values 0 so we dont print the recipe
             // send to printing just the valuable recipes
             for($i=0;$i<count($recipe);$i++){
             if($recipe[$i]['add_r']=='0' && $recipe[$i]['axis_r']=='0' && $recipe[$i]['cyl_r']=='0' && $recipe[$i]['sph_r']=='0' && $recipe[$i]['add_l']=='0' && $recipe[$i]['axis_l']=='0' && $recipe[$i]['cyl_l']=='0' && $recipe[$i]['sph_l']=='0' && $recipe[$i]['ipd']=='0' && $recipe[$i]['ipd2']=='0' )
                 continue;
             // insert dynamic users names by their ID's
             if(array_key_exists('recipe_source', $recipe[$i])){
                 $s1 = $recipe[$i]['recipe_source'];
                 if($s1 != 'customer'){
                     $employee = User::find($s1);
                     $recipe[$i]['recipe_source'] = $employee->name;
                 }
                }
                if(array_key_exists('ipd_source', $recipe[$i])){
                 $s2 = $recipe[$i]['ipd_source'];
                 if($s2 != 'customer'){
                     $employee = User::find($s2);
                     $recipe[$i]['ipd_source'] = $employee->name;
                 }
                }
                 $re[] = $recipe[$i]; // input array into array so we get array of arrays
             }
         }
        // customer
        $customer = $invoice->customer;
        // create barcode
        //$generator = new BarcodeGeneratorHTML();
        //$generator = new BarcodeGeneratorPNG();
        //$barcode = $generator->getBarcode($customer->phone, $generator::TYPE_CODE_128);
        //$barcode = base64_encode($generator->getBarcode($customer->phone, $generator::TYPE_CODE_128));

        return view('manager.Reports.print_additional_recipe')->with(['repository'=>$repository,'invoice'=>$invoice,'records'=>$records,'recipe'=>$re,'customer'=>$customer]);
    }

    public function exportDailyReport($id){
        $report = DailyReport::find($id);
        $repository = $report->repository;
        return Excel::download(new DailyReportExport($id) , $repository->name.'-daily-report.xlsx');
    }

    public function showPriceInvoices($id){
        $repository = Repository::find($id);
        $invoices = $repository->priceInvoices()->orderBy('created_at','DESC')->paginate(15);
        return view('manager.Reports.price_invoices',['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function priceInvoiceDetails($id){
        $invoice = PriceInvoice::where('uuid',$id)->first();
        $repository = $invoice->repository;
        return view('manager.Reports.price_invoice_details')->with(['repository'=>$repository,'invoice'=>$invoice]);
    }

    public function printPriceInvoice($id){
        $invoice = PriceInvoice::where('uuid',$id)->first();
        $repository = $invoice->repository;
        return view('manager.Reports.print_price_invoice')->with(['repository'=>$repository,'invoice'=>$invoice]);
    }
}
