<?php

namespace App\Http\Controllers\Manager;

use App\Action;
use App\DailyReport;
use App\Export;
use App\Http\Controllers\Controller;
use App\MonthlyReport;
use App\Product;
use App\Purchase;
use App\PurchaseProcess;
use App\PurchaseProduct;
use App\PurchaseRecord;
use App\Record;
use App\Repository;
use App\Supplier;
use App\Type;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;
use Webpatser\Uuid\Uuid;

class PurchaseController extends Controller
{
    //
    public function index($id){
        $repository = Repository::find($id);
        return view('manager.Purchases.index')->with(['repository'=>$repository]);    
    }

  

    public function add(Request $request,$id){
        Session::put('lock_process','start');
        $repository = Repository::find($id);
        // code generate
        do{
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $code = '';
            for ($i = 0; $i < 8; $i++)
            $code .= $characters[rand(0, $charactersLength - 1)];
            // check if code exist in this repository before
            $purchase = Purchase::where('repository_id',$repository->id)->where('code',$code)->first();
            }
            while($purchase);   // if the code exists before we generate new code
            //$suppliers = $repository->suppliers;
            $suppliers = Supplier::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->get();
            $custom_date = false;
            if($request->old){
                $custom_date = true;
            }
            return view('manager.Purchases.add')->with(['repository'=>$repository,'code'=>$code,'suppliers'=>$suppliers,'custom_date'=>$custom_date]);
    }

    public function addSupplier($id){
        $repository = Repository::find($id);
        return view('manager.Purchases.add_supplier')->with(['repository'=>$repository]);
    }

