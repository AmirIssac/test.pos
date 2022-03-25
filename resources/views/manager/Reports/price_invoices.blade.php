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


/* for the date format */
  input[type=date] {
    position: relative;
    width: 150px; height: 20px;
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
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
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
              <h4> {{__('reports.price_invoices')}} <span class="badge badge-success"></span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
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
                    {{__('sales.phone')}}  
                  </th>
                  <th>
                    {{__('reports.actions')}}
                  </th>
                  </thead>
                  <tbody>
                    <?php $i = 0 ?>
                     @if($invoices->count()>0)
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>
                            {{$invoice->code}}
                        </td>
                        <td>
                          {{$invoice->created_at}}
                        </td>
                        <td>
                            @if($invoice->phone)
                            {{$invoice->phone}}
                            @else
                            /
                            @endif
                        </td>
                      <td>
                     <a style="color: #03a4ec" href="{{route('price.invoice.details',$invoice->uuid)}}"> <i id="{{$i}}" class="material-icons eye">
                            visibility
                          </i> </a>
                          .
                          <a style="color: #060706" href="#"> <i id="{{$i}}" class="material-icons eye">
                            print
                          </i> </a>
                      </td>
                    </tr>
                    <?php ++$i ?>
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
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
        {{ $invoices->links() }}

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
@endsection