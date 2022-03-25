<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

// Admin
Route::group(['middleware'=>'admin_check'],function(){
Route::get('/roles','RolesController@index')->name('roles')->middleware('auth');
Route::get('/permissions','PermissionController@index')->name('permissions')->middleware('auth');
Route::resource('/repositories','RepositoryController')->middleware('auth');
Route::get('/products','ProductsController@index')->name('products.index')->middleware('auth');
Route::get('/edit/user/details/{user_id}','PermissionController@editUserDetailsForm')->name('edit.user.details');
Route::post('/change/user/password/by/admin/{user_id}','PermissionController@changeUserPassword')->name('change.user.password.by.admin');

Route::get('/role/add/form','RolesController@addRoleForm')->name('role.add.form');
Route::post('/role/add','RolesController@addRole')->name('role.add');
Route::get('/edit/role/permissions/{id}','RolesController@editRolePermissionForm')->name('edit.role.permissions');
Route::post('/make/edit/role/permissions/{id}','RolesController@editRolePermissions')->name('make.edit.role.permissions');
Route::get('/permissions','PermissionController@index')->name('permissions');
Route::get('/permission/add/form','PermissionController@addPermissionForm')->name('permission.add.form');
Route::post('/permission/store','PermissionController@store')->name('permission.store');
Route::get('/products/show','ProductsController@show')->name('products.show');
Route::post('/store/type','ProductsController@storeType')->name('store.type');
Route::get('/system/index','SystemController@index')->name('system.index');
Route::post('/make/monthly/report/for/all','SystemController@makeMonthlyReport')->name('make.monthly.report.for.all');
Route::get('/show/repository/status/{repository_id}','SystemController@showRepositoryStatus')->name('show.repository.status');
Route::post('/edit/repository/status/{repository_id}','SystemController@editRepositoryStatus')->name('edit.repository.status');
Route::post('/factory/reset/{repository_id}','SystemController@factoryReset')->name('factory.reset');
Route::post('/reset/invoices-count-today','SystemController@resetInvociesCounter')->name('reset.invoices.counter');
});


Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{
Route::get('/',  'HomeController@selectRepository')->middleware(['auth','is_verify_email']);
Route::get('/repo/{repository_id}','HomeController@choseMain')->name('in.repo')->middleware('auth')->middleware('check_user')->middleware('is_repository_active');
Route::get('/{repository_id}','HomeController@main')->name('in.repository')->middleware('auth')->middleware('check_user')->middleware('is_repository_active')->middleware('cashier_warning');
Route::get('/select/repository/redirect','HomeController@selectRepositoryRedirectWithNoDeleteForSession')->name('select.repository.redirect')->middleware(['auth','is_verify_email']);
// we remove the session when we switch the sub
Route::get('/switch/sub','HomeController@switchSub')->name('switch.sub')->middleware(['auth','is_verify_email']);

Route::get('/home','HomeController@index')->middleware('auth');
Route::get('/ltr',function () {
    return view('settings.ltr');
})->name('ltr');




Route::group(['middleware'=>['auth','is_verify_email']],function(){
    
    Route::get('/get/year/chart/{repository_id}','Manager\RepositoryController@getYearChart')->name('get.year.chart')->middleware('check_user');

    // Admin
    /*
Route::get('/role/add/form','RolesController@addRoleForm')->name('role.add.form');
Route::post('/role/add','RolesController@addRole')->name('role.add');
Route::get('/edit/role/permissions/{id}','RolesController@editRolePermissionForm')->name('edit.role.permissions');
Route::post('/make/edit/role/permissions/{id}','RolesController@editRolePermissions')->name('make.edit.role.permissions');
Route::get('/permissions','PermissionController@index')->name('permissions');
Route::get('/permission/add/form','PermissionController@addPermissionForm')->name('permission.add.form');
Route::post('/permission/store','PermissionController@store')->name('permission.store');



Route::get('/products/show','ProductsController@show')->name('products.show');
Route::post('/store/type','ProductsController@storeType')->name('store.type');

Route::get('/system/index','SystemController@index')->name('system.index');
Route::post('/make/monthly/report/for/all','SystemController@makeMonthlyReport')->name('make.monthly.report.for.all');
*/

// manager
Route::group(['middleware' => ['permission:المبيعات']], function () {
    Route::get('/sales/{repository_id}','Manager\SellController@index')->name('sales.index')->middleware('check_user')->middleware('is_repository_active');
    Route::get('/ajax/get/product/{repository_id}/{barcode}','Manager\RepositoryController@getProductAjax');
    Route::group(['middleware' => ['check_user','is_repository_active']], function () {
        Route::get('/create/invoice/form/{repository_id}','Manager\SellController@createInvoiceForm')->name('create.invoice');
        Route::get('/create/special/invoice/form/{repository_id}','Manager\SellController@createSpecialInvoiceForm')->name('create.special.invoice'); // 2
        Route::get('/create/price/invoice/{repository_id}','Manager\SellController@createPriceInvoice')->name('create.price.invoice');
        Route::post('/store/price/invoice/{repository_id}','Manager\SellController@storePriceInvoice')->name('store.price.invoice');
        Route::post('/sell/{repository_id}','Manager\SellController@sell')->name('make.sell')->middleware('lock_process');
        Route::get('/show/pending/invoices/{repository_id}','Manager\SellController@showPending')->name('show.pending');
        Route::get('/search/pending/{repository_id}','Manager\ReportController@searchPending')->name('search.pending');
        Route::get('/show/invoice/details/{repository_id}','Manager\SellController@invoiceDetails')->name('invoice.details');
        //Route::get('/show/special/invoice/details/{repository_id}','Manager\SellController@specialInvoiceDetails')->name('special.invoice.details');  // 2
        Route::post('/sell/special/invoice/{repository_id}','Manager\SellController@sellSpecialInvoice')->name('sell.special.invoice')->middleware('lock_process');  // 2
        Route::post('/save/special/invoice/{repository_id}','Manager\SellController@saveSpecialInvoice')->name('save.special.invoice');  // 2
        Route::get('/create/old/special/invoice/form/{repository_id}','Manager\SellController@createSpecialInvoiceForm')->name('create.old.special.invoice');
        Route::post('/save/old/special/invoice/{repository_id}','Manager\SellController@saveOldSpecialInvoice')->name('save.old.special.invoice')->middleware('lock_process');
    });
    // need middleware for variable id
    Route::get('/complete/invoice/form/{invoice_uuid}','Manager\SellController@completeInvoiceForm')->name('complete.invoice.form')->middleware('permission:استكمل فاتورة معلقة');
    Route::post('/complete/invoice/{invoice_id}','Manager\SellController@completeInvoice')->name('complete.invoice')->middleware('permission:استكمل فاتورة معلقة');
    // retrive invoice
    Route::get('/retrieve/{repository_id}','Manager\SellController@retrieveIndex')->name('retrieve.index');
    Route::post('/make/retrieve/{invoice_id}','Manager\SellController@retrieveInvoice')->name('retrieve.invoice');
    Route::get('change/invoice/payment/{invoice_uuid}','Manager\SellController@changePayment')->name('change.invoice.payment');
    Route::post('make/change/invoice/payment/{invoice_id}','Manager\SellController@makeChangePayment')->name('make.change.invoice.payment');
    /*
    Route::post('delete/invoice/{invoice_id}','Manager\SellController@deleteInvoice')->name('delete.invoice');
    */
    // send sms
    Route::post('send/sms/{invoice_id}','Manager\RepositoryController@sendSMSForInvoiceReady')->name('send.sms.for.invoice');
});
Route::get('view/customer/invoices/{customer_id}','Manager\ReportController@viewCustomerInvoices')->name('view.customer.invoices');

Route::group(['middleware' => ['permission:المخزون']], function () {
    Route::get('/repository/{repository_id}','Manager\RepositoryController@index')->name('repository.index')->middleware('check_user')->middleware('is_repository_active');
    Route::post('/store/product','Manager\RepositoryController@storeProduct')->name('store.product');
    Route::group(['middleware' => ['check_user','is_repository_active']], function () {
        Route::get('/add/product/form/{repository_id}','Manager\RepositoryController@addProductForm')->name('add.product.form');
        Route::get('/import/products/excel/{repository_id}','Manager\RepositoryController@importExcelForm')->name('import.excel.form');
        Route::post('/store/products/excel/{repository_id}','Manager\RepositoryController@importExcel')->name('import.excel');
        Route::get('/show/products/{repository_id}','Manager\RepositoryController@showProducts')->name('show.products');
        Route::get('/filter/products/{repository_id}','Manager\RepositoryController@filterProducts')->name('filter.products');
        Route::get('/search/products/{repository_id}','Manager\RepositoryController@searchProducts')->name('search.products');
        Route::get('/filter/products/byType/{repository_id}','Manager\RepositoryController@filterProductsByType')->name('filter.products.byType');
        Route::get('/filter/products/byPriceRange/{repository_id}','Manager\RepositoryController@filterProductsByPriceRange')->name('filter.products.byPriceRange');
        Route::get('/filter/products/byOrder/{repository_id}','Manager\RepositoryController@filterProductsByOrder')->name('filter.products.byOrder');
        Route::get('export/products/{repository_id}', 'Manager\RepositoryController@exportProducts')->name('export.products');
    });
});

Route::get('/purchases/{repository_id}','Manager\PurchaseController@index')->name('purchases.index')->middleware('check_user')->middleware('is_repository_active');
Route::get('/add/purchase/{repository_id}','Manager\PurchaseController@add')->name('purchase.add');
Route::get('/add/supplier/form/{repository_id}','Manager\PurchaseController@addSupplier')->name('add.supplier');
Route::post('/store/supplier/{repository_id}','Manager\PurchaseController@storeSupplier')->name('store.supplier');
Route::get('/show/suppliers/{repository_id}','Manager\PurchaseController@showSuppliers')->name('show.suppliers');
Route::post('/store/purchase/{repository_id}','Manager\PurchaseController@storePurchase')->name('store.purchase')->middleware('lock_process');
Route::post('edit/supplier','Manager\PurchaseController@editSupplierForm')->name('edit.supplier'); // we use form input hidden to use id and not passing it into url
Route::post('update/supplier','Manager\PurchaseController@updateSupplier')->name('update.supplier'); // we use form input hidden to use id and not passing it into url
Route::post('delete/supplier','Manager\PurchaseController@deleteSupplier')->name('delete.supplier'); // we use form input hidden to use id and not passing it into url
Route::get('/show/purchases/{repository_id}','Manager\PurchaseController@showPurchases')->name('show.purchases');
Route::get('/show/purchase/details/{purchase_uuid}','Manager\PurchaseController@showPurchaseDetails')->name('show.purchase.details');
// post for activity log id
Route::post('/show/purchase/details/by/log','Manager\PurchaseController@showPurchaseDetailsByLog')->name('show.purchase.details.by.log');
Route::get('/purchase/products/{repository_id}','Manager\PurchaseController@productsForm')->name('purchase.products');
Route::post('/store/purchase/products/{repository_id}','Manager\PurchaseController@storeProducts')->name('store.purchase.products');
Route::get('/ajax/get/purchase/product/{repository_id}/{barcode}','Manager\PurchaseController@getProductAjax');
Route::get('/show/later/purchases/{repository_id}','Manager\PurchaseController@showLaterPurchases')->name('show.later.purchases');
Route::post('/pay/later/purchase/{purchase_id}','Manager\PurchaseController@payLaterPurchase')->name('pay.later.purchase');
//Route::get('/retrieve/purchase/{repository_id}','Manager\PurchaseController@retrieveIndex')->name('retrieve.purchase.index');
//Route::get('/show/purchase/retrieve/details/{purchase_id}','Manager\PurchaseController@showPurchaseRetrieveDetails')->name('show.purchase.retrieve.details');
Route::post('/retrieve/purchase/{purchase_id}','Manager\PurchaseController@retrieve')->name('purchase.retrieve');
Route::get('/search/purchases/byDate/{repository_id}','Manager\PurchaseController@searchByDate')->name('search.purchases.by.date');
Route::get('/search/purchases/{repository_id}','Manager\PurchaseController@search')->name('search.purchases');
Route::get('/search/purchases/bySupplier/{repository_id}','Manager\PurchaseController@searchBySupplier')->name('search.by.supplier');
Route::get('/show/purchase/products/{repository_id}','Manager\PurchaseController@showProducts')->name('show.purchase.products');
Route::get('edit/purchase/product/{product_id}','Manager\PurchaseController@editProductForm')->name('edit.purchase.product');
Route::post('update/purchase/product/{product_id}','Manager\PurchaseController@updateProduct')->name('update.purchase.product');
Route::get('/filter/purchases/byPaymentMethod/supplier/{supplier_id}','Manager\PurchaseController@filterByPaymentMethodSupplier')->name('filter.purchases.byPaymentMethod.supplier');
Route::post('/store/old/purchase/{repository_id}','Manager\PurchaseController@storeOldPurchase')->name('store.old.purchase')->middleware('lock_process');
Route::get('show/supplier/payments/{supplier_id}','Manager\PurchaseController@showSupplierPayment')->name('show.supplier.payments');


Route::group(['middleware'=>['permission:التقارير']], function () {
    Route::get('/reports/{repository_id}','Manager\ReportController@index')->name('reports.index')->middleware('check_user')->middleware('is_repository_active');
    Route::group(['middleware' => ['check_user','is_repository_active']], function () {
        Route::get('/show/invoices/{repository_id}','Manager\ReportController@showInvoices')->name('show.invoices');
        Route::get('/show/price/invoices/{repository_id}','Manager\ReportController@showPriceInvoices')->name('show.price.invoices');
        Route::get('/show/today/invoices/{repository_id}','Manager\ReportController@showTodayInvoices')->name('show.today.invoices');
        Route::get('/show/monthly/invoices/{repository_id}','Manager\ReportController@showMonthInvoices')->name('show.monthly.invoices');
        Route::get('/search/invoices/{repository_id}','Manager\ReportController@searchInvoicesByDate')->name('search.invoices');
        Route::get('/search/invoices/code/{repository_id}','Manager\ReportController@searchInvoicesByCode')->name('search.invoices.code');
        Route::get('/daily/reports/{repository_id}','Manager\ReportController@dailyReports')->name('daily.reports.index');
    });
    Route::get('view/daily/report/details/{report_id}','Manager\ReportController@dailyReportDetails')->name('view.daily.report.details');
    Route::get('/view/current/daily/report/details/{repository_id}','Manager\ReportController@reportDetailsCurrentDay')->name('view.current.daily.report.details');
    Route::get('view/daily/purchase/report/details/{report_id}','Manager\ReportController@dailyPurchaseReportDetails')->name('view.daily.purchase.report.details');
    Route::get('/view/current/daily/purchase/report/details/{repository_id}','Manager\ReportController@reportPurchaseDetailsCurrentDay')->name('view.current.daily.purchase.report.details');
    Route::get('/print/current/daily/report/details/{repository_id}','Manager\ReportController@reportDetailsCurrentDay')->name('print.current.daily.report.details');
    Route::get('print/daily/report/details/{report_id}','Manager\ReportController@dailyReportDetails')->name('print.daily.report.details');
    Route::get('/print/purchase/current/daily/report/details/{repository_id}','Manager\ReportController@reportPurchaseDetailsCurrentDay')->name('print.purchase.current.daily.report.details');
    Route::get('print/purchase/daily/report/details/{report_id}','Manager\ReportController@dailyPurchaseReportDetails')->name('print.purchase.daily.report.details');
    Route::get('/invoice/details/{invoice_uuid}','Manager\ReportController@invoiceDetails')->name('invoice.details');
    Route::get('/price/invoice/details/{invoice_uuid}','Manager\ReportController@priceInvoiceDetails')->name('price.invoice.details');
    // id for activity_log
    Route::post('/invoice/details/by/log','Manager\ReportController@invoiceDetailsByLog')->name('invoice.details.by.log');
    Route::get('/print/invoice/{invoice_uuid}','Manager\ReportController@printInvoice')->name('print.invoice');
    Route::get('/filter/pending/invoices/{repository_id}','Manager\ReportController@filterPending')->name('filter.pending.invoices');
    // monthly reports
Route::post('/make/monthly/report/{repository_id}','Manager\ReportController@makeMonthlyReport')->name('make.monthly.report');
Route::get('/view/monthly/reports/{repository_id}','Manager\ReportController@viewMonthlyReports')->name('view.monthly.reports');
Route::get('/view/monthly/report/details/{report_id}','Manager\ReportController@monthlyReportDetails')->name('view.monthly.report.details');
Route::get('/view/current/monthly/report/details/{repository_id}','Manager\ReportController@reportDetailsCurrentMonth')->name('view.current.monthly.report.details');
Route::get('/view/purchase/monthly/report/details/{report_id}','Manager\ReportController@monthlyPurchaseReportDetails')->name('view.purchase.monthly.report.details');
Route::get('/view/current/purchase/monthly/report/details/{repository_id}','Manager\ReportController@purchaseReportDetailsCurrentMonth')->name('view.purchase.current.monthly.report.details');
Route::get('/print/current/monthly/report/details/{repository_id}','Manager\ReportController@reportDetailsCurrentMonth')->name('print.current.monthly.report.details');
Route::get('/print/monthly/report/details/{report_id}','Manager\ReportController@monthlyReportDetails')->name('print.monthly.report.details');
Route::get('/print/purchase/current/monthly/report/details/{repository_id}','Manager\ReportController@purchaseReportDetailsCurrentMonth')->name('print.purchase.current.monthly.report.details');
Route::get('/print/purchase/monthly/report/details/{report_id}','Manager\ReportController@monthlyPurchaseReportDetails')->name('print.purchase.monthly.report.details');

// print additional recipe
Route::get('/print/additional/recipe/{invoice_id}','Manager\ReportController@printAdditionalRecipe')->name('print.additional.recipe');

Route::get('export/daily-report/{report_id}', 'Manager\ReportController@exportDailyReport')->name('export.daily.report');
});



Route::group(['middleware'=>['permission:الاعدادات']], function () {
    Route::get('manager/settings/{repository_id}','Manager\SettingsController@index')->name('manager.settings.index')->middleware('check_user')->middleware('is_repository_active');
    Route::group(['middleware' => ['check_user','is_repository_active']], function () {
        Route::get('settings/min/{repository_id}','Manager\SettingsController@minForm')->name('settings.min.form');
        Route::post('change/min/{repository_id}','Manager\SettingsController@min')->name('settings.min');
        Route::post('change/tax/{repository_id}','Manager\SettingsController@tax')->name('settings.tax');
        Route::post('change/maxDiscount/{repository_id}','Manager\SettingsController@maxDiscount')->name('settings.max.discount');
        Route::get('settings/app/{repository_id}','Manager\SettingsController@app')->name('settings.app');
        Route::post('submit/settings/app/{repository_id}','Manager\SettingsController@submitApp')->name('submit.settings.app'); 
        Route::get('/worker/add/{repository_id}','Manager\SettingsController@addWorkerForm')->name('add.worker')->middleware('permission:اضافة موظف جديد');
        Route::post('/worker/store/{repository_id}','Manager\SettingsController@storeWorker')->name('store.worker')->middleware('permission:اضافة موظف جديد');
        Route::get('all/workers/{repository_id}','Manager\SettingsController@showWorkers')->name('show.workers');
        Route::post('/general/settings/{repository_id}','Manager\SettingsController@generalSettings')->name('general.settings');
        Route::post('/discount/settings/{repository_id}','Manager\SettingsController@discountSettings')->name('discount.settings');
    });
    // need middleware for variable
    Route::get('show/worker/permissions/{user_id}','Manager\SettingsController@showWorkerPermissions')->name('show.worker.permissions')->middleware('permission:عرض الموظفين');
    Route::post('edit/worker/permissions/{user_id}','Manager\SettingsController@editWorkerPermissions')->name('edit.worker.permissions')->middleware('permission:تعديل صلاحيات موظف'); 
    Route::get('edit/worker/info/form/{user_id}','Manager\SettingsController@editWorkerInfo')->name('edit.worker.info');
    Route::post('update/worker/info/{user_id}','Manager\SettingsController@updateWorkerInfo')->name('update.worker.info');
    Route::get('show/worker/sales/{user_id}/{repository_id}','Manager\SettingsController@showWorkerSales')->name('show.worker.sales');
    Route::post('confirm/print/settings/{repository_id}','Manager\SettingsController@printSettings')->name('confirm.print.settings');
    Route::post('confirm/cashier/settings/{repository_id}','Manager\SettingsController@cashierSettings')->name('confirm.cashier.settings');
    Route::get('print/settings/{repository_id}','Manager\SettingsController@printSettingsIndex')->name('print.settings');
    Route::get('activity/log/{repository_id}','Manager\SettingsController@activityLog')->name('activity.log');
});
Route::post('change/password/{user_id}','Manager\SettingsController@changePassword')->name('change.password');


Route::get('view/account/{user_id}','Manager\SettingsController@viewAccount')->name('view.account');

Route::group(['middleware'=>['permission:الكاشير']], function () {
    Route::get('/cashier/{repository_id}','Manager\CashierController@index')->name('cashier.index')->middleware('check_user')->middleware('is_repository_active');
    Route::group(['middleware' => ['check_user','is_repository_active']], function () {
        Route::get('/daily/cashier/{repository_id}','Manager\CashierController@dailyCashierForm')->name('daily.cashier.form')->middleware('permission:اغلاق الكاشير');
        Route::get('/day/cashier/from/warning/{repository_id}','Manager\CashierController@dailyCashierFormFromWarning')->name('daily.cashier.form.from.warning');
        Route::get('/daily/cashier/warning/{repository_id}','Manager\CashierController@dailyCashierWarningForm')->name('daily.cashier.warning.form')->middleware('permission:اغلاق الكاشير');
        Route::post('/submit/cashier/{repository_id}','Manager\CashierController@submitCashier')->name('submit.cashier')->middleware('permission:اغلاق الكاشير');
        Route::post('/withdraw/{repository_id}','Manager\CashierController@withdraw')->name('withdraw.cashier');
        Route::post('/deposite/{repository_id}','Manager\CashierController@deposite')->name('deposite.cashier');
    });
});

Route::get('/clients/{repository_id}','Manager\SettingsController@clients')->name('clients')->middleware('check_user')->middleware('is_repository_active');
Route::get('/client/edit/{client_id}','Manager\SettingsController@editClient')->name('edit.client');
Route::post('/client/update/{client_id}','Manager\SettingsController@updateClient')->name('update.client');
Route::get('export/customers/{repository_id}', 'Manager\RepositoryController@exportCustomers')->name('export.customers');


Route::post('edit/product','Manager\RepositoryController@editProductForm')->name('edit.product'); // we use form input hidden to use id and not passing it into url
Route::post('update/product','Manager\RepositoryController@updateProduct')->name('update.product'); // we use form input hidden to use id and not passing it into url
Route::post('delete/product','Manager\RepositoryController@deleteProduct')->name('delete.product'); // we use form input hidden to use id and not passing it into url




// cashier warning
Route::get('cashier/warning/{repository_id}','Manager\CashierController@warning')->name('cashier.warning');
}); // end of localization

Route::get('/ajax/get/typeName/{type_id}','Manager\RepositoryController@getTypeNameAjax');
Route::get('/ajax/check/barcode/exist/{repository_id}','Manager\RepositoryController@checkBarcodeAjax')->name('ajax.check.barcode');


Route::get('autocomplete/purchase/products', 'Manager\PurchaseController@autocomplete')->name('autocomplete.purchase.products');
Route::get('autocomplete/invoice/products', 'Manager\SellController@autocomplete')->name('autocomplete.invoice.products');

// مستودع تصدير (مبيعات)
Route::get('/index/export/{repository_id}','Manager\SellController@indexExport')->name('index.export');
Route::get('/export/invoice/form/{repository_id}','Manager\SellController@exportInvoiceForm')->name('export.invoice.form');
Route::post('/submit/export/invoice/{repository_id}','Manager\SellController@submitExportInvoice')->name('submit.export.invoice');
Route::get('/show/exports/{repository_id}','Manager\SellController@showExports')->name('show.exports');
Route::get('/show/incoming/exports/{repository_id}','Manager\PurchaseController@showIncomingExports')->name('show.incoming.exports');
Route::get('/show/incoming/export/details/{export_id}','Manager\PurchaseController@showIncomingExportDetails')->name('show.incoming.export.details');
Route::get('/show/export/details/{export_id}','Manager\PurchaseController@showIncomingExportDetails')->name('show.export.details');
Route::post('/accept/export/invoice/{export_id}','Manager\PurchaseController@acceptExportInvoice')->name('accept.export.invoice');
Route::post('/refuse/export/invoice/{export_id}','Manager\PurchaseController@refuseExportInvoice')->name('refuse.export.invoice');
Route::post('/retrieve/export/invoice/{export_id}','Manager\SellController@retrieveExportInvoice')->name('retrieve.export.invoice');


});  // end of auth && is_verify middlewares