    public function storeSupplier(Request $request,$id){
        $repository = Repository::find($id);
        $supplier = Supplier::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'account_num' => $request->account_num,
        ]);
        $repository->suppliers()->attach($supplier->id);  // pivot table
        // register record of this process
        $action = Action::where('name_ar','اضافة مورد')->first();
        $info = array('target'=>'supplier','id'=>$supplier->id);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        return redirect(route('purchases.index',$repository->id))->with('success',__('alerts.add_supplier_success'));
    }

    public function showSuppliers($id){
        $repository = Repository::find($id);
        $suppliers = $repository->suppliers()->paginate(20);
        return view('manager.Purchases.show_suppliers')->with(['repository'=>$repository,'suppliers'=>$suppliers]);
    }

    public function editSupplierForm(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $repository = Repository::find($request->repository_id); // i need repo in next page
        return view('manager.Purchases.edit_supplier')->with(['supplier'=>$supplier,'repository'=>$repository]);
    }

    public function updateSupplier(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $repository = Repository::find(Session::get('repo_id'));
        $supplier->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'account_num' => $request->account_num,
        ]);
        // register record of this process
        $action = Action::where('name_ar','تعديل مورد')->first();
        $info = array('target'=>'supplier','id'=>$supplier->id);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        return redirect(route('purchases.index',$repository->id))->with('success',__('alerts.edit_supplier_success'));
    }

    public function deleteSupplier(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $repository = Repository::find(Session::get('repo_id'));
        $supplier->delete();
        return redirect(route('purchases.index',$repository->id))->with('success',__('alerts.delete_supplier_success'));
    }

   /* public function storePurchase(Request $request , $id){

        $validated = $request->validate([
            'supplier_id' => 'required',
        ]);

        $repository = Repository::find($id);
        $statistic = $repository->statistic;
        if($request->pay=='later')
            $payment = 'later';
        else // cash has two options
            {
                if($request->cash_option=='cashier'){
                    $payment = 'cashier';
                    $repository->update([
                    'balance' => $repository->balance - $request->sum,
                    ]);
                    $statistic->update([
                        'd_out_cashier' => $statistic->d_out_cashier + $request->sum,
                    ]);
                }
                else{
                    $payment = 'external';
                    $statistic->update([
                        'd_out_external' => $statistic->d_out_external + $request->sum,
                    ]);
                    }
            }
        $purchase = Purchase::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::id(),
            'supplier_id' => $request->supplier_id,
            'code' => $request->code,
            'supplier_invoice_num' => $request->supplier_invoice_num,
            'total_price' => $request->sum,
            'payment' =>  $payment,
            'daily_report_check' => false,
            'monthly_report_check' => false,
        ]);
        $count = count($request->barcode);
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){  // record exist (inserted)
                 PurchaseRecord::create([
                    'purchase_id' => $purchase->id,
                    'barcode' => $request->barcode[$i],
                    'name' => $request->name[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i],
                ]);
            }
        }
        return back()->with('success',__('alerts.create_new_purchase_success'));
    }  */

     public function storePurchase(Request $request , $id){
        $rules = [
            'supplier_id' => 'required',
        ];
    
        $customMessages = [
            'required' => __('settings.must_select_supplier'),
        ];
    
        $this->validate($request, $rules, $customMessages);
        //  variable will check if the invoice has all false barcodes so we dont create it
        $actual_records = 0;
        $repository = Repository::find($id);
        $statistic = $repository->statistic;
        $pay_amount = 0 ;
        if($request->pay=='later'){
            $payment = 'later' ;
            $status = 'later' ;
        }
        else // cash has two options
            {
                if($request->cash_option=='cashier'){
                    if($request->cash_value > $repository->balance)
                        return back()->with('fail','المبلغ المدفوع اكبر من المتوفر في الصندوق');
                    if($request->cash_value > $request->sum){
                        return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                    }
                    $payment = 'cashier';
                    if($request->cash_value < $request->sum)
                        $status = 'pending';
                    else
                        $status = 'done';
                    $repository->update([
                    'balance' => $repository->balance - $request->cash_value,
                    ]);
                    $statistic->update([
                        'd_out_cashier' => $statistic->d_out_cashier + $request->cash_value,
                    ]);
                    $pay_amount = $request->cash_value;
                }
                else{
                    $payment = 'external';
                    if($request->external_value > $request->sum){
                        return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                    }
                    if($request->external_value < $request->sum)
                        $status = 'pending';
                    else
                        $status = 'done';
                    $statistic->update([
                        'd_out_external' => $statistic->d_out_external + $request->external_value,
                    ]);
                    $pay_amount = $request->external_value;
                    }
            }
        $purchase = Purchase::create([
            'uuid' => Uuid::generate(4),
            'repository_id' => $repository->id,
            'user_id' => Auth::id(),
            'supplier_id' => $request->supplier_id,
            'code' => $request->code,
            'supplier_invoice_num' => $request->supplier_invoice_num,
            'pay_amount' => $pay_amount,
            'total_price' => $request->sum,
            'payment' =>  $payment,
            'status' =>  $status,
            'daily_report_check' => false,
            'monthly_report_check' => false,
        ]);
        $count = count($request->barcode);
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){  // record exist (inserted)
                $product = PurchaseProduct::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->first();
                if($product)  // the barcode is right
                {   
                    PurchaseRecord::create([
                        'purchase_id' => $purchase->id,
                        'barcode' => $request->barcode[$i],
                        'name' => $request->name[$i],
                        'quantity' => $request->quantity[$i],
                        'price' => $request->price[$i],
                    ]);
                    // editing the price of stored product
                    $product->update([
                        'price' => $request->price[$i],
                    ]);
                    // check if the product sending to the stock or Not
                    if($product->store_in_stock){   // yes sending to the stock
                        $stock_product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->first();
                        if($stock_product){
                            if($stock_product->stored)
                                $stock_product->update([
                                    'quantity' => $stock_product->quantity + $request->quantity[$i],
                                ]);
                        }
                        else{    // not exist so we create new stock product
                            $type = Type::first();
                            Product::create([
                                'repository_id'=>$repository->id,
                                'type_id'=>$type->id,
                                'barcode' => $request->barcode[$i],
                                'name_ar'=>$request->name[$i],
                                'quantity'=>$request->quantity[$i],
                                'cost_price'=>0,
                                'price'=>$request->price[$i],
                                'accept_min' => false,
                                'stored' => true,
                            ]);
                        }
                    }
                }
            }
        }

        // register record of this process
        $action = Action::where('name_ar','انشاء فاتورة مشتريات')->first();
        $info = array('target'=>'purchase','id'=>$purchase->id,'code'=>$purchase->code);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        session()->forget('lock_process');

        return back()->with('success',__('alerts.create_new_purchase_success'));
    }  

    public function storeOldPurchase(Request $request , $id){

        $rules = [
            'supplier_id' => 'required',
            'date' => 'required',
        ];
    
        $customMessages = [
            'supplier_id.required' => __('settings.must_select_supplier'),
            'date.required' => 'عليك اختيار التاريخ',
        ];
    
        $this->validate($request, $rules, $customMessages);
        //  variable will check if the invoice has all false barcodes so we dont create it
        $actual_records = 0;
        $repository = Repository::find($id);
        $statistic = $repository->statistic;
        $pay_amount = 0 ;
        // cant input future invoices or today invoices
        $my_date = Carbon::parse($request->date);
        if($my_date->year > now()->year || ($my_date->year == now()->year && $my_date->month > now()->month) || ($my_date->year == now()->year && $my_date->month == now()->month && $my_date->day >= now()->day)){
            return back()->with('fail','التاريخ المدخل يجب أن يكون قديم');
        }
        $daily_report_check = true;
        $monthly_report_check = true;
        if($request->date){   // register old invoice form
            $input_date = new DateTime();
            $input_date = date("Y-m", strtotime($request->date));
            if ($input_date === now()->format('Y-m'))  // IMPORTANT
                $monthly_report_check = false;              
            if(!$request->old_purchase)
                $daily_report_check = false;
        }
        
        if($request->pay=='later'){
            $payment = 'later';
            $status = 'later' ;
        }
        else // cash has two options
            {
                if($request->cash_option=='cashier'){
                    $pay_amount = $request->cash_value;
                    if($request->cash_value > $request->sum){
                        return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                    }
                    $payment = 'cashier';
                    if($request->cash_value < $request->sum)
                    $status = 'pending';
                    else
                    $status = 'done';
                    if(!$daily_report_check){
                        if($request->cash_value > $repository->balance)
                            return back()->with('fail','المبلغ المدفوع اكبر من المتوفر في الصندوق');
                        $repository->update([
                            'balance' => $repository->balance - $request->cash_value,
                            ]);
                            $statistic->update([
                                'd_out_cashier' => $statistic->d_out_cashier + $request->cash_value,
                            ]);
                    }
                }
                else{
                    $pay_amount = $request->external_value;
                    $payment = 'external';
                    if($request->external_value < $request->sum)
                        $status = 'pending';
                    else
                        $status = 'done';
                    if(!$daily_report_check)
                            $statistic->update([
                                'd_out_external' => $statistic->d_out_external + $request->external_value,
                            ]);
                }
            }

            $purchase = new Purchase();
            $purchase->timestamps = false;   // temporary insert custom timestamps values
            $purchase->uuid = Uuid::generate(4);
            $purchase->repository_id = $repository->id;
            $purchase->user_id = Auth::id();
            $purchase->supplier_id = $request->supplier_id;
            $purchase->code = $request->code;
            $purchase->supplier_invoice_num = $request->supplier_invoice_num;
            $purchase->total_price = $request->sum;
            $purchase->payment = $payment;
            $purchase->status = $status;
            $purchase->pay_amount = $pay_amount;
            $purchase->daily_report_check = $daily_report_check;
            $purchase->monthly_report_check = $monthly_report_check;
            $purchase->created_at = $request->date;
            $purchase->updated_at = $request->date;
            $purchase->save();

            if($monthly_report_check == true){     // مأخوذة في شهر سابق لذلك علينا  اضافة هذه الفاتورة مع التقرير القديم
                // get the monthly report
                $temp_date = new DateTime();
                $temp_date = date("Y-m-d H:i:s", strtotime($request->date));
                $temp_date = Carbon::createFromFormat('Y-m-d H:i:s', $temp_date);
                //return $input_date->year;
                $report = MonthlyReport::where('repository_id',$repository->id)->whereYear('created_at', '=', $temp_date->year)
                    ->whereMonth('created_at','=',$temp_date->month)->first();
                if($report){
                    if($purchase->payment == 'cashier')
                        $report->update([
                            'out_cashier' => $report->out_cashier + $purchase->pay_amount,
                        ]);
                    elseif($purchase->payment == 'external')
                        $report->update([
                            'out_external' => $report->out_external + $purchase->pay_amount,
                        ]);
                $report->purchases()->attach($purchase->id);
                }
                else{  // لا يوجد تقرير شهري يوافق تاريخ الفاتورة فسننشئ تقرير شهري لنفس شهر الفاتورة وننسبها له
                    $user_id = Auth::id();
                    $temp_date2 = new DateTime();
                    $temp_date2 = date("Y-m-d H:i:s", strtotime($request->date));
                    $temp_date2 = Carbon::createFromFormat('Y-m-d H:i:s', $temp_date2);            
                    $report_date =    \Carbon\Carbon::parse($temp_date2)->endOfMonth();
                    $rep = new MonthlyReport();
                    $rep->timestamps = false;   // temporary insert custom timestamps values
                    $rep->repository_id = $repository->id;
                    $rep->user_id = $user_id;
                    $rep->cash_balance = 0;
                    $rep->card_balance = 0;
                    $rep->stc_balance = 0;
                    if($purchase->payment == 'cashier'){
                        $rep->out_cashier = $purchase->pay_amount;
                        $rep->out_external = 0;
                    }
                    elseif($purchase->payment == 'external'){
                        $rep->out_cashier = 0;
                        $rep->out_external = $purchase->pay_amount;
                    }
                    else{ // later
                        $rep->out_cashier = 0;
                        $rep->out_external = 0;
                    }
                    $rep->created_at = $report_date;
                    $rep->updated_at = $report_date;
                    $rep->save();
                    $rep->purchases()->attach($purchase->id);
                }
            }

            // check for dailyreports
            if($daily_report_check == true){ 
                $temp_date3 = new DateTime();
                $temp_date3 = date("Y-m-d H:i:s", strtotime($request->date));
                $temp_date3 = Carbon::createFromFormat('Y-m-d H:i:s', $temp_date3);
                //return $input_date->year;
                $day_report = DailyReport::where('repository_id',$repository->id)->whereYear('created_at', '=', $temp_date3->year)
                    ->whereMonth('created_at','=',$temp_date3->month)->whereDay('created_at','=',$temp_date3->day)->first();
                if($day_report){
                    $day_report->purchases()->attach($purchase->id);
                }
                else{  // لا يوجد تقرير يومي يوافق تاريخ الفاتورة فسننشئ تقرير يومي شكلي لنفس يوم الفاتورة وننسبها له
                    $user_id = Auth::id();
                    $temp_date4 = new DateTime();
                    $temp_date4 = date("Y-m-d H:i:s", strtotime($request->date));
                    $temp_date4 = Carbon::createFromFormat('Y-m-d H:i:s', $temp_date4);            
                    $report_date =    \Carbon\Carbon::parse($temp_date4)->endOfDay();
                    $rep = new DailyReport();
                    $rep->timestamps = false;   // temporary insert custom timestamps values
                    $rep->repository_id = $repository->id;
                    $rep->user_id = $user_id;
                    $rep->cash_balance = 0;
                    $rep->card_balance = 0;
                    $rep->stc_balance = 0;
                    $rep->cash_shortage = 0;
                    $rep->card_shortage = 0;
                    $rep->stc_shortage = 0;
                    $rep->cash_plus = 0;
                    $rep->card_plus = 0;
                    $rep->stc_plus = 0;
                    if($purchase->payment == 'cashier'){
                        $rep->out_cashier = $purchase->pay_amount;
                        $rep->out_external = 0;
                    }
                    elseif($purchase->payment == 'external'){
                        $rep->out_cashier = 0;
                        $rep->out_external = $purchase->pay_amount;
                    }
                    else{ // later
                        $rep->out_cashier = 0;
                        $rep->out_external = 0;
                    }
                    $rep->box_balance = 0;
                    $rep->created_at = $report_date;
                    $rep->updated_at = $report_date;
                    $rep->save();
                    $rep->purchases()->attach($purchase->id);
                }
            }
       
        $count = count($request->barcode);
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){  // record exist (inserted)
                $product = PurchaseProduct::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->first();
                if($product)  // the barcode is right
                {   
                    PurchaseRecord::create([
                        'purchase_id' => $purchase->id,
                        'barcode' => $request->barcode[$i],
                        'name' => $request->name[$i],
                        'quantity' => $request->quantity[$i],
                        'price' => $request->price[$i],
                    ]);
                   
                }
            }
        }
        // register record of this process
        $action = Action::where('name_ar','تسجيل فاتورة مشتريات بتاريخ محدد')->first();
        $info = array('target'=>'purchase','id'=>$purchase->id,'code'=>$purchase->code);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        session()->forget('lock_process');

        return back()->with('success',__('alerts.create_new_purchase_success'));
    }
    


    public function showPurchases($id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->orderBy('updated_at','DESC')->paginate(10);
        $suppliers = $repository->suppliers;
        return view('manager.Purchases.show_purchases')->with(['repository'=>$repository,'purchases'=>$purchases,'suppliers'=>$suppliers]);
    }

    public function showPurchaseDetails($uuid){
        //$purchase = Purchase::find($id);
        $purchase = Purchase::where('uuid',$uuid)->first();
        $repository = Repository::find(Session::get('repo_id'));
        $purchase_processes = $purchase->purchaseProcesses;
        return view('manager.Purchases.purchase_details')->with(['purchase'=>$purchase,'repository'=>$repository,'purchase_processes'=>$purchase_processes]);
    }

    // post for activity log
    public function showPurchaseDetailsByLog(Request $request){
        //$purchase = Purchase::find($id);
        $purchase = Purchase::find($request->inv);
        $repository = Repository::find(Session::get('repo_id'));
        return view('manager.Purchases.purchase_details')->with(['purchase'=>$purchase,'repository'=>$repository]);
    }

    /*public function showPurchaseRetrieveDetails($id){
        $purchase = Purchase::find($id);
        $retrieve = true;
        return view('manager.Purchases.purchase_details')->with(['purchase'=>$purchase,'retrieve'=>$retrieve]);
    }*/

    public function productsForm($id){
        $repository = Repository::find($id);
        return view('manager.Purchases.products_form')->with(['repository'=>$repository]);
    }

    public function storeProducts(Request $request , $id){
        $repository = Repository::find($id);
        $totalPrice=0;
        $count = count($request->barcode);    // number of records
        for($i=0;$i<$count;$i++){
            $stored_in_stock = false;
            if($request->barcode[$i]){
             // query to check if product exist so we update the quantity column or if not we create new record
            $product = PurchaseProduct::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->first();
            if($request->stored){   // because null fire an exception
                if(in_array($i,$request->stored)){ // stored
                    $stored_in_stock = true;
                }
            }
            if($product)  // found it
            {
            $new_price = $request->price[$i];
            $product->update([
                'price' => $new_price,
                'store_in_stock' => $stored_in_stock,
            ]);
            $totalPrice+=$request->price[$i];
            }
        else{
            PurchaseProduct::create(
                [
                    'repository_id'=>$repository->id,
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'price'=>$request->price[$i],
                    'store_in_stock' => $stored_in_stock,
                ]
                );
                $totalPrice+=$request->price[$i];
        }
    }
        }
        // register record of this process
        $action = Action::where('name_ar','اضافة منتج مشتريات')->first();
        $info = array('target'=>'purchase_product','total_price'=>$totalPrice);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        return back()->with('success',__('alerts.add_success'));
    }

    public function getProductAjax($repo_id,$barcode){
        $product = PurchaseProduct::where('repository_id',$repo_id)->where('barcode',$barcode)->first(); // first record test
        if($product)
        return response($product);
        else
        return response('no_data');
    }
    /*public function showLaterPurchases($id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->where('payment','later')->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Purchases.later_purchases')->with(['repository'=>$repository,'purchases'=>$purchases]);
    }*/
    public function showLaterPurchases($id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->where(function($query){
            $query->where('status','pending')
                  ->orWhere('status','later');
        })->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Purchases.show_purchases')->with(['repository'=>$repository,'purchases'=>$purchases]);
    }

    public function payLaterPurchase(Request $request , $id){
        $purchase = Purchase::find($id);
        $repository = $purchase->repository;
        $statistic = $repository->statistic;
        switch ($request->input('action')) {
            case 'pay_later':    // دفع فاتورة آجلة
                    // check if purchase payment is later to continue
                    if($purchase->payment != 'later')
                        return back();
                    $pay_amount = 0 ;
                    if($request->payment=='cashier'){
                        if($request->cash_value > $repository->balance)
                            return back()->with('fail','المبلغ المدفوع اكبر من المتوفر في الصندوق');
                        if($request->cash_value > $purchase->total_price)
                            return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                        if($request->cash_value < $purchase->total_price)
                            $status = 'pending' ;
                        else
                            $status = 'done' ;
                            $payment = 'cashier' ;
                            $repository->update([
                                'balance' => $repository->balance - $request->cash_value,
                            ]);
                        $statistic->update([
                            'd_out_cashier' => $statistic->d_out_cashier + $request->cash_value,
                        ]);
                        $pay_amount = $request->cash_value;
                    }
                    else{
                        if($request->external_value > $purchase->total_price)
                            return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                        $payment = 'external';
                        if($request->external_value < $purchase->total_price)
                            $status = 'pending' ;
                        else
                            $status = 'done' ;
                        $statistic->update([
                            'd_out_external' => $statistic->d_out_external + $request->external_value,
                        ]);
                        $pay_amount = $request->external_value;
                    }
                    /*
                    $purchase->update([
                        'payment' => $payment,
                        'daily_report_check' => false,
                        'monthly_report_check' => false,
                    ]);
                    */
                    PurchaseProcess::create([
                                        'repository_id' => $repository->id ,
                                        'purchase_id' => $purchase->id ,
                                        'user_id' => $purchase->user_id ,
                                        'pay_amount' => $purchase->pay_amount ,
                                        'total_price' => $purchase->total_price ,
                                        'payment' => $purchase->payment ,
                                        'status' => $purchase->status ,
                                        'daily_report_check' => $purchase->daily_report_check ,
                                        'monthly_report_check' => $purchase->monthly_report_check ,
                                        'created_at' => $purchase->created_at,   // and in pay_pending we take updated_at
                                        'transfered_at' => now(),
                    ]);

                    $purchase->update([
                        'user_id' => Auth::user()->id ,
                        'pay_amount' => $pay_amount ,
                        'payment' => $payment ,
                        'status' => $status ,
                        'daily_report_check' => false ,
                        'monthly_report_check' => false ,
                    ]);

                    // register record of this process
                    $action = Action::where('name_ar','دفع فاتورة مورد')->first();
                    $info = array('target'=>'purchase','id'=>$purchase->id,'code'=>$purchase->code);
                    Record::create([
                        'repository_id' => $repository->id,
                        'user_id' => Auth::user()->id,
                        'action_id' => $action->id,
                        'note' => serialize($info),
                    ]);
                    //return redirect(route('purchases.index'))->with('success',__('alerts.purchase_payed_success'));
                    return back()->with('success',__('alerts.purchase_payed_success'));
                    break;

                    case 'pay_pending':     // استكمال فاتورة مورد
                        // check if purchase payment is later to continue
                        if($purchase->status != 'pending')
                            return back();
                        $pay_amount = 0 ;
                        $all_processes_payments = 0;
                            foreach($purchase->purchaseProcesses as $process){
                                $all_processes_payments += $process->pay_amount;
                            }
                        $all_processes_payments += $purchase->pay_amount;
                        if($request->payment=='cashier'){
                            if($request->cash_value > $repository->balance)
                                return back()->with('fail','المبلغ المدفوع اكبر من المتوفر في الصندوق');
                            if($request->cash_value > ($purchase->total_price - $all_processes_payments))
                                return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                            if($request->cash_value < ($purchase->total_price - $all_processes_payments) )
                                $status = 'pending' ;
                            else
                                $status = 'done' ;
                                $payment = 'cashier' ;
                                $repository->update([
                                    'balance' => $repository->balance - $request->cash_value,
                                ]);
                            $statistic->update([
                                'd_out_cashier' => $statistic->d_out_cashier + $request->cash_value,
                            ]);
                            $pay_amount = $request->cash_value;
                        }
                        else{
                            if($request->external_value > ($purchase->total_price - $all_processes_payments))
                                return back()->with('fail','المبلغ المدفوع اكبر من قيمة الفاتورة');
                            $payment = 'external';
                            if($request->external_value < ($purchase->total_price - $all_processes_payments))
                                $status = 'pending' ;
                            else
                                $status = 'done' ;
                            $statistic->update([
                                'd_out_external' => $statistic->d_out_external + $request->external_value,
                            ]);
                            $pay_amount = $request->external_value;
                        }
                        /*
                        $purchase->update([
                            'payment' => $payment,
                            'daily_report_check' => false,
                            'monthly_report_check' => false,
                        ]);
                        */
                        PurchaseProcess::create([
                                            'repository_id' => $repository->id ,
                                            'purchase_id' => $purchase->id ,
                                            'user_id' => $purchase->user_id ,
                                            'pay_amount' => $purchase->pay_amount ,
                                            'total_price' => $purchase->total_price ,
                                            'payment' => $purchase->payment ,
                                            'status' => $purchase->status ,
                                            'daily_report_check' => $purchase->daily_report_check ,
                                            'monthly_report_check' => $purchase->monthly_report_check ,
                                            'created_at' => $purchase->updated_at,
                                            'transfered_at' => now(),
                        ]);

                        $purchase->update([
                            'user_id' => Auth::user()->id ,
                            'pay_amount' => $pay_amount ,
                            'payment' => $payment ,
                            'status' => $status ,
                            'daily_report_check' => false ,
                            'monthly_report_check' => false ,
                        ]);

                        // register record of this process
                        $action = Action::where('name_ar','دفع فاتورة مورد')->first();
                        $info = array('target'=>'purchase','id'=>$purchase->id,'code'=>$purchase->code);
                        Record::create([
                            'repository_id' => $repository->id,
                            'user_id' => Auth::user()->id,
                            'action_id' => $action->id,
                            'note' => serialize($info),
                        ]);
                        //return redirect(route('purchases.index'))->with('success',__('alerts.purchase_payed_success'));
                        return back()->with('success',__('alerts.purchase_payed_success'));
                        break;
                }
        }   

   
    public function retrieve($id){
        $purchase = Purchase::find($id);
        $repository = $purchase->repository;

        PurchaseProcess::create([
            'repository_id' => $repository->id ,
            'purchase_id' => $purchase->id ,
            'user_id' => $purchase->user_id ,
            'pay_amount' => $purchase->pay_amount ,
            'total_price' => $purchase->total_price ,
            'payment' => $purchase->payment ,
            'status' => $purchase->status ,
            'daily_report_check' => $purchase->daily_report_check ,
            'monthly_report_check' => $purchase->monthly_report_check ,
            'created_at' => $purchase->updated_at,
            'transfered_at' => now(),
        ]);
        $purchase->update([
            'user_id' => Auth::user()->id,
            'pay_amount' => 0 ,
            'status' => 'retrieved',
            'daily_report_check' => false,
            'monthly_report_check' => false,
        ]);
        //retrieve money if payment was by cashier
        /*
        if($purchase->payment == 'cashier')
        $repository->update([
            'balance' => $repository->balance + $purchase->total_price,
        ]);
        */
        if($purchase->purchaseProcesses->count() > 0){
                foreach($purchase->purchaseProcesses as $process){
                    if($process->payment == 'cashier')
                        $repository->update([
                            'balance' => $repository->balance + $process->pay_amount,
                        ]);
                }
                if($purchase->payment == 'cashier')
                        $repository->update([
                            'balance' => $repository->balance + $purchase->pay_amount,
                        ]);
        }
        else{
                if($purchase->payment == 'cashier')
                        $repository->update([
                            'balance' => $repository->balance + $purchase->pay_amount,
                        ]);
        }

        // register record of this process
        $action = Action::where('name_ar','استرجاع فاتورة مشتريات')->first();
        $info = array('target'=>'purchase','id'=>$purchase->id,'code'=>$purchase->code);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);

        return back()->with('success',__('alerts.purchase_retrieve_success'));
    }

    public function searchByDate(Request $request , $id){
        $repository = Repository::find($id);
        //$purchases = $repository->purchases()->whereDate('created_at',$request->dateSearch)->orWhereDate('updated_at',$request->dateSearch)->paginate(10);
        $purchases = $repository->purchases()->where(function ($query) use ($request){
            $query->whereDate('created_at',$request->dateSearch)
                  ->orWhereDate('updated_at',$request->dateSearch); })->paginate(10);
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }

    public function search(Request $request , $id){
        $repository = Repository::find($id);
        /*$supplier = $repository->suppliers()->where('name',$request->search)->first();
        if($supplier){
        $purchases = Purchase::where('repository_id',$repository->id)
                  ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        }
        else{*/
        $purchases = Purchase::where('repository_id',$repository->id)
        ->where('code',$request->search)->orderBy('updated_at','DESC')->paginate(10);
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }

   

   /* public function searchBySupplier(Request $request , $id){
        $repository = Repository::find($id);
        $suppliers = $repository->suppliers; // to send to blade filter
        $arr = array('supplier'=>$request->supplier,'later'=>$request->later);
        if($request->supplier == 'all'){
            $purchases = Purchase::where('repository_id',$repository->id)
            ->orderBy('updated_at','DESC')->paginate(10);
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers]);
        }
        else{ // filter to specific supplier
        $supplier = $repository->suppliers()->where('supplier_id',$request->supplier)->first();
        }
        if($request->later){  // for search by highest suppliers we should pay in the dashboard and should not be retrieved
            $purchases = Purchase::where('repository_id',$repository->id)
            ->where('supplier_id',$supplier->id)->where('payment','later')->where('status','!=','retrieved')->orderBy('updated_at','DESC')->paginate(10);
        }
        else{
        $purchases = Purchase::where('repository_id',$repository->id)
                  ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
                }
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers]);

    } */

  /*  public function searchBySupplier(Request $request , $id){
        $repository = Repository::find($id);
        $suppliers = $repository->suppliers; // to send to blade filter
        $arr = array('supplier'=>$request->supplier,'later'=>$request->later);
        if($request->supplier == 'all'){
            $purchases = Purchase::where('repository_id',$repository->id)
            ->orderBy('updated_at','DESC')->paginate(10);
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers]);
        }
        else{ // filter to specific supplier
        $supplier = $repository->suppliers()->where('supplier_id',$request->supplier)->first();
        }
        if($request->later){  // for search by highest suppliers we should pay in the dashboard and should not be retrieved
            $purchases = Purchase::where('repository_id',$repository->id)
            ->where('supplier_id',$supplier->id)->where('payment','later')->where('status','!=','retrieved')->orderBy('updated_at','DESC')->paginate(10);
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers,
            ]);
        }
        else{    // purchases for specific supplier
        $purchases = Purchase::where('repository_id',$repository->id)
                  ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        // getting statistics for this supplier
        $purchases_with_no_paginate = Purchase::where('repository_id',$repository->id)    // all purchases for this supplier for display statistics
        ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->get();
        $total_value = 0;
        $payed = 0 ;
        $unpayed = 0;
        $retrieved = 0;
        foreach($purchases_with_no_paginate as $purchase){
            if($purchase->status == 'done')
                $total_value+=$purchase->total_price;
            if($purchase->status == 'done' && $purchase->payment != 'later')
                $payed += $purchase->total_price;
            if($purchase->status == 'done' && $purchase->payment == 'later')
                $unpayed += $purchase->total_price;
            if($purchase->status == 'retrieved')
                $retrieved+=$purchase->total_price;
        }
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers,
        'total_value' => $total_value, 'payed' => $payed, 'unpayed' => $unpayed,'retrieved'=>$retrieved,
        ]);
                }
    }  */

    public function searchBySupplier(Request $request , $id){
        $repository = Repository::find($id);
        $suppliers = $repository->suppliers; // to send to blade filter
        $arr = array('supplier'=>$request->supplier,'later'=>$request->later);
        if($request->supplier == 'all'){
            $purchases = Purchase::where('repository_id',$repository->id)
            ->orderBy('updated_at','DESC')->paginate(10);
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers]);
        }
        else{ // filter to specific supplier
        $supplier = $repository->suppliers()->where('supplier_id',$request->supplier)->first();
        }

        if($request->later){  // for search by highest suppliers we should pay in the dashboard and should not be retrieved
            $pay = 0 ;
            $unpay = 0 ;
            $total = 0 ;
            // getting statistics for this supplier
            $purchases_with_no_paginate = Purchase::where('repository_id',$repository->id)    // all purchases for this supplier for display statistics
            ->where('supplier_id',$supplier->id)->where(function($query){
                $query->where('status','pending')
                        ->orWhere('status','later')
                        ->orWhere('payment','later');
            })->orderBy('updated_at','DESC')->get();
            $purchases = Purchase::where('repository_id',$repository->id)
            ->where('supplier_id',$supplier->id)->where(function($query){
                $query->where('status','pending')
                        ->orWhere('status','later')
                        ->orWhere('payment','later');
            })
            ->orderBy('updated_at','DESC')->paginate(10);
            foreach($purchases_with_no_paginate as $purchase){
                if($purchase->purchaseProcesses()->count() > 0){
                    foreach($purchase->purchaseProcesses as $process)
                        $pay += $process->pay_amount;
                    $pay+= $purchase->pay_amount;
                }
                else
                    $pay+= $purchase->pay_amount;
                $total += $purchase->total_price;
            }
            foreach($purchases_with_no_paginate as $purchase){
                $temp = 0 ;
                if($purchase->purchaseProcesses()->count() > 0){
                    foreach($purchase->purchaseProcesses as $process)
                        $temp += $process->pay_amount;
                    $temp+= $purchase->pay_amount;
                    $unpay += $purchase->total_price - $temp;
                }
                else
                    $unpay += $purchase->total_price - $purchase->pay_amount;
            }
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers,
            'supplier' => $supplier,'payed' => $pay , 'unpayed' => $unpay , 'total_value' => $total,
            ]);
        }

        else{    // purchases for specific supplier
        $purchases = Purchase::where('repository_id',$repository->id)
                  ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        // getting statistics for this supplier
        $purchases_with_no_paginate = Purchase::where('repository_id',$repository->id)    // all purchases for this supplier for display statistics
        ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->get();
        $total_value = 0;
        $payed = 0 ;
        $unpayed = 0;
        /*
        foreach($purchases_with_no_paginate as $purchase){
            if($purchase->status == 'done')
                $total_value+=$purchase->total_price;
            if($purchase->status == 'done' && $purchase->payment != 'later')
                $payed += $purchase->total_price;
            if($purchase->status == 'done' && $purchase->payment == 'later')
                $unpayed += $purchase->total_price;
        }
        */
        foreach($purchases_with_no_paginate as $purchase){
            if($purchase->status != 'retrieved')
                $total_value+=$purchase->total_price;
            if(($purchase->status == 'done' || $purchase->status == 'pending') && $purchase->payment != 'later'){
                if($purchase->purchaseProcesses()->count() > 0){
                    foreach($purchase->purchaseProcesses as $process)
                        $payed += $process->pay_amount;
                    $payed += $purchase->pay_amount ;
                }
                else
                    $payed += $purchase->pay_amount ;
            }
            if($purchase->status == 'later' || $purchase->status == 'pending' || $purchase->payment == 'later'){
                if($purchase->purchaseProcesses()->count() > 0){
                    $temp = 0 ;
                    foreach($purchase->purchaseProcesses as $proc){
                        $temp += $proc->pay_amount ;
                    }
                    $temp += $purchase->pay_amount ;
                    $unpayed += $purchase->total_price - $temp ;
                }
                else
                    $unpayed += $purchase->total_price - $purchase->pay_amount ;
            }
                //$unpayed += $purchase->total_price;
        }
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,'suppliers'=>$suppliers,
        'supplier' => $supplier,
        'total_value' => $total_value, 'payed' => $payed, 'unpayed' => $unpayed,
        ]);
                }
    }

    /*
    public function filterByPaymentMethodSupplier(Request $request,$id){
        $supplier = Supplier::find($id);
        $repository = Repository::find($request->repo_id);
        $arr = array('repo_id'=>$request->repo_id,'payment_method'=>$request->payment_method);
        $total_value = 0;
        $payed = 0 ;
        $unpayed = 0;
        if($request->payment_method == 'all'){
        $purchases = Purchase::where('repository_id',$request->repo_id)
        ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        $purchases_with_no_paginate = Purchase::where('repository_id',$request->repo_id)    // all purchases for this supplier for display statistics
        ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->get();
            foreach($purchases_with_no_paginate as $purchase){
                if($purchase->status == 'done')
                    $total_value+=$purchase->total_price;
                if($purchase->status == 'done' && $purchase->payment != 'later')
                    $payed += $purchase->total_price;
                if($purchase->status == 'done' && $purchase->payment == 'later')
                    $unpayed += $purchase->total_price;
            }
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,
            'total_value' => $total_value, 'payed' => $payed, 'unpayed' => $unpayed,
            ]);
        }
        elseif($request->payment_method == 'payed'){
            $purchases = Purchase::where('repository_id',$request->repo_id)
            ->where('supplier_id',$supplier->id)->where('status','done')
            ->orderBy('updated_at','DESC')->paginate(10);
             $purchases_with_no_paginate = Purchase::where('repository_id',$request->repo_id)    // all purchases for this supplier for display statistics
             ->where('supplier_id',$supplier->id)
             ->where('status','done')
             ->orderBy('updated_at','DESC')->get();
                foreach($purchases_with_no_paginate as $purchase){
                        $total_value+=$purchase->total_price;
                }
                return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,
                'total_value' => $total_value,
                 ]);
        }
        elseif($request->payment_method == 'notpayed'){
            $purchases = Purchase::where('repository_id',$request->repo_id)
            ->where('supplier_id',$supplier->id)->where(function ($query) use ($request){
                $query->where('status','pending')
                      ->orWhere('status','later'); })
            ->orderBy('updated_at','DESC')->paginate(10);
             $purchases_with_no_paginate = Purchase::where('repository_id',$request->repo_id)    // all purchases for this supplier for display statistics
             ->where('supplier_id',$supplier->id)->where(function ($query) use ($request){
                $query->where('status','pending')
                      ->orWhere('status','later'); })
             ->orderBy('updated_at','DESC')->get();
                foreach($purchases_with_no_paginate as $purchase){
                    $total_value+=$purchase->total_price;
                }
                return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,
                'total_value' => $total_value,
                ]);
        }  
    }
    */
    
    public function filterByPaymentMethodSupplier(Request $request,$id){
        $supplier = Supplier::find($id);
        $repository = Repository::find($request->repo_id);
        $arr = array('repo_id'=>$request->repo_id,'payment_method'=>$request->payment_method);
        $total_value = 0;
        $payed = 0 ;
        $unpayed = 0;
        if($request->payment_method == 'all'){
        $purchases = Purchase::where('repository_id',$request->repo_id)
        ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        $purchases_with_no_paginate = Purchase::where('repository_id',$request->repo_id)    // all purchases for this supplier for display statistics
        ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->get();
            foreach($purchases_with_no_paginate as $purchase){
                if($purchase->status == 'done')
                    $total_value+=$purchase->total_price;
                if($purchase->status == 'done' && $purchase->payment != 'later')
                    $payed += $purchase->total_price;
                if($purchase->status == 'done' && $purchase->payment == 'later')
                    $unpayed += $purchase->total_price;
            }
            return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,
            'total_value' => $total_value, 'payed' => $payed, 'unpayed' => $unpayed,
            ]);
        }
        elseif($request->payment_method == 'payed'){
            $purchases = Purchase::where('repository_id',$request->repo_id)
            ->where('supplier_id',$supplier->id)->where('status','done')
            ->orderBy('updated_at','DESC')->paginate(10);
             $purchases_with_no_paginate = Purchase::where('repository_id',$request->repo_id)    // all purchases for this supplier for display statistics
             ->where('supplier_id',$supplier->id)
             ->where('status','done')
             ->orderBy('updated_at','DESC')->get();
                foreach($purchases_with_no_paginate as $purchase){
                        $total_value+=$purchase->total_price;
                }
                return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,
                'total_value' => $total_value,
                 ]);
        }
        elseif($request->payment_method == 'notpayed'){
            $purchases = Purchase::where('repository_id',$request->repo_id)
            ->where('supplier_id',$supplier->id)->where(function ($query) use ($request){
                $query->where('status','pending')
                      ->orWhere('status','later'); })
            ->orderBy('updated_at','DESC')->paginate(10);
             $purchases_with_no_paginate = Purchase::where('repository_id',$request->repo_id)    // all purchases for this supplier for display statistics
             ->where('supplier_id',$supplier->id)->where(function ($query) use ($request){
                $query->where('status','pending')
                      ->orWhere('status','later'); })
             ->orderBy('updated_at','DESC')->get();
                foreach($purchases_with_no_paginate as $purchase){
                    $total_value+=$purchase->total_price;
                }
                return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases->appends($arr),'repository'=>$repository,
                'total_value' => $total_value,
                ]);
        }  
    }

    public function showProducts($id){
        $repository = Repository::find($id);
        $products = $repository->purchaseProducts()->orderBy('created_at','DESC')->paginate(15);
        return view('manager.Purchases.show_products')->with(['products'=>$products,'repository'=>$repository]);
    }

    public function editProductForm($id){
        $product = PurchaseProduct::find($id);
        $repository = Repository::find(Session::get('repo_id'));   // better than sending id by hidden input
        return view('manager.Purchases.edit_product')->with(['product'=>$product,'repository'=>$repository]);
    }
    public function updateProduct(Request $request,$id){
        $product = PurchaseProduct::find($id);
        $store_in_stock = false;
        if($request->stored == 'yes')
            $store_in_stock = true;
        $product->update([
            'barcode' => $request->barcode,
            'name_ar' => $request->name,
            'name_en' => $request->details,
            'price' => $request->price,
            'store_in_stock' => $store_in_stock,
        ]);
        // register record of this process
        $action = Action::where('name_ar','تعديل منتج مشتريات')->first();
        $info = array('target'=>'purchase_product','id'=>$product->id);
        Record::create([
            'repository_id' => Session::get('repo_id'),
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        return back()->with('success',__('alerts.edit_success'));
    }

    /*
    public function showSupplierPayment(Request $request,$id){
        $supplier = Supplier::find($id);
        $repository = Repository::find(Session::get('repo_id'));
        $payed = 0 ;
        $unpayed = 0;
        if(count($request->all()) == 0){  // no filter (we get all the payments of this supplier)
            $purchases = $supplier->purchases;
            foreach($purchases as $purchase){
                if($purchase->status != 'retrieved' && $purchase->payment != 'later')
                    $payed += $purchase->total_price;
                elseif($purchase->status != 'retrieved' && $purchase->payment == 'later')
                    $unpayed += $purchase->total_price;
            }
        }
        else{   // filter
            // first we check if from date is truly smaller than to date
            if($request->fromDate > $request->toDate)
                return back()->with('fail','خطأ في الادخال');
            $purchases = $supplier->purchases()->whereBetween('updated_at', [$request->fromDate, $request->toDate])->get();
            foreach($purchases as $purchase){
                if($purchase->status != 'retrieved' && $purchase->payment != 'later')
                    $payed += $purchase->total_price;
                elseif($purchase->status != 'retrieved' && $purchase->payment == 'later')
                    $unpayed += $purchase->total_price;
            }
        }
        return view('manager.Purchases.supplier_payments')->with(['supplier'=>$supplier,'repository'=>$repository,'payed'=>$payed,'unpayed'=>$unpayed]);
    }
    */

    public function showSupplierPayment(Request $request,$id){
        $supplier = Supplier::find($id);
        $repository = Repository::find(Session::get('repo_id'));
        $payed = 0 ;
        $unpayed = 0;
        if(count($request->all()) == 0){  // no filter (we get all the payments of this supplier)
            $purchases = $supplier->purchases;
            foreach($purchases as $purchase){
                // calc the payed
                if($purchase->status != 'later' && $purchase->status != 'retrieved'){
                    if($purchase->purchaseProcesses()->count() > 0){
                        foreach($purchase->purchaseProcesses as $process){
                            $payed += $process->pay_amount;
                        }
                        $payed += $purchase->pay_amount;
                    }
                    else{   // just one life cycle
                        $payed += $purchase->pay_amount;
                    }
                }
                // calc the unpayed
                if($purchase->status != 'retrieved'){
                    $one_payed = 0 ;
                    if($purchase->purchaseProcesses()->count() > 0){
                        foreach($purchase->purchaseProcesses as $process){
                            $one_payed += $process->pay_amount;
                        }
                        $one_payed += $purchase->pay_amount;
                    }
                    else{   // just one life cycle
                        $one_payed += $purchase->pay_amount;
                    }
                    $unpayed += $purchase->total_price - $one_payed ;
                }
            }
        }
        else{   // filter
            // first we check if from date is truly smaller than to date
            if($request->fromDate > $request->toDate)
                return back()->with('fail','خطأ في الادخال');
            $purchases = $supplier->purchases()->whereBetween('updated_at', [$request->fromDate, $request->toDate])->get();
            foreach($purchases as $purchase){
                // calc the payed
                if($purchase->status != 'later' && $purchase->status != 'retrieved'){
                    if($purchase->purchaseProcesses()->count() > 0){
                        foreach($purchase->purchaseProcesses as $process){
                            $payed += $process->pay_amount;
                        }
                        $payed += $purchase->pay_amount;
                    }
                    else{   // just one life cycle
                        $payed += $purchase->pay_amount;
                    }
                }
                // calc the unpayed
                if($purchase->status != 'retrieved'){
                    $one_payed = 0 ;
                    if($purchase->purchaseProcesses()->count() > 0){
                        foreach($purchase->purchaseProcesses as $process){
                            $one_payed += $process->pay_amount;
                        }
                        $one_payed += $purchase->pay_amount;
                    }
                    else{   // just one life cycle
                        $one_payed += $purchase->pay_amount;
                    }
                    $unpayed += $purchase->total_price - $one_payed ;
                }
            }
        }
        return view('manager.Purchases.supplier_payments')->with(['supplier'=>$supplier,'repository'=>$repository,'payed'=>$payed,'unpayed'=>$unpayed]);
    }


    /*
   AJAX request when create new purchase invoice
   */
   public function autocomplete(Request $request){
          $repository = Repository::find($request->repos_id);
          $search = $request->get('term');
            $result = PurchaseProduct::where('repository_id',$repository->id)->where('barcode', 'LIKE', $search. '%')->get();
          return response()->json($result);
 }

 public function showIncomingExports($id){
     $repository = Repository::find($id);
     $exports = $repository->recievedExports()->latest()->paginate(30);
     return view('manager.Purchases.show_incoming_exports')->with(['repository'=>$repository,'exports'=>$exports]);
 }

 public function showIncomingExportDetails($id){
     $export = Export::find($id);
     $repository = Repository::find(Session::get('repo_id'));
     return view('manager.Purchases.show_incoming_export_details')->with(['export'=>$export,'repository'=>$repository]);
 }

 public function acceptExportInvoice(Request $request,$id){
     $export = Export::find($id);
     $repository = Repository::find(Session::get('repo_id'));
     $count = count($request->barcode);    // number of records
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){
             // query to check if product exist so we update the quantity column or if not we create new record
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->first();
            if($product)  // found it
            {
            if($product->stored == true)
            $new_quantity = $product->quantity + $request->quantity[$i];
            else
            $new_quantity = 0;   // we give zero quantity for unstored products
            $new_price = $request->price[$i];
            $new_cost_price = $request->cost_price[$i];
            $new_stored = true;
            if($request->stored[$i] == 'no')
                $new_stored = false;
            $product->update([
                'quantity' => $new_quantity,
                'cost_price' => $new_cost_price,
                'price' => $new_price,
                'stored' => $new_stored,
            ]);
            }
        else{
                // check if accept min for this record
                if(in_array($i,$request->acceptmin))
                    $acceptmin = 1; // yes
                    else
                    $acceptmin = 0; //no
                $stored = true;
                if($request->stored[$i] == 'no')
                    $stored = false;
            if($stored)
            Product::create(
                [
                    'repository_id'=>$repository->id,
                    'type_id'=>$request->type[$i],
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'quantity'=>$request->quantity[$i],
                    'cost_price'=>$request->cost_price[$i],
                    'price'=>$request->price[$i],
                    'accept_min' => $acceptmin,
                    'stored' => $stored,
                ]
                );
                else
                Product::create(
                    [
                        'repository_id'=>$repository->id,
                        'type_id'=>$request->type[$i],
                        'barcode' => $request->barcode[$i],
                        'name_ar'=>$request->name[$i],
                        'name_en'=>$request->details[$i],
                        'quantity'=>0,
                        'cost_price'=>$request->cost_price[$i],
                        'price'=>$request->price[$i],
                        'accept_min' => $acceptmin,
                        'stored' => $stored,
                    ]
                    );
        }
        }
        }
        // change export status
        $export->update([
            'user_reciever_id' => Auth::user()->id,
            'status' => 'delivered',
            'daily_report_check' => false,
            'monthly_report_check' => false,
        ]);
        return redirect()->route('show.incoming.exports',$repository->id)->with('success','تم قبول البضاعة ونقلها للمخزون بنجاح');
    }

    public function refuseExportInvoice(Request $request,$id){
        $export = Export::find($id);
        $repository = Repository::find(Session::get('repo_id'));
        $export->update([
            'user_reciever_id' => Auth::user()->id,
            'status' => 'refused',
            'daily_report_check' => false,
            'monthly_report_check' => false,
            'note' => $request->note,
        ]);
        return back()->with('refused','تم رفض الفاتورة');
    }
}

