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
  
.search-btn{
    transition: all .2s ease-in-out;
}
.search-btn:hover{
    transform: scale(1.1);
}

input[type=date]{
    width: 25%;
    border: 2px solid #007bff !important;
}
</style>
@endsection
@section('body')
<div class="main-panel">
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
   
<div class="content">
    @if (session('fail'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('fail') }}</strong>
    </div>
    @endif
    @if(!request()->query('fromDate'))
   ابحث بتاريخ محدد
   @endif
  <form action="{{route('show.supplier.payments',$supplier->id)}}" method="GET">
    @csrf
    <div style="display: flex">
    
    @if(request()->query('fromDate'))
    <h6>من
        {{request()->query('fromDate')}}
    </h6> 
    @else
    <h6>من
    </h6> 
    <input type="date" name="fromDate" class="form-control" required>
    @endif
    
    </div>
    <div style="display: flex; margin-top:10px;">
    @if(request()->query('toDate'))
    <h6>الى
        {{request()->query('toDate')}}
    </h6> 
    @else
    <h6>الى</h6>  
    <input type="date" name="toDate" class="form-control" required>
    @endif
    </div>
    @if(!request()->query('fromDate'))
    <button style="margin: 10px;" type="submit" class="btn btn-primary search-btn">ابحث
      <i class="material-icons">search</i>
    </button>
    @endif
  </form>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> مشتريات {{$supplier->name}} 
              </h4>
              {{--
              @if(request()->query('month'))
              {{__('settings.month')}} {{request()->query('month')}} 
              @endif
              @if(request()->query('year'))
              {{__('settings.year')}} {{request()->query('year')}}
              @endif
              --}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        مدفوع 
                      </th>
                      <th>
                        غير مدفوع
                      </th>
                      <th>
                          اجمالي
                      </th>
                  </thead>
                  <tbody>
                   <tr>
                    <td>
                        {{$payed}}
                    </td>
                    <td>
                      {{$unpayed}}
                    </td>
                   <td>
                    {{$payed+$unpayed}}
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