@extends('layouts.main')
<style>
    .info{
    width: 100px;
    min-height:50px !important;
    height: 120px;
    background-color: #0d6efd !important;
    filter: drop-shadow(5px 5px 5px #001bb7);
    transition: all .2s ease-in-out;
  }
  .info p,.info p,.info i{
    color: white;
  }
  .info:hover{
    background-color: #001bb7;
    transform: scale(1.1);
  }
  #years-chart{
    background-color: #001bb7;
    color: white;
    transition: transform .2s;
  }
  #years-chart:hover{
    cursor: pointer;
    transform: scale(1.1);
  }
</style>
@section('body')
<div class="content home">
  <div class="row">
      <div class="col-md-9">
          <div class="col-12">
              <!-- Chart -->
              <form action="{{route('get.year.chart',$repository->id)}}" method="GET">
                @csrf
                  <div class="chart">
                      <select class="select" name="years_chart" id="years-chart" onchange="this.form.submit()">  {{-- 2021 start of the application --}}
                          @for($year=now()->year;$year>=2021;$year--)
                          @if(isset($chart_year))
                              @if($chart_year == $year)
                              <option value="{{$year}}" selected>{{$year}}</option>
                              @else
                              <option value="{{$year}}">{{$year}}</option>
                              @endif
                          @else
                          <option value="{{$year}}">{{$year}}</option>
                          @endif
                          @endfor
                      </select>
                      <canvas id="myChart" style="max-height: 100%;"></canvas>
                  </div>
            </form>
          </div>
          <div class="row">
            @can('لوحة نظام الاموال للمبيعات')
              <div class="col-md-3 col-sm-6">
                  <div class="box">
                      <h5 class="title-icon"><span class="theme-icon icon-orange"><i class="icofont-money-bag"></i></span>{{__('dashboard.today_sales')}}</h5>
                      <h4 class="text-center mb-2 font2">{{$repository->todaySales()}}</h4>
                      <div style="font-size: 14px;margin-bottom:5px;" class="font2"><span><i class="fa fa-money color-orange"></i> {{__('dashboard.cash')}} {{$repository->cash_balance}}</span></div>
                      <div style="font-size: 14px;margin-bottom:5px;" class="font2"><span><i class="fa fa-credit-card color-blue"></i> {{__('dashboard.card')}} {{$repository->card_balance}}</span></div>
                      <div style="font-size: 14px;margin-bottom:5px;" class="font2"><span><i class="fa fa-credit-card color-blue"></i> stc pay {{$repository->stc_balance}} </span></div>
                      <div style="font-size: 14px;" class="font2"> <span class=""><i class="fa fa-credit-card color-green"></i> {{__('dashboard.cashier')}} {{$repository->balance}}</span></div>
                  </div>
              </div>
              @endcan
              @can('لوحة مبيعات الشهر')
              <div class="col-md-3 col-sm-6">
                  <div class="box">
                      <h5 class="title-icon"><span class="theme-icon icon-blue"><i class="icofont-money-bag"></i></span>{{__('dashboard.Month_sales')}}</h5>
                      <h2 class="text-center font2">{{$repository->monthSales()}}</h2>
                      <h5 class="title-icon"><span class="theme-icon icon-blue"><i class="icofont-money-bag"></i></span>{{__('dashboard.year_sales')}}</h5>
                      <h2 class="text-center font2">{{$repository->yearSales()}}</h2>
                  </div>
              </div>
              @endcan
              @can('لوحة نظام الاموال للمبيعات')
              <div class="col-md-3 col-sm-6">
                  <div class="box">
                      <h6 class="title-icon"><span class="theme-icon icon-green"><i class="bi bi-cash-coin"></i></span>{{__('dashboard.money_collected')}}</h6>
                      <h2 class="text-center font2">{{$repository->cash_balance+$repository->card_balance+$repository->stc_balance}}</h2>
                  </div>
              </div>
              @endcan
              @can('لوحة نظام الاموال للمبيعات')
              <div class="col-md-3 col-sm-6">
                  <div class="box">
                      <h6 class="title-icon"><span class="theme-icon icon-red"><i class="bi bi-hourglass-split"></i></span>{{__('dashboard.total_pending_money')}}</h6>
                      <h2 class="text-center font2">{{$repository->totalPendingMoney()}}</h2>               
                  </div>
              </div>
              @endcan
              @can('لوحة نظام الاموال للمشتريات')
              <div class="col-md-3 col-sm-6">
                  <div class="box"> 
                      <h5 class="title-icon"><span class="theme-icon icon-orange"><i class="bi bi-bag-check-fill"></i></span>{{__('dashboard.today_purchases')}}</h5>
                      <h2 class="text-center font2">{{$repository->todayPurchases()}}</h2>
                  </div>
              </div>
              @endcan
              @can('لوحة نظام الاموال للمشتريات')
              <div class="col-md-3 col-sm-6">
                <div class="box">
                    <h5 class="title-icon"><span class="theme-icon icon-blue"><i class="bi bi-bag-check-fill"></i></span>{{__('dashboard.month_purchases')}}</h5>
                    <h2 class="text-center font2">{{$repository->monthPurchases()}}</h2>
                </div>
            </div>
            @endcan
            @can('لوحة نظام الاموال للمشتريات')
              <div class="col-md-3 col-sm-6">
                  <div class="box">                           
                      <h6 class="title-icon"><span class="theme-icon icon-green"><i class="icofont-check-circled"></i></span>{{__('dashboard.today_paid_money')}}</h6>
                      <h2 class="text-center">{{$repository->todayPayedMoney()}}</h2>
                  </div>
              </div>
              @endcan
              @can('لوحة نظام الاموال للمشتريات')
              <div class="col-md-3 col-sm-6">
                  <div class="box">
                      <h6 class="title-icon"><span class="theme-icon icon-red"><i class="icofont-ui-rotation"></i></span>{{__('dashboard.pending_paid_money')}}</h6>
                      <h2>{{$repository->pendingPayedMoney()}}</h2>
                  </div>
              </div>
              @endcan
          </div>
      </div>
      <div class="col-md-3">
        @can('عرض البضائع')
          <div class="box overflow-hidden">
            <a href="{{route('show.products',$repository->id)}}">
              <img src="{{asset('public/images/image1.svg')}}" style="width: 120%;margin:0 auto" alt="">
              <div class="text-center">
                  <h5>{{__('dashboard.number_of_products')}}</h5>
                  <h4>{{$repository->productsCount()}}</h4>
              </div>     
            </a>              
          </div>
        @endcan
        @can('عرض الموظفين')
          <div class="box overflow-hidden">
            <a href="{{route('show.workers',$repository->id)}}">
              <img src="{{asset('public/images/image2.svg')}}" style="width: 120%;margin:0 auto" alt="">
              <div class="text-center">
                  <h5>{{__('dashboard.number_of_employees')}}</h5>
                  <h4>{{$repository->workersCount()}}</h4>
              </div> 
            </a>
             </div>
        @endcan
          @can('لوحة نظام الاموال للمبيعات')
          <div class="box">
            <h5 class="title-icon"><span class="theme-icon icon-red"><i class="fa fa-file"></i></span>{{__('dashboard.highest_five_customers_should_pay')}}</h5>
            <ul>
              @if($repository->mostFivePendingInvoices()->count()>0)
                 @foreach($repository->mostFivePendingInvoices() as $inv)
                 <li>
                 <form action="{{route('view.customer.invoices',$inv->customer_id)}}" method="GET">
                  @csrf
                  <input type="hidden" name="repo_id" value="{{$repository->id}}">
                  {{--
                 <div style="display: flex; justify-content: space-between; font-weight: bold;font-size: 14px; color:#f14000">
                     {{$inv->sum}} / {{$inv->customer->name}}
                  <button style="background: none; padding: 0px; border: none"><i class="material-icons form-icon">
                    preview
                  </i></button>
                 </div>--}}
                 <div  onClick="javascript:this.parentNode.submit();" class="box info">
                       <p>{{$inv->customer->name}}<p>
                       <p> {{$inv->sum}}<p>
                  </div>
                </form>
                 </li>
                 @endforeach
                 @else
                 <div style="font-weight: bold; font-size: 14px; color:#48a44c;">
                  {{__('dashboard.none')}} 
                 </div>
                 @endif
            </ul>
        </div>
          @endcan
          @can('لوحة نظام الاموال للمشتريات')
          <div class="box">
            <h6 class="title-icon"><span class="theme-icon icon-red"><i class="fa fa-truck"></i></span>{{__('dashboard.highest_five_suppliers')}}</h6>
            <ul class="">
                 @if($repository->mostFiveSupplierShouldPay()->count()>0)
                 @foreach($repository->mostFiveSupplierShouldPay() as $info)
                 <li>
                 <form action="{{route('search.by.supplier',$repository->id)}}" method="GET">
                  @csrf
                  <input type="hidden" name="later" value="later">
                  <input type="hidden" name="supplier" value="{{$info->supplier_id}}">
                {{-- <div style="display: flex; justify-content: space-between; font-weight: bold;font-size: 14px; color:#f14000">
                    {{$info->supplier->name}} {{$info->sum}} 
                  <button style="background: none; padding: 0px; border: none;"><i style="color: #007bff;" class="material-icons form-icon">
                    preview
                  </i></button>
                 </div> --}}

                 <div  onClick="javascript:this.parentNode.submit();" class="box info">
                       <p>{{$info->supplier->name}}<p>
                           {{--
                       <p> {{$info->sum}}<p>
                           --}}
                  </div>
                 
                </form>
                 </li>
                 @endforeach
                 @else
                 <div style="font-weight: bold; font-size: 14px; color:#48a44c;">
                  {{__('dashboard.none')}} 
                 </div>
                 @endif
            </ul>                   
        </div>
    </div>