/* New Added Routes */
// guest
Route::get('/enter/credentials','Guest\GuestController@enterEmailForm')->name('enter.credentials'); 
Route::get('/waitFor/verify','Guest\GuestController@waitForVerify')->name('wait.for.verify'); 
Route::post('/store/credentials','Guest\GuestController@storeCredentials')->name('store.credentials');
Route::get('account/verify/{token}', 'Guest\GuestController@verifyAccount')->name('user.verify');
Route::group(['middleware'=>'is_verify_email'],function(){
    Route::get('/create/repository','Guest\GuestController@createRepositoryForm')->name('create.repository.form');
    Route::post('/store/new/repository','Guest\GuestController@storeRepository')->name('store.repository');
});
// custom massege
Route::get('/repository/status/{repository_id}','Manager\RepositoryController@repositoryStatus')->name('repository.status');
// Cashier warning (Reminder)
Route::get('/cashier/reminder/{repository_id}','Manager\CashierController@cashierReminder')->name('cashier.reminder');
Route::post('/ignore/cashier/reminder/{repository_id}','Manager\CashierController@ignoreCashierReminder')->name('ignore.cashier.reminder');



// download file
Route::get('download/excel/file/{file_name}','Manager\RepositoryController@downloadExcelFile')->name('download.excel.file');


// send sms
Route::post('send/sms','Manager\RepositoryController@sendSMS')->name('send.sms');