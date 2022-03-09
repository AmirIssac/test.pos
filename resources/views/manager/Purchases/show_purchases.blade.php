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
  .select-suppliers{
    border-radius: 10px;
    border:1px solid black;
    background-color: #001bb7;
    color: white
  }

  /* for the date format */
  input[type=date] {
    position: relative;
    width: 150px; height: 39px;
    color: white;
}

input[type=date]:before {
    position: absolute;
    top: 3px; left: 3px;
    content: attr(data-date);
    display: inline-block;
    color: black;
}

input[type=date]::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
    display: none;
}

input[type=date]::-webkit-calendar-picker-indicator {
    position: absolute;
    top: 3px;
    right: 0;
    color: black;
    opacity: 1;
}
.search-btn{
  border:none;
  background-color: transparent
}
.search-btn i{
  color: #001bb7;
}
i{
  transition: all .2s ease-in-out;
}
i:hover{
  transform: scale(1.3);
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
  border: 1px solid #001bb7 !important;
  font-weight: bold;
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
  #purchases-table span{
    margin: 5px;
    border: 1px solid black;
    border-radius: 5px;
    padding: 0px 2px ;
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
  @if(request()->is('show/purchases/*') || request()->is('en/show/purchases/*'))
  <div style="display: flex">
    <form action="{{route('search.purchases.by.date',$repository->id)}}" method="GET">
      @csrf
      <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
        <input type="date" data-date="" data-date-format="DD-MM-YYYY" name="dateSearch" class="form-control">
        <button type="submit" class="search-btn">
          <i class="material-icons">search</i>
        </button>
      </div>
    </form>
      <form action="{{route('search.purchases',$repository->id)}}" method="GET">
        @csrf
        <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
          <input type="text" name="search" class="form-control" placeholder="{{__('purchases.invoice_num')}}">
          <button type="submit" class="search-btn">
            <i class="material-icons">search</i>
          </button>
        </div>
      </form>
      @if(isset($suppliers))
      {{-- filter --}}
      <form action="{{route('search.by.supplier',$repository->id)}}" method="GET">
      @csrf
      <select class="select-suppliers" name="supplier">
        <option value="all">{{__('purchases.all_suppliers')}}</option>
        @foreach($suppliers as $supplier)
        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
        @endforeach
      </select>
      <button type="submit" class="search-btn">
        <i class="material-icons">search</i>
      </button>
      </form>
      @endif
    </div>
    @endif {{--  request check --}}
    @if(request()->is('search/purchases/bySupplier/*') || request()->is('en/search/purchases/bySupplier/*'))
    @if(request()->get('supplier') != 'all')  {{-- not displaying the payment filter if we search by all suppliers --}}
  <div style="display: flex;width: 300px; margin-right: 20px;">
    <form action="{{route('filter.purchases.byPaymentMethod.supplier',$supplier->id)}}" method="GET">
      @csrf
      <select class="select-suppliers" name="payment_method">
        <option value="all">{{__('sales.all')}}</option>
        <option value="payed">{{__('sales.payed')}}</option>
        <option value="notpayed">{{__('sales.not_payed')}}</option>
      </select>
      <input type="hidden" name="repo_id" value="{{$repository->id}}">
      <button type="submit" class="search-btn">
        <i class="material-icons">search</i>
      </button>
    </form>
  </div>
  @endif
    @endif
    <div class="container-fluid">
      <div class="row" id="purchases-table">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title"> </h4>
              <h4> {{__('reports.invoices')}} <span class="badge badge-success"></span></h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                 {{-- <thead id="th{{$i}}" class="text-primary displaynone"> --}}
                    <th>
                      {{__('reports.invoice_num')}}  
                    </th>
                    <th>
                      {{__('reports.date')}}    
                  </th>
                    <th>
                      {{__('purchases.supplier')}}   
                    </th>
                    <th>
                      {{__('purchases.total_price')}}   
                    </th> 
                    <th>
                      {{__('purchases.payed')}}   
                    </th> 
                    <th>
                      {{__('purchases.unpayed')}}   
                    </th> 
                  <th>
                    {{__('reports.actions')}}
                </th>
                  </thead>
                  <tbody>
                     @if($purchases->count()>0)
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>
                            {{$purchase->code}}
                        </td>
                        <td>
                          {{--
                          @if($purchase->created_at!=$purchase->updated_at)  {{-- it was later and then payed 
                            <span class="badge-secondary"> {{$purchase->created_at}} </span>   <span class="badge-success"> {{$purchase->updated_at}} </span>
                            @else
                            <span class="badge-success"> {{$purchase->created_at}} </span>
                            @endif
                            --}}
                            @if($purchase->purchaseProcesses()->count() > 0)
                              @foreach($purchase->purchaseProcesses as $process)
                                @if($process->status == 'later')
                                  <span class="later">
                                @elseif($process->status == 'pending')
                                  <span class="pending">
                                @elseif($process->status == 'done')
                                  <span class="done">
                                @elseif($process->status == 'retrieved')
                                  <span class="retrieved">
                                @endif
                                 {{$process->created_at->format('y m d')}}
                                </span>
                              @endforeach
                                {{-- last life cycle --}}
                                @if($purchase->status == 'later')
                                <span class="later">
                                @elseif($purchase->status == 'pending')
                                <span class="pending">
                                @elseif($purchase->status == 'done')
                                <span class="done">
                                @elseif($purchase->status == 'retrieved')
                                <span class="retrieved">
                                @endif
                                 {{$purchase->updated_at->format('y m d')}}
                                </span>
                            @else   {{-- just one life --}}
                                @if($purchase->status == 'later')
                                <span class="later">
                                @elseif($purchase->status == 'pending')
                                <span class="pending">
                                @elseif($purchase->status == 'done')
                                <span class="done">
                                @elseif($purchase->status == 'retrieved')
                                <span class="retrieved">
                                @endif
                                 {{$purchase->created_at->format('y m d')}}
                              </span>
                            @endif
                        </td>
                        <td>
                            {{$purchase->supplier->name}}
                        </td>
                        <td style="font-weight:bold">
                          {{$purchase->total_price}}
                        </td>
                        <td>
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
                        
                      <td>
                       
                     <a style="color: #03a4ec" href="{{route('show.purchase.details',$purchase->uuid)}}"> <i class="material-icons eye">
                            visibility
                          </i> </a>
                          @can('استرجاع فاتورة مشتريات')
                          .
                          @if($purchase->status != 'retrieved')
                          
                          <a style="color: #f14000" data-toggle="modal" data-target="#exampleModal{{$purchase->id}}" id="modalicon" class="active-a">  <i class="material-icons">
                            swap_horizontal_circle
                          </i> </a>
                          @else
                          
                          <a style="color: #344b5e" class="disabled-a">  <i class="material-icons">
                            swap_horizontal_circle
                          </i> </a>
                          @endif
                                        <!-- Modal for confirming retrieve proccess -->
                        <div class="modal fade" id="exampleModal{{$purchase->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$purchase->id}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel{{$purchase->id}}">{{__('purchases.retrieve_inv')}}</h5>
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
                        @endcan
                   
                          @can('دفع فاتورة مورد')
                          .
                          @if($purchase->status == 'pending' || $purchase->status == 'later')
                          <a style="color: #1ec92f" data-toggle="modal" data-target="#exampleModale{{$purchase->id}}" id="modalicon" class="active-a"">  <i class="material-icons">
                            payment
                          </i> </a>
                          @else
                          <a style="color: #344b5e" class="disabled-a">  <i class="material-icons">
                            payment
                          </i> </a>
                          @endif
                                            <!-- Modal for confirming pay proccess -->
                        <div class="modal fade" id="exampleModale{{$purchase->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabele{{$purchase->id}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <form action="{{route('pay.later.purchase',$purchase->id)}}" method="POST">
                                @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabele{{$purchase->id}}">{{__('purchases.pay_supplier_invoice')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true"></span>
                                </button>
                              </div>
                              <div class="modal-body">
                               <h6>  {{__('purchases.total')}} <b> {{$purchase->total_price}} </b> </h6>
                               <h6>  {{__('purchases.payed')}}  <b style="color: #48a44c"> {{$purchase->pay_amount}} </b> </h6>
                               <h6>  {{__('purchases.unpayed')}}  <b style="color: #f14000"> {{$purchase->total_price - $purchase->pay_amount}} </b> </h6>
                               <h6> {{__('purchases.complete_payment_process_by')}} : </h6>
                              </div>
                              <div style="display: flex; flex-direction: column; margin-top: -20px;" class="modal-body">
                                <div style="margin: 10px;">
                                {{__('purchases.cash_from_cashier')}} <input type="radio" id="cash-radio-{{$purchase->id}}" name="payment" value="cashier" checked> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <input style="margin-right: 20px;" id="cash-value-{{$purchase->id}}" type="number" min="0" step="0.01" name="cash_value" value="">
                                ({{__('purchases.cashier_balance')}}  {{$repository->balance}})
                                </div>
                                <div style="margin: 10px;">
                                {{__('purchases.cash_from_external_budget')}} <input type="radio" id="external-radio-{{$purchase->id}}" name="payment" value="external">
                                <input style="margin-right: 20px;" id="external-value-{{$purchase->id}}" class="displaynone"  type="number" min="0" step="0.01" name="external_value" value="">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                @if($purchase->status == 'later')
                                <button type="submit" name="action" value="pay_later" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                @elseif($purchase->status == 'pending')
                                <button type="submit" name="action" value="pay_pending" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                @endif
                              </form>
                            </div>
                              </div>
                            </div>
                            @endcan
                          </div>
                        </div>
                      </td>
                    </tr>           
                    @endforeach
                    @else
                    <tr>
                      <td>
                    <span id="warning" class="badge badge-warning">
                      {{__('reports.no_invoices')}}
                    </span>
                      </td>
                    </tr>
                    @endif
                    @if(isset($total_value) && isset($payed) && isset($unpayed))
                    <tr>
                     <td> <h5 style="font-weight: bold; color:#9229ac">{{__('purchases.sum')}}  {{$total_value}}</h5> </td>
                     <td></td>
                     <td> <h5 style="font-weight: bold; color:#48a44c">{{__('sales.payed')}} {{$payed}}</h5> </td>
                     <td></td>
                     <td> <h5 style="font-weight: bold; color:#f14000">{{__('sales.not_payed')}}  {{$unpayed}}</h5> </td>
                    </tr>
                    @elseif(isset($total_value))
                    <tr>
                      <td> <h5 style="font-weight: bold; color:#9229ac">{{__('purchases.sum')}}  {{$total_value}}</h5> </td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>

        {{ $purchases->links() }}

      </div>
     
    </div>
</div>

@endsection
@section('scripts')
{{-- for the Date format --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
  $("input[type=date]").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
}).trigger("change");
</script>
<script>
$('[id^=external-radio-]').on('click',function(){
  var id = $(this).attr('id').slice(15);
    $('#external-value-'+id).removeClass('displaynone');
    $('#cash-value-'+id).addClass('displaynone');
    $('#cash-value-'+id).val(null);
  })
  $('[id^=cash-radio-]').on('click',function(){
    var id = $(this).attr('id').slice(11);
    $('#cash-value-'+id).removeClass('displaynone');
    $('#external-value-'+id).addClass('displaynone');
    $('#external-value-'+id).val(null);
  })
</script>
@endsection