</div>

          @endcan

  <div class="row">
    @can('لوحة فواتير اليوم')
      <div class="col-md-6">
        <a href="{{route('show.today.invoices',$repository->id)}}">
          <div class="box d-block">
              <h5 class="mb-4 fw-bold">{{__('dashboard.today_invoices')}}</h5>
              <div class="row">
                  <div class="col-md-7">
                      <div class="row">
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-green ms-3"><i class="bi bi-receipt"></i></span>
                              <?php $arr = $repository->dailyInvoicesCount() ?>
                              <div class="text-center">
                                  <span class="fw-light">{{__('dashboard.delivered')}}</span>
                                  <h5 class="color-green">{{$arr['delivered']}}</h5>
                              </div>
                          </div>
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-blue ms-3"><i class="bi bi-receipt"></i></span>
                              <div class="text-center">
                                  <span class="fw-light">{{__('dashboard.hanging')}}</span>
                                  <h5 class="color-blue">{{$arr['hanging']}}</h5>
                              </div>
                          </div>
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-orange ms-3"><i class="bi bi-receipt"></i></span>
                              <div class="text-center">
                                  <span class="fw-light">{{__('dashboard.retrieved')}}</span>
                                  <h5 class="color-orange">{{$arr['retrieved']}}</h5>
                              </div>
                          </div>
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-red ms-3"><i class="bi bi-receipt"></i></span>
                              <div class="text-center">
                                  <span class="fw-light">{{__('reports.deleted')}}</span>
                                  <h5 class="color-red">{{$arr['deleted']}}</h5>
                              </div>
                          </div>                                
                      </div>
                  </div>

                  <!-- <div class="col-md-5">
                      <img class="w-100" src="images/charts.png" alt="">
                  </div> -->
              </div>
          </div>
        </a>
      </div>
      @endcan
      @can('لوحة فواتير الشهر')
      <div class="col-md-6">
        <a href="{{route('show.monthly.invoices',$repository->id)}}">
          <div class="box d-block">
              <h5 class="mb-4 fw-bold">{{__('dashboard.month_invoices')}}</h5>
              <div class="row">
                  <div class="col-md-7">
                      <div class="row">
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-green ms-3"><i class="bi bi-receipt"></i></span>
                              <?php $arr = $repository->monthlyInvoicesCount() ?>
                              <div class="text-center">
                                  <span class="fw-light">{{__('dashboard.delivered')}}</span>
                                  <h5 class="color-green">{{$arr['delivered']}}</h5>
                              </div>
                          </div>
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-blue ms-3"><i class="bi bi-receipt"></i></span>
                              <div class="text-center">
                                  <span class="fw-light">{{__('dashboard.hanging')}}</span>
                                  <h5 class="color-blue">{{$arr['hanging']}}</h5>
                              </div>
                          </div>
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-orange ms-3"><i class="bi bi-receipt"></i></span>
                              <div class="text-center">
                                  <span class="fw-light">{{__('dashboard.retrieved')}}</span>
                                  <h5 class="color-orange">{{$arr['retrieved']}}</h5>
                              </div>
                          </div>
                          <div class="col-6 d-flex align-items-center justify-content-start mb-3">
                              <span class="theme-icon icon-red ms-3"><i class="bi bi-receipt"></i></span>
                              <div class="text-center">
                                  <span class="fw-light">{{__('reports.deleted')}}</span>
                                  <h6 class="color-red">{{$arr['deleted']}}</h6>
                              </div>
                          </div>
                          
                      </div>
                  </div>

                  <!-- <div class="col-md-5">
                      <img class="w-100" src="images/charts.png" alt="">
                  </div> -->
              </div>
          </div>
        </a>
      </div>
      @endcan
  </div>
