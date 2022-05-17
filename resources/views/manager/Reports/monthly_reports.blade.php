@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  #warning{
    font-size: 38px;
  }
  #code{
    float: left;
  }
  #myTable th{
   color: black;
   font-weight: bold;
  }
  #myTable td{
   color: black;
   font-weight: bold;
  }
  .displaynone{
    display: none;
  }
  .eye:hover{
    cursor: pointer;
  }
  .active-a:hover{
    cursor: pointer;
  }
  .disabled-a:hover{
    cursor: default;
  }
  #current-month-tr{
    background-color: #001bb7;
    color: #ffffff;
    font-weight: bold;
  }
  i{
  transition: all .2s ease-in-out;
}
i:hover{
  transform: scale(1.3);
}
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> </h4>
              <h4> {{__('reports.monthly_reports')}} <span class="badge badge-success"></span></h4>
            
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">                    
                    <th>
                      {{__('reports.date')}}    
                  </th>
                  <th>
                    {{__('reports.sales')}}    
                </th>
                  <th>
                    {{__('reports.actions')}}
                </th>
                <th>
                  {{__('purchases.purchases')}}
              </th>
              <th>
                {{__('reports.actions')}}
               </th>
                  </thead>
                  <tbody>
                    <tr id="current-month-tr"> {{-- current month ((not making report in DB yet)) --}}
                      <td>
                        {{__('reports.current_month')}}
                      </td>
                      <td>
                        {{--
                        <php $total_sum_invoices = 0 ?>
                            @foreach($invoices as $invoice)
                            @if($invoice->status != 'retrieved' && $invoice->status != 'deleted')
                            <php $total_sum_invoices += $invoice->total_price ?>
                            @endif
                            @endforeach
                            {{$total_sum_invoices}}
                            --}}

                            {{--
                            <php $total_sum_invoices = 0 ?>
                            @foreach($invoices as $invoice)
                              @if($invoice->invoiceProcesses()->count()>0)
                                  <php
                                  $old_process_date = $invoice->invoiceProcesses[0]->created_at;
                                  $old_process_date = Carbon::createFromFormat('Y-m-d H:i:s', $old_process_date); 
                                  ?>
                                  @if($old_process_date->month == now()->month && $old_process_date->year == now()->year) 
                                  <php     
                                  $total_sum_invoices += $invoice->total_price;
                                  continue;
                                  ?>
                                  @endif
                              @else
                              <php
                                  $total_sum_invoices += $invoice->total_price;
                                  ?>
                              @endif
                            @endforeach
                            {{$total_sum_invoices}}
                            --}}

                            <?php $total_sum_invoices = 0 ?>
                            @foreach($invoices as $invoice)
                            @if($invoice->status != 'retrieved' && $invoice->status != 'deleted' && $invoice->monthlyReports()->count()==0) 
                            <?php $total_sum_invoices += $invoice->total_price ?>
                            @endif
                            @endforeach
                            {{$total_sum_invoices}}
                      </td>
                      <td>
                        <a style="color: #ffffff" href="{{route('view.current.monthly.report.details',$repository->id)}}"> <i class="material-icons eye">
                          visibility
                        </i> </a>
                        
                        .
                        <a style="color: #ffffff" href="{{route('print.current.monthly.report.details',$repository->id)}}"> <i class="material-icons eye">
                          print
                        </i> </a>
                      </td>
                      <td>
                        <?php $total_sum_purchases = 0 ?>
                        @foreach($purchases as $purchase)
                        @if($purchase->status == 'done')
                        <?php $total_sum_purchases += $purchase->total_price ?>
                        @endif
                        @endforeach
                        {{$total_sum_purchases}}
                      </td>
                      <td>
                        <a style="color: #ffffff" href="{{route('view.purchase.current.monthly.report.details',$repository->id)}}"> <i class="material-icons eye">
                          visibility
                        </i> </a>
                        .
                        <a style="color: #ffffff" href="{{route('print.purchase.current.monthly.report.details',$repository->id)}}"> <i class="material-icons eye">
                          print
                        </i> </a>
                      </td>
                    </tr>
                    @foreach($reports as $report)
                    <tr>
                        <td>
                            {{$report->created_at->format('m/Y')}}
                        </td>
                        <td>
                          {{--
                            <php $total_sum_invoices = 0 ?>
                            @foreach($report->invoices as $invoice)
                            @if($invoice->status != 'retrieved' && $invoice->status != 'deleted')
                            <php $total_sum_invoices += $invoice->total_price ?>
                            @endif
                            @endforeach
                            {{$total_sum_invoices}} 
                            --}}
                            <?php $total_sum_invoices = 0 ?>
                            @foreach($report->invoices as $invoice)
                            @if($invoice->status != 'retrieved' && $invoice->status != 'deleted')
                            @if($invoice->monthlyReports()->count()==1)
                            <?php $total_sum_invoices += $invoice->total_price; ?>
                            @elseif($invoice->monthlyReports()->count()>1)
                            <?php $rep = $invoice->monthlyReports->first(); ?>
                            @if($report->id == $rep->id)
                            <?php $total_sum_invoices += $invoice->total_price; ?>
                            @endif
                            @endif
                            @endif
                            @endforeach
                            {{$total_sum_invoices}}
                        </td>
                      <td>
                     <a style="color: #03a4ec" href="{{route('view.monthly.report.details',$report->id)}}"> <i class="material-icons eye">
                            visibility
                          </i> </a>
                          
                          .
                          <a style="color: #93cb52" href="{{route('print.monthly.report.details',$report->id)}}"> <i class="material-icons eye">
                            print
                          </i> </a>
                          
                      </td>
                      <td>
                        <?php $total_sum_purchases = 0 ?>
                        @foreach($report->purchases as $purchase)
                        @if($purchase->status == 'done')
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
                        {{$total_sum_purchases}}
                      </td>
                      <td>
                        <a style="color: #03a4ec" href="{{route('view.purchase.monthly.report.details',$report->id)}}"> <i class="material-icons eye">
                          visibility
                        </i> </a>
                        
                        .
                        <a style="color: #93cb52" href="{{route('print.purchase.monthly.report.details',$report->id)}}"> <i class="material-icons eye">
                          print
                        </i> </a>
                      </td>
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
        {{ $reports->links() }}

      </div>
     
    </div>
</div>
@endsection

@section('scripts')
<script>
  $('.eye').on('click',function(){
    var id = $(this).attr('id');
    if($('#th'+id).hasClass('displaynone')){  // show
    $('#th'+id).removeClass('displaynone');
    $('#tb'+id).removeClass('displaynone');
    }
    else
    {  // hide
      $('#th'+id).addClass('displaynone');
      $('#tb'+id).addClass('displaynone');
    }
  });
</script>
@endsection