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
.delivered{
    background-color: #001bb7;
  }
  .pending{
    background-color: #007bff;
  }
  .retrieved{
    background-color: #9b9ea0;
  }
  .deleted{
    background-color: #c43201;
  }
  td{
    color: white !important;
    font-weight: bold
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
                      المستودع   
                    </th>
                    <th>
                        الحالة   
                    </th>
                    <th>
                      {{__('purchases.total_price')}}   
                    </th> 
                  <th>
                    {{__('reports.actions')}}
                </th>
                  </thead>
                  <tbody>
                     @if($exports->count()>0)
                    @foreach($exports as $export)
                    @if($export->status == 'pending')
                    <tr class="pending">
                      @elseif($export->status == 'delivered')
                      <tr class="delivered">
                        @elseif($export->status == 'refused')
                          <tr class="deleted">
                            @elseif($export->status == 'retrieved')
                          <tr class="retrieved">
                        @endif
                        <td>
                            {{$export->code}}
                        </td>
                        <td>
                          {{$export->updated_at}}
                        </td>
                        <td>
                            {{$export->repository_sender->name}}
                        </td>
                       <td>
                           {{$export->status}}
                       </td>
                        <td>
                            {{$export->total_price}}
                        </td>
                        
                      <td>
                       
                     <a style="color: white" href="{{route('show.incoming.export.details',$export->id)}}"> <i class="material-icons eye">
                            visibility
                          </i> </a>      
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
                    
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>

        {{ $exports->links() }}

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