</div>
{{-- dashboard chart data --}}
<?php
      if(!isset($chart_info))    // open dashboard with no submitting form
            $chart_info = $repository->thisYearMonthlyDashboardChart(now()->year);
      $reports = $chart_info['reports'];
     /* $invoices = $chart_info['invoices'];
      $purchases = $chart_info['purchases']; */
?>

@if(!isset($chart_year) || (isset($chart_year) && $chart_year == now()->year))   {{-- display chart with no form options submit --}}
<input type="hidden" id="this-month-sales" value="{{$repository->monthSales()}}">
<input type="hidden" id="this-month-pur" value="{{$repository->monthPurchases()}}">
<input type="hidden" id="form-status" value="thisyear">
<input type="hidden" id="year" value="{{now()->year}}">
@else
<input type="hidden" id="form-status" value="notthisyear">
<input type="hidden" id="year" value="{{$chart_year}}">
@endif

@foreach($reports as $report)
<?php $total_sum_invoices = 0 ?>
@foreach($report->invoices as $invoice)
@if($invoice->status != 'retrieved' && $invoice->status != 'deleted')
<?php $total_sum_invoices += $invoice->total_price ?>
@endif
@endforeach
<input type="hidden" id="sales-{{$report->created_at->month}}" value="{{$total_sum_invoices}}">
<?php $total_sum_purchases = 0 ?>
@foreach($report->purchases as $purchase)
@if($purchase->status != 'retrieved')
@if($purchase->monthlyReports()->count()==1)
<?php $total_sum_purchases += $purchase->total_price; ?>
@elseif($purchase->monthlyReports()->count()>1)
<?php $rep = $purchase->dailyReports->first(); ?>
@if($report->id == $rep->id)
<?php $total_sum_purchases += $purchase->total_price; ?>
@endif
@endif
@endif
@endforeach
<input type="hidden" id="pur-{{$report->created_at->month}}" value="{{$total_sum_purchases}}">
@endforeach
{{-- current month number to use it in chart js --}}
<input type="hidden" id="current-month" value="{{now()->month}}">
{{-- current year number --}}
<input type="hidden" id="current-year" value="{{now()->year}}">
<!-- JavaScript Bundle with Popper -->

