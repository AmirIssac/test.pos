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
  /* Chrome, Safari, Edge, Opera */
 input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
input[name="external_value"] , input[name="cash_value"]{
  border: 2px solid #001bb7 !important;
  font-weight: bold;
  width: 200px;
}

.done{
    background-color: #93cb52;
    font-weight: bold;
    color: black;
  }
  .pending{
    background-color: #f4c721;
  }
  .retrieved{
    background-color: #ff4454;
  }
  .later{
    background-color: #9b9ea0;
    color: white;
  } 
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  @if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            
              <div class="card-header card-header-primary">
              <h4 class="card-title"> </h4>
                 <h4><span class="badge badge-success">{{$purchase->code}}</span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                 {{-- <thead id="th{{$i}}" class="text-primary displaynone"> --}}
                    <th>
                      Barcode  
                    </th>
                    <th>
                      {{__('sales.name')}}    
                  </th>
                    <th>
                      {{__('sales.price')}}   
                    </th>
                    <th>
                      {{__('sales.quantity')}}  
                    </th> 
                  </thead>
                  <tbody>
                    @foreach($purchase->purchaseRecords as $record)
                    <tr>
                        <td>
                            {{$record->barcode}}
                        </td>
                        <td>
                            {{$record->name}}
                        </td>
                        <td>
                            {{$record->price}}
                        </td>
                        <td>
                            {{$record->quantity}}
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: 900">
                        <td>
                          {{__('purchases.supplier')}} 
                        </td>
                        <td>
                          {{__('purchases.supplier_invoice_num')}}  
                        </td>
                        <td>
                          {{__('purchases.payed')}}
                        </td>
                        <td>
                          {{__('purchases.unpayed')}}
                        </td>
                        <td>
                          {{__('purchases.total_price')}} 
                        </td>
                        <td>
                        </td>
                        {{--
                        <td>
                          {{__('purchases.payment_proccess')}}
                        </td>
                        <td>
                          {{__('purchases.status')}}
                        </td>
                        <td>
                          {{__('purchases.employee')}}   
                        </td>
                        --}}
                    </tr>
                    <tr>
                        <td>
                            {{$purchase->supplier->name}}
                       </td>
                       <td>
                        @if($purchase->supplier_invoice_num)
                        {{$purchase->supplier_invoice_num}}
                        @else
                        {{__('purchases.none')}} 
                        @endif
                       </td>
                       <td style="color: #1ec92f">
                       @if($purchase->purchaseProcesses()->count() > 0)
                       <?php $pay_amount = 0 ; 
                            ?>
                            @foreach($purchase->purchaseProcesses as $process)
                              <?php $pay_amount += $process->pay_amount ; ?>
                            @endforeach
                            <?php $pay_amount += $purchase->pay_amount ; ?>
                            <b style="color: #1ec92f">
                            {{$pay_amount}}
                            </b>
                       @else    {{-- no purchase processes --}}
                       <b style="color: #1ec92f">
                        {{$purchase->pay_amount}}
                       </b>
                       @endif
                       </td>
                       <td style="color: #f14000; font-weight:bold">
                        @if($purchase->purchaseProcesses()->count() > 0)
                        {{$purchase->total_price - $pay_amount}}
                        @else
                        {{$purchase->total_price - $purchase->pay_amount}}
                        @endif
                      </td>
                       <td style="font-weight: bold;">
                        {{$purchase->total_price}}
                       </td>
                       <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                       {{--
                       <td>
                        @if($purchase->created_at!=$purchase->updated_at)  {{-- it was later and then payed 
                            @if($purchase->payment=='later')
                            {{__('purchases.later')}} => {{__('purchases.later')}}
                            @elseif($purchase->payment=='cashier')
                            {{__('purchases.later')}} => {{__('purchases.cashier')}}
                            @else
                            {{__('purchases.later')}} =>   {{__('purchases.cash_from_external_budget')}}  
                            @endif
                        @else
                            @if($purchase->payment=='later')
                            {{__('purchases.later')}}
                            @elseif($purchase->payment=='cashier')
                            {{__('purchases.cashier')}}
                            @else
                            {{__('purchases.cash_from_external_budget')}}  
                            @endif
                        @endif
                       </td>
                       <td>
                        @if($purchase->status=='done')
                          {{__('purchases.done')}}
                        @elseif($purchase->status=='retrieved')
                          {{__('sales.retrieved_badge')}}
                        @endif
                       </td>
                       <td>
                           {{$purchase->user->name}}
                       </td>
                       --}}
                    <tr>
                      <th>
                        {{__('purchases.payed')}}
                      </th>
                      <th>
                        {{__('purchases.payment_process')}}
                      </th>
                      <th>
                        {{__('purchases.status')}}
                      </th>
                      <th>
                        {{__('purchases.date')}}
                      </th>
                      <th>
                        {{__('purchases.employee')}}
                      </th>
                    </tr>
                    </tr>
                    @if(isset($purchase_processes) && $purchase_processes->count() > 0)
                    @foreach($purchase_processes as $purchase_process)
                    @if($purchase_process->status == 'later')
                    <tr class="later">
                    @elseif($purchase_process->status == 'pending')
                    <tr class="pending">
                    @elseif($purchase_process->status == 'done')
                    <tr class="done">
                    @elseif($purchase_process->status == 'retrieved')
                    <tr class="retrieved">
                    @endif
                    <td>
                      {{$purchase_process->pay_amount}}
                    </td>
                    <td>
                      {{$purchase_process->payment}}
                    </td>
                    <td>
                      {{$purchase_process->status}}
                    </td>
                    <td>
                      {{$purchase_process->created_at}}
                    </td>
                    <td>
                      {{$purchase_process->user->name}}
                    </td>
                    </tr>
                    @endforeach
                    @endif
                    {{-- latest version of invoice in invoices table --}}
                    @if($purchase->status == 'later')
                    <tr class="later">
                    @elseif($purchase->status == 'pending')
                    <tr class="pending">
                    @elseif($purchase->status == 'done')
                    <tr class="done">
                    @elseif($purchase->status == 'retrieved')
                    <tr class="retrieved">
                    @endif
                    <td>
                      {{$purchase->pay_amount}}
                    </td>
                    <td>
                      {{$purchase->payment}}
                    </td>
                    <td>
                      {{$purchase->status}}
                    </td>
                    <td>
                      {{$purchase->updated_at}}
                    </td>
                    <td>
                      {{$purchase->user->name}}
                    </td>
                    </tr>
                  </tbody>
                </table>
                @can('دفع فاتورة مورد')
                @if($purchase->status == 'later' || $purchase->status == 'pending')
                <form action="{{route('pay.later.purchase',$purchase->id)}}" method="POST">
                  @csrf
                  <div style="display: flex; flex-direction: column">
                    <div style="margin: 10px;">
                      {{__('purchases.cash_from_cashier')}} <input type="radio" id="cash-radio" name="payment" value="cashier" checked> &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp;
                      <input type="number" id="cash-value" min="0" step="0.01" name="cash_value" value="">
                      ({{__('purchases.cashier_balance')}}  {{$repository->balance}})
                    </div>
                    <div style="margin: 10px;">
                      {{__('purchases.cash_from_external_budget')}} <input type="radio" id="external-radio" name="payment" value="external"> &nbsp; &nbsp;
                      <input type="number" id="external-value" class="displaynone" min="0" step="0.01" name="external_value" value="">
                    </div>
                    <div>
                      @if($purchase->status == 'later' || $purchase->payment == 'later')
                      <button type="submit" name="action" value="pay_later" class="btn btn-primary">{{__('purchases.pay')}}</button>
                      @elseif($purchase->status == 'pending')
                      <button type="submit" name="action" value="pay_pending" class="btn btn-primary">{{__('purchases.pay')}}</button>
                      @endif
                      {{--
                  <button type="submit" class="btn btn-primary"> {{__('purchases.pay')}} </button>
                  --}}
                    </div> 
                  </div>
                </form>
                <hr>
                 @endif
                 @endcan
                @can('استرجاع فاتورة مشتريات')
                @if($purchase->status != 'retrieved')
                <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="modalicon">  {{__('sales.retrieve')}} </a>
                @endif
                @endcan
                              <!-- Modal for confirming -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{__('purchases.retrieve_inv')}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                      </button>
                    </div>
                    <div class="modal-body">
                      {{__('purchases.sure_you_want_refund_invoice')}}
                    </div>
                    <div class="modal-footer">
                      <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                      <form action="{{route('purchase.retrieve',$purchase->id)}}" method="POST">
                        @csrf
                      <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
               
              </div>
              </div>
            </div>
          </div>
        </div>

      </div>
     
    </div>
</div>
@section('scripts')
<script>
  $('#external-radio').on('click',function(){
    $('#external-value').removeClass('displaynone');
    $('#cash-value').addClass('displaynone');
    $('#cash-value').val(null);
  })
  $('#cash-radio').on('click',function(){
    $('#cash-value').removeClass('displaynone');
    $('#external-value').addClass('displaynone');
    $('#external-value').val(null);
  })
</script>
@endsection
@endsection

