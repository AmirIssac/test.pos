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
  .delivered{
    background-color: #93cb52;
  }
  .pending{
    background-color: #f4c721;
  }
  .retrieved{
    background-color: #9b9ea0;
  }
  .deleted{
    background-color: #ff4454;
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
              <h4> {{__('sales.invoice_details')}} {{$invoice->created_at}}   <span class="badge badge-success">{{$invoice->code}}</span></h4>
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
                    <?php $records = unserialize($invoice->details) ?>
                    @for($i=1;$i<count($records);$i++)
                    <tr>
                        <td>
                            {{$records[$i]['barcode']}}
                        </td>
                        <td>
                            {{$records[$i]['name_ar']}}
                        </td>
                        <td>
                            {{$records[$i]['price']}}
                        </td>
                        <td>
                            {{$records[$i]['quantity']}}
                        </td>
                    </tr>
                    @endfor
                    <tr style="font-weight: 900">
                        <td>
                          {{__('sales.total_price')}}
                        </td>
                        <td>
                          {{__('sales.discount')}}
                        </td>
                        <td>
                          {{__('sales.customer_mobile')}}  
                        </td>
                        <td>
                          {{__('sales.sales_employee')}}  
                        </td>
                        <td>
                          {{__('sales.note')}}  
                        </td>
                    </tr>
                    
                    <tr style="font-weight: 900">
                        <td>
                          {{$invoice->total_price}}
                        </td>
                        <td>
                            {{$invoice->discount}}
                        </td>
                        <td>
                            @if($invoice->phone)
                            {{$invoice->phone}}
                            @else
                            /
                            @endif  
                        </td>
                        <td>
                            {{$invoice->user->name}}  
                        </td>
                        <td>
                          @if($invoice->note)
                          {{$invoice->note}}
                          @else
                          /
                          @endif  
                        </td>
                    </tr>                
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
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
<script>
  window.onload=function(){
    $('#autofocus').focus();
    $(function () {
  $('[data-toggle="popover"]').popover()
  });
  };
  </script>
@endsection