<script src="{{asset('public/js/jquery-3.6.0.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{--<script src="js/main.js"></script>--}}

<script>
var current_month = $('#current-month').val();
var form_status = $('#form-status').val();
if(form_status == 'thisyear'){
    for(var i=1;i<=12;i++){
        if(i != current_month){
            window["sales_month_"+i] = $('#sales-'+i).val(); 
            window["purchase_month_"+i] = $('#pur-'+i).val(); 
        }
        else{
            window["sales_month_"+i] = $('#this-month-sales').val(); 
            window["purchase_month_"+i] = $('#this-month-pur').val();
        }
    }
}
else{    // not this year
    for(var i=1;i<=12;i++){
            window["sales_month_"+i] = $('#sales-'+i).val(); 
            window["purchase_month_"+i] = $('#pur-'+i).val(); 
        }
    }


var ctx = document.getElementById('myChart');
//var current_year = $('#current-year').val();
var year = $('#year').val();
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
      labels: ['1/'+year, '2/'+year, '3/'+year, '4/'+year, '5/'+year, '6/'+year,'7/'+year,'8/'+year,'9/'+year,'10/'+year,'11/'+year,'12/'+year],
      datasets: [{
          label: 'مبيعات',
          data: [sales_month_1, sales_month_2, sales_month_3, sales_month_4, sales_month_5, sales_month_6,sales_month_7,sales_month_8,sales_month_9,sales_month_10,sales_month_11,sales_month_12],
          backgroundColor: '#001bb7',
          barThickness: 16,
      },{
          label:'مشتريات',
          data: [purchase_month_1, purchase_month_2, purchase_month_3, purchase_month_4, purchase_month_5, purchase_month_6,purchase_month_7,purchase_month_8,purchase_month_9,purchase_month_10,purchase_month_11,purchase_month_12],
          backgroundColor: '#4ca2ff',
          barThickness: 16,
      }]
  },
  options: {
      scales: {
          y: {
              beginAtZero: true,
              suggestedMin:0,
              suggestedMax:400,
          },
          
      },
      plugins: {
          title: {
              display: true,
              text: 'المبيعات السنوية',
              font: {
                  size: 18
              }
          }
      },
      width: 10,
  }
});
</script>

<script>    // years chart AJAX
    
    $('#years-chart').on('change',function(){
    var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/purchase/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
              if(data != 'no_data'){
              $('#'+id).addClass('success').removeClass('failed');
              $('#ar'+gold+'').val(data.name_ar);
              $('#price'+gold+'').val(data.price);
              $('#price'+gold+'').prop('readonly',false);
              }
              else{
                $('#'+id).addClass('failed').removeClass('success');
                $('#ar'+gold+'').val(null);
                $('#price'+gold+'').val(0);
                $('#price'+gold+'').prop('readonly',true);
              }
          }
    }); // ajax close
  });

</script>

 @endsection