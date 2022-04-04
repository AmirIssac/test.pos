@extends('layouts.main')
@section('links')
<link rel="stylesheet" href="{{asset('public/alerts/style.css')}}"/>
<style>

form i:hover{
  cursor: pointer;
}
input[type="radio"]{
  background-color: #93cb52;
}
/*
.blank{
  background-color: white !important;
  border: 2px solid white !important;
  border-radius:10px;
}*/
.ajaxSuccess{
  background-color: rgb(41, 206, 41) !important;
  color: white;
}
input[name=date]{
    border: 1px solid white;
  }
  
  #code,#tax_code,#customer_name,#customer_phone{
    border: 1px solid white;
  }
#invoices,#recipe{
  display: none;
}
.hidden{
    visibility: hidden;
  }
  .visible{
    visibility: visible;
  }
  .displaynone{
    display: none;
  }
  
  #total_price,#final_total_price,#taxfield{
    font-size: 32px;
    background-color: white !important;
  }
  #myTable{
    text-align: left;
  }
  #myTable input{
    text-align: left;
    font-weight: bold;
    border: none;
  }
  #myTable,#myTable th,#myTable td{
    border: 2px solid #001bb7;
  }
  #myTable th{
   color: black;
   font-weight: bold;
  }
  #myTable{
    direction: ltr;
  }
  .add-box-table{
    border: 2px solid #001bb7;
    margin:10px;
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
#buttons{
  display: flex;
}
#toggle-invoices{
  margin-top: 10px;
  background-color: #001bb7;
  color: white;
  font-weight: bold;
  width: 157px;
}
#toggle-recipe{
  margin-top: 10px;
  background-color: #001bb7;
  color: white;
  font-weight: bold;
  width: 157px;
}

.delete:hover{
  cursor: pointer;
}
select{
  font-size: 32px;
  font-weight: bold;
}
#tooltip:hover{
  cursor: default;
}
#plus-recipe{
  margin-top: 10px;
  background-color: #001bb7;
  color: white;
  font-size: 16px;
  margin-right: 17px;
  width: 157px;
  border-radius: 2px;
}
#plus-recipe:hover{
  cursor: pointer;
  background-color: #001bb7;
  color:white;
}
.table-c {
  overflow: hidden

        }
        /*
.yesNo{
  height: 20px;
  width: 120px;
  font-size: 1rem;
  margin-top: 8px;
}

.yesNo::before {
  content: "no";
  padding: 0.5rem 1rem;
  border: 2px solid #0d6efd;
  background-color: #f24336;
  color: white;
}

.yesNo::after {
  content: "yes";
  padding: 0.5rem 1rem;
  border: 2px solid #0d6efd;
  background-color: rgb(255, 255, 255);
  color: black;
}

.yesNo:checked::before {
  border: 2px solid #0d6efd;
  background-color: white;
  color: blue;
}

.yesNo:checked::after {
  border: 2px solid #0d6efd;
  background-color: rgb(12, 190, 66);
  color: white;
}
*/

.yesNo {
    width: 12mm;
    height: 12mm;
    border: 0.1mm solid black;
}

.yesNo:checked {
    background-color: #001bb7;
}

input[type=text]{
  border: 1px solid #0d6efd !important;
}
input[type=number]{
  border: 1px solid #0d6efd !important;
}
select{
  border: 1px solid #0d6efd !important;
}
input:read-only{
  border: none !important;
}
#cashVal,#cardVal,#stcVal{
  border: 1px solid #001bb7;
  width: 150px;
  height: 30px;
  font-size: 20px;
}
#cashVal:focus,#cardVal:focus,#stcVal:focus{
  background-color: #3dfd0d;
}
#max-field,#discount-by-value{
  border: 1px solid #001bb7;
  width: 150px;
  height: 30px;
  font-size: 20px;
}
#recipe,#invoices,#data-invoice{
  border: 2px solid #001bb7;
  margin: 10px;
}
#data-invoice *{
  font-weight: bold;
}
#recipe .card-header,#invoices .card-header,#data-invoice .card-header,.add-box-table .card-header{
  background-color: #0d6efd;
  color: white;
  font-weight: bold;
}
.red{
  background-color: #f14000;
}
.red:focus{
  background-color: #f14000;
}
.green{
  background-color: greenyellow;
}
.green:focus{
  background-color: greenyellow;
}
input[id^=recipe_name]::placeholder{ /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: red;
  opacity: 1; /* Firefox */
  font-weight: bold;
}
input[id^=recipe_name]::-ms-input-placeholder{
  color: red;
  opacity: 1; /* Firefox */
  font-weight: bold;
}
@media print{
 /* body, html, #myform { 
          height: 100%;
      }*/
      body * {
    visibility: hidden;
  }
  #print-content, #print-content * {
    visibility: visible;
  }
  #print-content {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
@endsection
@section('body')

<div class="main-panel">
 
 <div class="content" id="content">
  @if (session('sellSuccess'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('sellSuccess') }}</strong>
  </div>
  @endif
  @if (session('saveSuccess'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('saveSuccess') }}</strong>
  </div>
  @endif
  @if (session('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('fail') }}</strong>
  </div>
  @endif
  @if (session('failCustomer'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('failCustomer') }}</strong>
  </div>
  @endif
  @if (session('hasSavedRecipeAlready'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('hasSavedRecipeAlready') }}</strong>
  </div>
  @endif
  @if (session('failPayment'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('failPayment') }}</strong>
  </div>
  @endif
  
  <div  class="container-fluid">
           @if(isset($date) && $date == 'custom')
           <form method="GET" action="{{route('create.old.special.invoice',$repository->id)}}">
            @csrf
            <input type="hidden" name="old" value="yes">
            @else
            <form method="GET" action="{{route('create.special.invoice',$repository->id)}}">
              @csrf
            @endif
    <div class="row">

     {{-- <form method="GET" action="{{route('create.special.invoice',$repository->id)}}">
        @csrf --}}
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{--العميل <span class="badge badge-success"> {{isset($customer_name)?$customer_name:''}} </span>
              <span>الجوال <span class="badge badge-success">{{isset($phone)?$phone:''}}</span></span>--}}
              @if(isset($new))
              @if($new)
              <span class="badge badge-info">{{__('sales.new_customer')}}</span>
              @else
              <span class="badge badge-success">{{__('sales.exist_customer')}}</span>
              @endif
              @else
              {{__('sales.search')}}
              @endif
            </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>
                    {{__('sales.phone')}}  
                  </th>
                  @if(!request()->query('phone'))
                  <th class="hidden">
                    {{__('sales.name')}}  
                  </th>
                  @else
                  <th>
                    {{__('sales.name')}}  
                  </th>
                  @endif
                  <th>
                    {{__('sales.search/add')}}  
                  </th>
                </thead>
                <tbody>
               <tr>
                <td>
                  <input type="phone" name="phone" value="{{isset($phone)?$phone:''}}" class="form-control" placeholder="{{__('sales.type_here_input_new_cust')}}" required autofocus>
                </td>
                @if(!request()->query('phone'))
                 <td>
                   <input type="text" name="name" id="customerName" value="{{isset($customer_name)?$customer_name:''}}" class="form-control displaynone">
                   <div>
                @else
                <td>
                  <input type="text" name="name" id="customerName" value="{{isset($customer_name)?$customer_name:''}}" class="form-control">
                  <div>
                 @endif
                   @if(isset($name_generated))
                    @if($name_generated)
                    <span class="badge badge-warning">{{__('sales.generated_name')}}</span>
                    @endif
                    @endif
                   </div>
                 </td>
                <td>
                  <button type="submit" class="btn btn-primary"> {{__('sales.search/add')}} </button>
                </td>
               </tr>
         </tbody>
       </table>
   </div>
</div>
</div>
  </div>
  </form>
    </div>
  </div>

  {{--
  <div  class="container-fluid">
    <div class="row"> --}}
  <div class="col-md-12"> 
    <button class="btn btn-secondary dropdown-toggle" type="button" id="toggle-invoices" >
      {{__('sales.previous_sales')}}  
  </button>
    <div id="invoices" class="card">
      <div class="card-header card-header-primary">
        @isset($invoices)
        @if($invoices)
        <h4 class="card-title "> {{__('sales.previous_sales')}} {{$invoices->count()}}</h4>
        @endisset
        @else
        <h4 class="card-title "> {{__('sales.no_previous_sales')}} </h4>
        @endif
      </div>
      @isset($invoices)
      @if($invoices)
      <div class="card-body">
        <div class="table-responsive">
          <table  class="table">
            <thead class="text-primary">
              <th>
                {{__('sales.branch')}} 
              </th>
              <th>
                {{__('settings.address')}} 
              </th>
              <th>
                {{__('sales.invoice_code')}} 
              </th>
              <th>
                {{__('sales.invoice_status')}} 
              </th>
              <th>
                {{__('sales.total_price')}}
              </th>
              <th>
                {{__('sales.prescription')}}
              </th>
              <th>
                {{__('sales.date')}}
              </th>
              <th>
                {{__('sales.sales_employee')}} 
              </th>
            </thead>
            <tbody>
              @foreach ($invoices as $invoice)
           <tr>
            <td>
              {{$invoice->repository->name}}
            </td>
            <td>
              {{$invoice->repository->address}}
            </td>
            <td>
              {{$invoice->code}}
            </td>
            <td>
              @if($invoice->status == 'delivered')
              {{__('sales.del_badge')}} 
              @elseif($invoice->status == 'pending')
              {{__('sales.hang_badge')}}
              @elseif($invoice->status == 'retrieved')
              {{__('sales.retrieve')}}
              @endif
            </td>
            <td>
              {{$invoice->total_price}}
            </td>
            <td>
              <?php $rec = unserialize($invoice->recipe) ?>
              @if(array_key_exists('name', $rec))
              {{$rec['name']}}
              @else
              {{__('sales.basic_prescription')}}
              @endif
            </td>
            <td>
              {{$invoice->created_at}}
            </td>
            <td>
              {{$invoice->user->name}}
            </td>
           </tr>
           @endforeach
     </tbody>
   </table>
  </div>
  </div>
  @endif
  @endisset
  </div>
  </div>
    
  
{{--<form action="{{route('sell.special.invoice',$repository->id)}}" method="POST">--}}
  <div id="print-content">
    @if(isset($date) && $date == 'custom')
           <form id="sell-form" action="{{route('save.old.special.invoice',$repository->id)}}" method="POST">
            @csrf
            @else
            <form id="sell-form" action="{{route('sell.special.invoice',$repository->id)}}" method="POST">
            @csrf
    @endif
  <div class="col-md-12">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="toggle-recipe" >
      {{__('sales.prescription')}} 
  </button>
  @if(isset($saved_recipes) && $saved_recipes->count()>0)
  <div id="recipe" class="card">
  @else
    <div id="recipe" class="card">
      @endif
      <div class="card-header card-header-primary">
        <h4 class="card-title ">  {{__('sales.prescription')}}  </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="myTable" class="table table-bordered">
            <thead class="text-primary">
              @if(isset($saved_recipes)  && $saved_recipes->count()>0)
              <span class="badge badge-success"> {{__('sales.archived')}}  </span>
              @endif
              <th style="text-align: center; font-weight: bold; font-size: 18px;">
                EYE 
              </th>
              <th>
                SPH  
              </th>
              <th>
                CYL  
               </th>   
               <th>
                Axis  
              </th>
              <th>
                ADD  
              </th>
            </thead>
            <tbody>
              @if(isset($saved_recipes) && $saved_recipes->count()>0)
              @foreach($saved_recipes as $saved_recipe)
              @if($saved_recipe->name == null)
              <?php $saved_recipe = unserialize($saved_recipe->recipe) ?>
           <tr>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              RIGHT
            </td>
            <td>
              <select name="sph_r" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==$saved_recipe['sph_r'] && $i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i==$saved_recipe['sph_r'] && $i<=0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i!=$saved_recipe['sph_r'] && $i>0))
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="sph_r" value="{{$saved_recipe['sph_r']}}">--}}
            </td>
            <td>
              <select name="cyl_r" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==$saved_recipe['cyl_r'] && $i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i==$saved_recipe['cyl_r'] && $i<=0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i!=$saved_recipe['cyl_r'] && $i>0))
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_r" value="{{$saved_recipe['cyl_r']}}">--}}
            </td>
            <td>
              {{--<select name="axis_r" class="form-control">
                @for($i=180;$i>=0;$i-=1)
                @if($i==$saved_recipe['axis_r'] && $i>0)
                <option value="{{$i}}" selected>+{{$i}}</option>
                @elseif($i==$saved_recipe['axis_r'] && $i==0)
                <option value="{{$i}}" selected>{{$i}}</option>
                @elseif($i!=$saved_recipe['axis_r'] && $i>0))
                <option value="{{$i}}">+{{$i}}</option>
                @else
                <option value="{{$i}}">{{$i}}</option>
                @endif
                @endfor
              </select>--}}
              <input type="number" step="1" max="180" name="axis_r" value="{{$saved_recipe['axis_r']}}" class="form-control" required>
              </td>
            <td>
              <select name="add_r" class="form-control" required>
                @for($i=20.00;$i>=0;$i-=0.25)
                @if($i==$saved_recipe['add_r'] && $i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i==$saved_recipe['add_r'] && $i==0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i!=$saved_recipe['add_r'] && $i>0))
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="0" max="20" name="add_r" value="{{$saved_recipe['add_r']}}">--}}
            </td>
           </tr>
           <tr>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              LEFT
            </td>
            <td>
              <select name="sph_l" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==$saved_recipe['sph_l'] && $i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i==$saved_recipe['sph_l'] && $i<=0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i!=$saved_recipe['sph_l'] && $i>0))
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
             {{-- <input type="number" step="0.25" min="-20" max="20" name="sph_l" value="{{$saved_recipe['sph_l']}}"> --}}
            </td>
            <td>
              <select name="cyl_l" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==$saved_recipe['cyl_l'] && $i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i==$saved_recipe['cyl_l'] && $i<=0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i!=$saved_recipe['cyl_l'] && $i>0))
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_l" value="{{$saved_recipe['cyl_l']}}">--}}
            </td>
            <td>
              {{--<select name="axis_l" class="form-control">
                @for($i=180;$i>=0;$i-=1)
                @if($i==$saved_recipe['axis_l'] && $i>0)
                <option value="{{$i}}" selected>+{{$i}}</option>
                @elseif($i==$saved_recipe['axis_l'] && $i==0)
                <option value="{{$i}}" selected>{{$i}}</option>
                @elseif($i!=$saved_recipe['axis_l'] && $i>0))
                <option value="{{$i}}">+{{$i}}</option>
                @else
                <option value="{{$i}}">{{$i}}</option>
                @endif
                @endfor
              </select>--}}
              <input type="number" min="0" max="180" name="axis_l" value="{{$saved_recipe['axis_l']}}" class="form-control" required>
            </td>
            <td>
              <select name="add_l" class="form-control" required>
                @for($i=20.00;$i>=0;$i-=0.25)
                @if($i==$saved_recipe['add_l'] && $i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i==$saved_recipe['add_l'] && $i==0)
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i!=$saved_recipe['add_l'] && $i>0))
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="0" max="20" name="add_l" value="{{$saved_recipe['add_l']}}">--}}
            </td>
           </tr>
           <tr>
            <td style="border: none">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              IPD distance
            </td>
            <td>
              <input type="number" min="0" max="100" name="ipdval" value="{{$saved_recipe['ipd']}}" class="form-control" required>
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              IPD near
            </td>
             <td>
              <input type="number" min="0" max="100" name="ipd2val" value="{{isset($saved_recipe['ipd2']) ? $saved_recipe['ipd2'] : 0}}" class="form-control" required>
             </td>
           </tr>
           <tr>
            <td style="border: none">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              {{__('sales.prescription_source')}}
           </td>
           <td>
             <select name="recipe_source" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
              @if(isset($saved_recipe['recipe_source']))
               @if($saved_recipe['recipe_source'] == 'customer')
               <option value="customer" selected>{{__('sales.customer')}}</option>
               @foreach($checkers as $checker)
                 <option value="{{$checker->id}}">{{$checker->name}}</option>
               @endforeach
               @else {{-- not customer --}}
               <option value="customer">{{__('sales.customer')}}</option>
               @foreach($checkers as $checker)
                 @if($saved_recipe['recipe_source'] == $checker->id)
                 <option value="{{$checker->id}}" selected>{{$checker->name}}</option>
                 @else
                 <option value="{{$checker->id}}">{{$checker->name}}</option>
                 @endif
               @endforeach
               @endif
               @else
               <option value="customer" selected>{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
               @endif
             </select>
           </td>
           <td style="text-align: center; font-weight: bold; font-size: 18px;">
             {{__('sales.ipd_source')}}
           </td>
           <td>
             <select name="ipd_source" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
              @if(isset($saved_recipe['ipd_source']))
              @if($saved_recipe['ipd_source'] == 'customer')
              <option value="customer" selected>{{__('sales.customer')}}</option>
              @foreach($checkers as $checker)
                <option value="{{$checker->id}}">{{$checker->name}}</option>
              @endforeach
              @else {{-- not customer --}}
              <option value="customer">{{__('sales.customer')}}</option>
              @foreach($checkers as $checker)
                @if($saved_recipe['ipd_source'] == $checker->id)
                <option value="{{$checker->id}}" selected>{{$checker->name}}</option>
                @else
                <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endif
              @endforeach
              @endif
              @else
              <option value="customer" selected>{{__('sales.customer')}}</option>
              @foreach($checkers as $checker)
                <option value="{{$checker->id}}">{{$checker->name}}</option>
              @endforeach
              @endif
             </select>
           </td>
          </tr>
           @endif
           @endforeach
           @else
           <tr>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              RIGHT
            </td>
            <td>
              <select name="sph_r" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
             {{-- <input type="number" step="0.25" min="-20" max="20" name="sph_r" value="0"> --}}
            </td>
            <td>
              <select name="cyl_r" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_r" value="0">--}}
            </td>
            <td>
              <input type="number" min="0" max="180" name="axis_r" value="" class="form-control">
            </td>
            <td>
              <select name="add_r" class="form-control" required>
                @for($i=20.00;$i>=0;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="0" max="20" name="add_r" value="0">--}}
            </td>
           </tr>
           <tr>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              LEFT
            </td>
            <td>
              <select name="sph_l" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="sph_l" value="0">--}}
            </td>
            <td>
              <select name="cyl_l" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_l" value="0">--}}
            </td>
            <td>
             
             <input type="number" min="0" max="180" name="axis_l" value="" class="form-control">
            </td>
            <td>
              {{--<input type="text" list="addl" min="0" max="20.00" step="0.25">
              <datalist id="addl">--}}
                <select name="add_l" class="form-control" required>
                @for($i=20.00;$i>=0;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
                </select>
              {{--</datalist>--}}
              
              {{--<input type="number" step="0.25" min="0" max="20" name="add_l" value="0">--}}
            </td>
           </tr>
           <tr>
            <td style="border: none">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              IPD distance
            </td>
            <td>
              <input type="number" min="0" max="100" name="ipdval" value="" class="form-control">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              IPD near
            </td>
             <td>
              <input type="number" min="0" max="100" name="ipd2val" value="" class="form-control">
             </td>
           </tr>
           <tr>
             <td style="border: none">
             </td>
             <td style="text-align: center; font-weight: bold; font-size: 18px;">
              {{__('sales.prescription_source')}}
            </td>
            <td>
              <select name="recipe_source" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
                <option value="customer">{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
              </select>
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              {{__('sales.ipd_source')}}
            </td>
            <td>
              <select name="ipd_source" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
                <option value="customer">{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
              </select>
            </td>
           </tr>
           @endif
     </tbody>
   </table>
</div>
</div>
</div>
</div>

<select id="plus-recipe" name="recipe_radio">   {{--  we change the system to take all recipes from the index and going back --}}
<option value="0" selected> {{__('sales.additional_recipes')}}
</option>  {{-- value=0 mean its the basic recipe --}}
<?php $additional_archived = 0; ?>  {{-- first we display archived additional recipes --}}
@if(isset($saved_recipes))
@foreach($saved_recipes as $saved_recipe)
@if($saved_recipe->name != null)
<?php
 $additional_archived += 1;
 $nickname = $saved_recipe->name; // to take name
 $saved_recipe = unserialize($saved_recipe->recipe) ?>
 <option value="{{$additional_archived}}">{{$nickname}}-{{$additional_archived}}</option>
 @endif
 @endforeach
 @endif
 @for ($t=$additional_archived + 1 ; $t<6 ; $t++)
 <option value="{{$t}}"> {{__('sales.new_prescription')}}-{{$t}}</option>
 @endfor
</select>



{{--<button style="margin-right: 15px;" id="plus-recipe" type="button" class="btn">اضافة وصفة أخرى</button>--}}
<?php $additional_archived = 0; ?>  {{-- first we display archived additional recipes --}}
@if(isset($saved_recipes))
@foreach($saved_recipes as $saved_recipe)
@if($saved_recipe->name != null)
<?php
 $additional_archived += 1;
 $nickname = $saved_recipe->name; // to take name
 $saved_recipe = unserialize($saved_recipe->recipe) ?>
 <div class="col-md-12 displaynone" id='extra-recipe{{$additional_archived}}'>
  <div class="card add-box-table">
    <div class="card-header card-header-primary">
      <h4 class="card-title ">  {{__('sales.prescription')}}  </h4>
      <span class="badge badge-success">{{$nickname}}</span>
      <input type="hidden" id="recipe_name{{$additional_archived}}" name="recipe_name[]" value="{{$nickname}}" placeholder="اكتب الاسم هنا (الزامي)">
     {{-- <input type="radio" name="recipe_radio" value="{{$additional_archived}}"> --}}{{-- to determine which recipe we are doing sell proccess now --}}
    </div>                                {{-- we determine the index of arr from the recipe radio in controller --}}
    <div class="card-body">
      <div class="table-responsive">
        <table id="myTable" class="table table-bordered">
          <thead class="text-primary">
            <th style="text-align: center; font-weight: bold; font-size: 18px;">
              EYE
            </th>
            <th>
              SPH  
            </th>
            <th>
              CYL  
             </th>   
             <th>
              Axis  
            </th>
            <th>
              ADD  
            </th>
          </thead>
          <tbody>
            <tr>
              <td style="text-align: center; font-weight: bold; font-size: 18px;">
                RIGHT
              </td>
              <td>
                <select name="sph_r_arr[]" class="form-control" required>
                  @for($i=20.00;$i>=-20.00;$i-=0.25)
                  @if($i==$saved_recipe['sph_r'] && $i>0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i==$saved_recipe['sph_r'] && $i<=0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i!=$saved_recipe['sph_r'] && $i>0))
                  <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                  @else
                  <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                  @endif
                  @endfor
                </select>
                {{--<input type="number" step="0.25" min="-20" max="20" name="sph_r" value="{{$saved_recipe['sph_r']}}">--}}
              </td>
              <td>
                <select name="cyl_r_arr[]" class="form-control" required>
                  @for($i=20.00;$i>=-20.00;$i-=0.25)
                  @if($i==$saved_recipe['cyl_r'] && $i>0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i==$saved_recipe['cyl_r'] && $i<=0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i!=$saved_recipe['cyl_r'] && $i>0))
                  <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                  @else
                  <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                  @endif
                  @endfor
                </select>
                {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_r" value="{{$saved_recipe['cyl_r']}}">--}}
              </td>
              <td>
                {{--<select name="axis_r" class="form-control">
                  @for($i=180;$i>=0;$i-=1)
                  @if($i==$saved_recipe['axis_r'] && $i>0)
                  <option value="{{$i}}" selected>+{{$i}}</option>
                  @elseif($i==$saved_recipe['axis_r'] && $i==0)
                  <option value="{{$i}}" selected>{{$i}}</option>
                  @elseif($i!=$saved_recipe['axis_r'] && $i>0))
                  <option value="{{$i}}">+{{$i}}</option>
                  @else
                  <option value="{{$i}}">{{$i}}</option>
                  @endif
                  @endfor
                </select>--}}
                <input type="number" step="1" max="180" name="axis_r_arr[]" value="{{$saved_recipe['axis_r']}}" class="form-control" required>
                </td>
              <td>
                <select name="add_r_arr[]" class="form-control" required>
                  @for($i=20.00;$i>=0;$i-=0.25)
                  @if($i==$saved_recipe['add_r'] && $i>0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i==$saved_recipe['add_r'] && $i==0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i!=$saved_recipe['add_r'] && $i>0))
                  <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                  @else
                  <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                  @endif
                  @endfor
                </select>
                {{--<input type="number" step="0.25" min="0" max="20" name="add_r" value="{{$saved_recipe['add_r']}}">--}}
              </td>
             </tr>
             <tr>
              <td style="text-align: center; font-weight: bold; font-size: 18px;">
                LEFT
              </td>
              <td>
                <select name="sph_l_arr[]" class="form-control" required>
                  @for($i=20.00;$i>=-20.00;$i-=0.25)
                  @if($i==$saved_recipe['sph_l'] && $i>0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i==$saved_recipe['sph_l'] && $i<=0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i!=$saved_recipe['sph_l'] && $i>0))
                  <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                  @else
                  <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                  @endif
                  @endfor
                </select>
               {{-- <input type="number" step="0.25" min="-20" max="20" name="sph_l" value="{{$saved_recipe['sph_l']}}"> --}}
              </td>
              <td>
                <select name="cyl_l_arr[]" class="form-control" required>
                  @for($i=20.00;$i>=-20.00;$i-=0.25)
                  @if($i==$saved_recipe['cyl_l'] && $i>0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i==$saved_recipe['cyl_l'] && $i<=0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i!=$saved_recipe['cyl_l'] && $i>0))
                  <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                  @else
                  <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                  @endif
                  @endfor
                </select>
                {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_l" value="{{$saved_recipe['cyl_l']}}">--}}
              </td>
              <td>
                {{--<select name="axis_l" class="form-control">
                  @for($i=180;$i>=0;$i-=1)
                  @if($i==$saved_recipe['axis_l'] && $i>0)
                  <option value="{{$i}}" selected>+{{$i}}</option>
                  @elseif($i==$saved_recipe['axis_l'] && $i==0)
                  <option value="{{$i}}" selected>{{$i}}</option>
                  @elseif($i!=$saved_recipe['axis_l'] && $i>0))
                  <option value="{{$i}}">+{{$i}}</option>
                  @else
                  <option value="{{$i}}">{{$i}}</option>
                  @endif
                  @endfor
                </select>--}}
                <input type="number" min="0" max="180" name="axis_l_arr[]" value="{{$saved_recipe['axis_l']}}" class="form-control" required>
              </td>
              <td>
                <select name="add_l_arr[]" class="form-control" required>
                  @for($i=20.00;$i>=0;$i-=0.25)
                  @if($i==$saved_recipe['add_l'] && $i>0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>+{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i==$saved_recipe['add_l'] && $i==0)
                  <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                  @elseif($i!=$saved_recipe['add_l'] && $i>0))
                  <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                  @else
                  <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                  @endif
                  @endfor
                </select>
                {{--<input type="number" step="0.25" min="0" max="20" name="add_l" value="{{$saved_recipe['add_l']}}">--}}
              </td>
             </tr>
             <tr>
              <td style="border: none">
              </td>
              <td style="text-align: center; font-weight: bold; font-size: 18px;">
                IPD distance
              </td>
              <td>
                <input type="number" min="0" max="100" name="ipdval_arr[]" value="{{$saved_recipe['ipd']}}" class="form-control" required>
              </td>
              <td style="text-align: center; font-weight: bold; font-size: 18px;">
                IPD near
              </td>
               <td>
                <input type="number" min="0" max="100" name="ipd2val_arr[]" value="{{isset($saved_recipe['ipd2']) ? $saved_recipe['ipd2'] : 0}}" class="form-control" required>
               </td>
             </tr>
             <tr>
              <td style="border: none">
              </td>
              <td style="text-align: center; font-weight: bold; font-size: 18px;">
                {{__('sales.prescription_source')}}
              </td>
             <td>
               <select name="recipe_source_arr[]" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
                @if(isset($saved_recipe['recipe_source']))
                @if($saved_recipe['recipe_source'] == 'customer')
                <option value="customer" selected>{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
                @else {{-- not customer --}}
                <option value="customer">{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  @if($saved_recipe['recipe_source'] == $checker->id)
                  <option value="{{$checker->id}}" selected>{{$checker->name}}</option>
                  @else
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                  @endif
                @endforeach
                @endif
                @else
                <option value="customer" selected>{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
                @endif
               </select>
             </td>
             <td style="text-align: center; font-weight: bold; font-size: 18px;">
              {{__('sales.ipd_source')}}
            </td>
             <td>
               <select name="ipd_source_arr[]" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
                @if(isset($saved_recipe['ipd_source']))
                @if($saved_recipe['ipd_source'] == 'customer')
                <option value="customer" selected>{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
                @else {{-- not customer --}}
                <option value="customer">{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  @if($saved_recipe['ipd_source'] == $checker->id)
                  <option value="{{$checker->id}}" selected>{{$checker->name}}</option>
                  @else
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                  @endif
                @endforeach
                @endif
                @else
                <option value="customer" selected>{{__('sales.customer')}}</option>
                @foreach($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}}</option>
                @endforeach
                @endif
               </select>
             </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
 </div>
 @endif
 @endforeach
 @endif
@for ($t=$additional_archived + 1 ; $t<6 ; $t++)
<div class="col-md-12 displaynone" id='extra-recipe{{$t}}'>
<div class="card add-box-table">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">  {{__('sales.prescription')}}  </h4>
    <input type="text" id="recipe_name{{$t}}" name="recipe_name[]" placeholder="اكتب الاسم هنا (الزامي)">
   {{-- <input type="radio" name="recipe_radio" value="{{$t}}"> --}} {{-- to determine which recipe we are doing sell proccess now --}}
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="myTable" class="table table-bordered">
        <thead class="text-primary">
          <th style="text-align: center; font-weight: bold; font-size: 18px;">
            EYE 
          </th>
          <th>
            SPH  
          </th>
          <th>
            CYL  
           </th>   
           <th>
            Axis  
          </th>
          <th>
            ADD  
          </th>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              RIGHT
            </td>
            <td>
              <select name="sph_r_arr[]" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
             {{-- <input type="number" step="0.25" min="-20" max="20" name="sph_r" value="0"> --}}
            </td>
            <td>
              <select name="cyl_r_arr[]" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_r" value="0">--}}
            </td>
            <td>
              <input type="number" min="0" max="180" name="axis_r_arr[]" value="" class="form-control">
            </td>
            <td>
              <select name="add_r_arr[]" class="form-control" required>
                @for($i=20.00;$i>=0;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="0" max="20" name="add_r" value="0">--}}
            </td>
           </tr>
           <tr>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              LEFT
            </td>
            <td>
              <select name="sph_l_arr[]" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="sph_l" value="0">--}}
            </td>
            <td>
              <select name="cyl_l_arr[]" class="form-control" required>
                @for($i=20.00;$i>=-20.00;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
              </select>
              {{--<input type="number" step="0.25" min="-20" max="20" name="cyl_l" value="0">--}}
            </td>
            <td>
             
             <input type="number" min="0" max="180" name="axis_l_arr[]" value="" class="form-control">
            </td>
            <td>
              {{--<input type="text" list="addl" min="0" max="20.00" step="0.25">
              <datalist id="addl">--}}
                <select name="add_l_arr[]" class="form-control" required>
                @for($i=20.00;$i>=0;$i-=0.25)
                @if($i==0)  {{-- default value --}}
                <option value="{{number_format((float)$i, 2, '.', '')}}" selected>{{number_format((float)$i, 2, '.', '')}}</option>
                @elseif($i>0)
                <option value="{{number_format((float)$i, 2, '.', '')}}">+{{number_format((float)$i, 2, '.', '')}}</option>
                @else
                <option value="{{number_format((float)$i, 2, '.', '')}}">{{number_format((float)$i, 2, '.', '')}}</option>
                @endif
                @endfor
                </select>
              {{--</datalist>--}}
              
              {{--<input type="number" step="0.25" min="0" max="20" name="add_l" value="0">--}}
            </td>
           </tr>
           <tr>
            <td style="border: none">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              IPD distance
            </td>
            <td>
              <input type="number" min="0" max="100" name="ipdval_arr[]" value="" class="form-control">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              IPD near
            </td>
             <td>
              <input type="number" min="0" max="100" name="ipd2val_arr[]" value="" class="form-control">
             </td>
           </tr>
           <tr>
            <td style="border: none">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              {{__('sales.prescription_source')}}
           </td>
           <td>
             <select name="recipe_source_arr[]" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
               <option value="customer">{{__('sales.customer')}}</option>
               @foreach($checkers as $checker)
                 <option value="{{$checker->id}}">{{$checker->name}}</option>
               @endforeach
             </select>
           </td>
           <td style="text-align: center; font-weight: bold; font-size: 18px;">
            {{__('sales.ipd_source')}}
          </td>
           <td>
             <select name="ipd_source_arr[]" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px;">
               <option value="customer">{{__('sales.customer')}}</option>
               @foreach($checkers as $checker)
                 <option value="{{$checker->id}}">{{$checker->name}}</option>
               @endforeach
             </select>
           </td>
          </tr>
     </tbody>
   </table>
</div>
</div>
</div>
</div>
@endfor
  {{--</div>--}}
  


      
      <div class="col-md-12">
        <div class="card" id="data-invoice">
          <div class="card-header">
            {{--<h4 class="card-title ">الفاتورة <input type="text" name="date" value="{{isset($date)?$date:''}}" readonly>
              العميل<input type="text" name="customer_name" id="customer_name" value="{{isset($customer_name)?$customer_name:''}}" readonly>
              الجوال<input type="text" name="customer_phone" id="customer_phone" value="{{isset($phone)?$phone:''}}" readonly>
            </h4>--}}
            @if(isset($date) && $date == 'custom')
            <h4>{{__('sales.plz_input_date_invoice')}}</h4>
            <input type="datetime-local" name="date" class="form-control">
            @else
            <input style="display: none" type="text" name="date" value="{{isset($date)?$date:''}}" readonly>
            @endif
            <input style="display: none" type="text" name="customer_phone" id="customer_phone" value="{{isset($phone)?$phone:''}}" readonly>
            <input type="hidden" name="customer_name" id="customerN" value="{{isset($customer_name)?$customer_name:''}}">
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-c">
                <thead class="text-primary">
                      <input style="display: none" type="text" name="code" id="code" value="{{isset($code)?$code:''}}" readonly>
                  <th style="width: 20%">
                    Barcode  
                  </th>
                  <th style="width: 40%">
                    {{__('sales.name')}}  
                  </th>
                  <th style="width: 10%">
                    {{__('sales.price')}}  
                  </th>
                  <th style="width: 10%">
                    {{__('sales.quantity')}} 
                  </th>
                  <th style="width: 10%">
                    {{__('sales.in_stock')}}
                  </th>
                  <th style="width: 10%" id="del" class="">
                    {{__('sales.delivered')}}   
                  </th>
                  <th style="width: 10%">
                    {{__('sales.total_price')}}
                  </th>
                  <th style="width: 10%">
                  </th>
                </thead>

                <tbody>
                    <tr id="record0">
                      <td>
                        <input type="hidden" name="repo_id" id="repo_id" class="form-control" value="{{$repository->id}}">
                          <input type="text" id="bar0" name="barcode[]" value="{{old('barcode0')}}"  class="form-control barcode" placeholder="{{__('sales.scanner_input')}}" id="autofocus">
                          {{-- error delay --}}
                          <input type="hidden" id="timeout0" value="">
                          <input type="hidden" id="cart-init0" value="0">

                      </td>
                      @if(LaravelLocalization::getCurrentLocale() == 'ar')
                      <td>
                        <input type="text" id="name0"  name="name[]" value="{{old('name0')}}" class="form-control name blank" readonly>
                      </td>
                      <td class="displaynone">
                       {{-- we get the english input beacause we need it in storing invoice details all --}}
                        <input type="text" id="details0"  name="details[]" value="{{old('details0')}}" class="form-control details blank" readonly>
                      </td>
                      @else
                      <td class="displaynone">
                        {{-- we get the arabic input beacause we need it in storing invoice details all --}}
                        <input type="text" id="name0"  name="name[]" value="{{old('name0')}}" class="form-control name blank" readonly>
                      </td>
                      <td>
                        <input type="text" id="details0"  name="details[]" value="{{old('details0')}}" class="form-control details blank" readonly>
                      </td>
                      @endif
                      <td style="display: none;">
                        <input type="hidden" id="cost_price0"  name="cost_price[]" value="{{old('cost_price0')}}" class="form-control blank" readonly>
                      </td>
                      <td>
                        @if($repository->setting->discount_change_price == true)
                        <input type="number" id="price0" min="0" step="0.01"  name="price[]" value="{{old('price0')}}" class="form-control price blank">
                        @else
                        <input type="number" id="price0" min="0" step="0.01"  name="price[]" value="{{old('price0')}}" class="form-control price blank" readonly>
                        @endif
                      </td>
                      <td>
                        @if(old('quantity0'))
                        <input type="number" id="quantity0" min="1" name="quantity[]" value="{{old('quantity0')}}" class="form-control quantity" placeholder="الكمية">
                        @else
                        <input type="number" id="quantity0" min="1" name="quantity[]"  class="form-control quantity" value="1" placeholder="الكمية">
                        @endif
                    </td>
                    <td>
                      <input type="text" id="ava0" name="availability[]" value=""  class="form-control availability" readonly>
                    </td>
                    <td>
                      <input type="checkbox" name="del[]" id="d0"  class="delivered hidden yesNo" value="0">  {{-- need it just in hanging invoices --}}
                      <input type="hidden" id="accept_min0">
                  </td>
                  <td>
                    <input type="number" id="sum-row0" name="sum-row[]" value=""  class="form-control" readonly>
                  </td>
                  <td>
                    <a id="delete0" class="delete"><img src="{{asset('public/img/delete-icon.jpg')}}" width="45px" height="45px"></a>
                </td>
                </tr>
                  @for ($count=1;$count<=25;$count++)
                    <tr id="record{{$count}}" class="displaynone">
                      <td>
                          <input type="text" id="bar{{$count}}" name="barcode[]" value="{{old('barcode[$count]')}}"  class="form-control barcode" placeholder="{{__('sales.scanner_input')}}" id="autofocus">
                          <input type="hidden" id="timeout{{$count}}" value="">
                          <input type="hidden" id="cart-init{{$count}}" value="0">
                      </td>
                      @if(LaravelLocalization::getCurrentLocale() == 'ar')
                      <td>{{-- الاسم بالعربي --}}
                        <input type="text" id="name{{$count}}"  name="name[]" value="{{old('name.'.$count)}}" class="form-control name blank" readonly>
                      </td>
                      <td class="displaynone">{{-- الاسم بالانكليزي --}}
                        <input type="text" id="details{{$count}}"  name="details[]" value="{{old('details.'.$count)}}" class="form-control details blank" readonly>
                      </td>
                      @else
                      <td class="displaynone">
                        <input type="text" id="name{{$count}}"  name="name[]" value="{{old('name.'.$count)}}" class="form-control name blank" readonly>
                      </td>
                      <td>
                        <input type="text" id="details{{$count}}"  name="details[]" value="{{old('details.'.$count)}}" class="form-control details blank" readonly>
                      </td>
                      @endif
                      <td style="display: none;">
                        <input type="hidden" id="cost_price{{$count}}"  name="cost_price[]" value="{{old('cost_price.'.$count)}}" class="form-control blank" readonly>
                      </td>
                      <td>
                        @if($repository->setting->discount_change_price == true)
                        <input type="number" id="price{{$count}}" min="0" step="0.01"  name="price[]" value="{{old('price.'.$count)}}" class="form-control price blank">
                        @else
                        <input type="number" id="price{{$count}}" min="0" step="0.01"  name="price[]" value="{{old('price.'.$count)}}" class="form-control price blank" readonly>
                        @endif
                      </td>
                      <td>
                        @if(old('quantity.'.$count))
                        <input type="number" id="quantity{{$count}}" min="1" name="quantity[]" value="{{old('quantity.'.$count)}}" class="form-control quantity" placeholder="الكمية">
                        @else
                        <input type="number" id="quantity{{$count}}" min="1" name="quantity[]"  class="form-control quantity" value="1" placeholder="الكمية">
                        @endif
                    </td>
                    <td>
                      <input type="text" id="ava{{$count}}" name="availability[]" value=""  class="form-control availability" readonly>
                    </td>
                    <td>
                        <input type="checkbox" name="del[]" id="d{{$count}}" value="{{$count}}"  class="delivered hidden yesNo" checked>  {{-- need it just in hanging invoices --}}
                    </td>
                    <td>
                      <input type="number" id="sum-row{{$count}}" name="sum-row[]" value=""  class="form-control" readonly>
                    </td>
                    <td>
                      <a id="delete{{$count}}" class="delete"><img src="{{asset('public/img/delete-icon.jpg')}}" width="45px" height="45px"></a>
                      <input type="hidden" id="accept_min{{$count}}">
                  </td>
                </tr>
            @endfor
         </tbody>
       </table>
       
       <div id="cash-info">
         <div style="display: flex;">
        <div>
          <h5>
            {{__('sales.sum')}} 
          </h5>
          {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
          <input type="number" name="sum" id="total_price" class="form-control" value="0" readonly>
        </div>
        <div id="tax-container">
          <h5>{{__('sales.tax')}}</h5>
         <div style="display: flex; flex-direction: column; margin-top: 3px;">
           <div style="display: flex;">
             <input type="number" name="taxprint" value="0"  id="taxfield" class="form-control" readonly>
             <input style="margin-right: 10px;" type="hidden" value="{{$repository->tax}}" name="tax" id="tax" class="form-control">
           </div>
         </div>
       </div>

       <div>
        <h5>{{__('sales.discount')}}</h5>
       <div style="display: flex; flex-direction: column; margin-top: 3px;">
         <div style="display: flex;">
          @if($repository->setting->discount_by_percent == true)
          {{--<i style="color: #001bb7" id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title=" {{__('sales.max_is')}} %{{$repository->max_discount}} ">live_help</i>--}}
           <input style="margin: 10px;" type="number" name="max_discount"  step="0.01" min="0" max="{{$repository->max_discount}}" placeholder="{{__('sales.percent')}}"  id="max-field" class="form-control">
           <input style="display:none;" type="number"  id="max-allowed" value="{{$repository->max_discount}}">
           <input type="hidden" name="discountVal" id="discountVal" value="0.00">
           <input type="hidden" name="check_discount_by_percent" value="1" id="check-discount-by-percent">
           @else
           <input style="display: none" type="number" name="max_discount" value="0" step="0.01" min="0" max="{{$repository->max_discount}}"  id="max-field" class="form-control">
           <input type="hidden" name="discountVal" id="discountVal" value="0.00">
           <input type="hidden" name="check_discount_by_percent" value="1" id="check-discount-by-percent">
          @endif
          @if($repository->setting->discount_by_value == true)
         {{-- <i style="color: #001bb7" id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('settings.discount_by_value')}}">live_help</i> --}}
           <input style="margin: 10px;" type="number" name="discount_by_value" step="0.01" min="0" placeholder="{{__('settings.discount_by_value')}}"  id="discount-by-value" class="form-control">
           <input type="hidden" name="check_discount_by_value" value="1" id="check-discount-by-value">
           @else
           <input style="display: none" type="number" name="discount_by_value" value="0" step="0.01" min="0"  id="discount-by-value" class="form-control">
           <input type="hidden" name="check_discount_by_value" value="1" id="check-discount-by-value">
          @endif
         </div>
       </div>
     </div>

          </div>

       <div>
         <h5>
          {{__('sales.total_price')}} 
         </h5>
         
         {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
         <input type="number" name="total_price" id="final_total_price" class="form-control" value="0" readonly>
         <input type="hidden" id="total_price_acc">
         <input type="hidden" id="total_price_notacc">
         <input type="hidden" id="f_total_price_acc">
         <input type="hidden" id="f_total_price_notacc">
       </div>
       </div>
       {{--<i class="material-icons">add_circle</i>--}}
       <a class="position-relative mx-3">
        <span style="color: #001bb7;" class="icon"><i style="font-size: 2em;" class="bi bi-cart"></i></span>
        <span class="position-absolute badge rounded-pill bg-success" id="cart">0</span>
      </a>

       <div id="settings">
        <div id="min" class="">
          <span class="badge badge-success hidden" id="badgecolor">   {{__('sales.min_limit_pay')}} <div id="minVal"></div></span>
         {{--<input type="hidden" class="" id="inputmin" value="{{($repository->min_payment*$invoice_total_price)/100}}">--}}
         <input type="hidden" class="" id="inputmin" value="">
         <input type="hidden" class="" id="percent" value="{{$repository->min_payment}}">

       </div>
        <div>
          <div style="display: flex; flex-direction: column; margin-top: 10px">
            <div style="display: flex;">
          <h4> &nbsp; {{__('sales.cash')}}</h4>
          <input style="margin: 7px 10px 0 0" type="checkbox" name="cash" id="cash" checked>
            </div>
          <input type="hidden" id="all_price_value">   {{-- to set value for all payment method when activate from this input --}}
          <input style="margin-right: 0px" type="number" min="0.0000001" step="0.0000001" name="cashVal" id="cashVal" value="" placeholder="{{__('settings.input_cash_here')}}" class="visible">
          </div>
          <div style="display: flex;flex-direction: column;">
            <div style="display: flex;">
          <h4> &nbsp; {{__('sales.card')}}</h4>
          <input style="margin: 7px 10px 0 0" type="checkbox" id="card" name="card">
            </div>
          <input style="margin-right: 0px" type="number" min="0.0000001" step="0.0000001" name="cardVal" id="cardVal" value="" placeholder="{{__('settings.input_card_here')}}" class="hidden">
          </div>
          <div style="display: flex;flex-direction: column;">
            <div style="display: flex;">
          <h4> &nbsp; STC pay</h4>
          <input style="margin: 7px 10px 0 0" type="checkbox" id="stc" name="stc">
            </div>
          <input style="margin-right: 0px" type="number" min="0.0000001" step="0.0000001" name="stcVal" id="stcVal" value="" placeholder="{{__('settings.input_stc_here')}}" class="hidden">
          </div>
          </div>
          <h4>{{__('sales.note')}}</h4>
          <input type="text" name="note" placeholder="{{__('sales.type_note')}}" class="form-control">
          @if(isset($date) && $date == 'custom')
          <div style="margin:25px">
            <h4> {{__('sales.do_you_want_transfer_money_to_cashier')}} 
            <input type="checkbox" name="transfer_to_box" value="yes">
            </h4>
          </div>
          <div style="display:none">
          <h4>{{__('sales.inv_not_belong_to_todays_invoices')}}</h4>
          <input type="checkbox" name="old_invoice" value="yes" checked>
          </div>
          @endif
          <div>
            <div style="margin-top: 10px;" class="col-12">
              <div class="form-group text-end">
                  <button id="submit" type="submit" name="action" value="sell" class="btn btn-main mx-3">{{__('buttons.confirm')}}</button>
                  <button type="submit" name="action" value="save" class="btn btn-green mx-3">{{__('buttons.save')}}</button>
                  <a href="{{route('create.special.invoice',$repository->id)}}" style="color: white;" class="btn btn-red">{{__('buttons.cancel')}}</a>
              </div>
          </div>
          
          </form>
            {{--<a onclick="PrintElem($('#print-content').attr('id'));" style="color: white" class="btn btn-success">حفظ</a>--}}
          </div>
          </div>
       </div>
   </div>
</div>
</div>
  </div> {{-- end print content --}}
</div>
</div>
</div>
</div>
<input type="hidden" id="error-audio" value="{{asset('public/audio/error.wav')}}">
@endsection
@section('scripts')
<script src="{{asset('public/alerts/cute-alert.js')}}"></script>

<script>

  function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=1000,width=1500');
    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head>   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> <style>.hidden{visibility: hidden;}.visible{visibility: visible;}.displaynone{display: none;}</style>');
    mywindow.document.write('<style>*{font-size: 16px;font-weight: bold;}</style>');
    mywindow.document.write('<body>');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
    mywindow.close();
    return true;
}
 
</script>
<script>    // Ajax
    $('.barcode').on('keyup input paste',function(){
          setTimeout(() => {
    var barcode = $(this).val();
    var id = $(this).attr("id");  // extract id
    var gold =  id.slice(3);   // remove bar from id to take just the number
    var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
            if(data != ""){
              
              $('#bar'+gold).addClass('green').removeClass('red');
              clearTimeout($('#timeout'+gold).val());
            $.each(data,function(i,value){
              $('#name'+gold+'').val(value.name_ar);
              //$('#name'+gold+'').addClass('ajaxSuccess');
              $('#details'+gold+'').val(value.name_en);
              $('#cost_price'+gold+'').val(value.cost_price);
              //$('#details'+gold+'').addClass('ajaxSuccess');
              $('#price'+gold+'').val(value.price);
              if(value.stored == true)
                $('#ava'+gold+'').val(value.quantity);
              else
                $('#ava'+gold+'').val('/');
              $('#sum-row'+gold).val($('#price'+gold).val() * $('#quantity'+gold).val());
              //$('#price'+gold+'').prop('max',value.price);  // for manuall discount
              //$('#price'+gold+'').addClass('ajaxSuccess');
              $('#d'+gold+'').removeClass('hidden').addClass('visible');
              $('#d'+gold+'').prop('checked',false); // because the default value is hanging
              $('#accept_min'+gold).val(value.accept_min);

              // cart
              $('#cart-init'+gold).val($('#quantity'+gold).val());
              //alert(parseInt($('#cart').text()));
              var cartVal = 0 ;
              for(var c=0;c<=25;c++){
                if($('#name'+c).val() != null){
                  cartVal = cartVal + parseInt($('#cart-init'+c).val());
                //$('#cart').text(parseInt($('#cart').text()) + parseInt($('#cart-init'+c).val()));
                }
              }
              $('#cart').text(cartVal);

              if(parseFloat($('#price'+gold+'').val())!=NaN){
                var s = 0 ;  
                var s1 = 0 ; // sum for accept min value
                var s2 = 0 ;   // sum for not accept min value
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */
                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());
                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  $('#submit').prop('disabled', false);
                  }
                  
              } // end if
      
           });

            // warning notification if quantity not enough
            $.each(data,function(i,value){
              if(value.stored == true){
                if(value.quantity < $('#quantity'+gold).val()){
                    cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
                    var audio_link = $('#error-audio').val();
                    var audio = new Audio(audio_link);
                    audio.play();
                }
                // now we check for all rows because maybe we have some repeated barcode in several rows
                  var temp_qty = 0 ;
                  for(var i=0;i<=25;i++){   // number of records
                    if($('#bar'+i).val() == value.barcode)
                      temp_qty = temp_qty + parseInt($('#quantity'+i).val());
                  }
                  if(temp_qty > value.quantity)
                      cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
              }
            });

           

            /*
            $.each(data,function(i,value){
              if(value.stored && value.quantity < $('#quantity'+gold).val()){
                cuteAlert({
                  type: "error",
                  title: "كمية غير كافية",
                  message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                  buttonText: "حسنا",
                });
                var audio_link = $('#error-audio').val();
                var audio = new Audio(audio_link);
                audio.play();
                }
                // now we check for all rows because maybe we have some repeated barcode in several rows
                if(value.stored){
                  var temp_qty = 0 ;
                  for(var i=0;i<=25;i++){   // number of records
                    if($('#bar'+i).val() == value.barcode)
                      temp_qty = temp_qty + parseInt($('#quantity'+i).val());
                  }
                  console.log(temp_qty);
                  if(temp_qty > value.quantity)
                      cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
                }
              
            });
            */
            

            }  // end if data != null
            else{  // data is Null
              $('#bar'+gold).addClass('red').removeClass('green');
              // clear the old timeout error delay
              clearTimeout($('#timeout'+gold).val());
             var timeout = setTimeout(() => {
              cuteAlert({
                type: "error",
                title: "باركود غير متوفر",
                message: "الرجاء تأكد من ادخال الباركود",
                buttonText: "حسنا",
              });
              var audio_link = $('#error-audio').val();
              var audio = new Audio(audio_link);
              audio.play();
              }, 5000);
              $('#timeout'+gold).val(timeout);
              //alert($('#timeout').val());
              /*
              cuteAlert({
                type: "error",
                title: "باركود غير متوفر",
                message: "الرجاء تأكد من ادخال الباركود",
                buttonText: "حسنا",
              });
              var audio_link = $('#error-audio').val();
              var audio = new Audio(audio_link);
              audio.play();
              */
              /*
              cuteToast({
                type: "error", // or 'info', 'error', 'warning'
                message: "الباركود غير متوفر",
                timer: 10000
              });
              */
              $('#name'+gold+'').val(null);
              //$('#name'+gold+'').addClass('red');
              $('#details'+gold+'').val(null);
              //$('#cost_price'+gold+'').val(null);
              //$('#details'+gold+'').addClass('ajaxSuccess');
              $('#price'+gold+'').val(0);
              //$('#price'+gold+'').prop('max',value.price);  // for manuall discount
              //$('#price'+gold+'').addClass('ajaxSuccess');
              $('#d'+gold+'').removeClass('visible').addClass('hidden');
              $('#d'+gold+'').prop('checked',true);
              $('#accept_min'+gold).val(null);

              // cart
              $('#cart-init'+gold).val(0);
              //alert(parseInt($('#cart').text()));
              var cartVal = 0 ;
              for(var c=0;c<=25;c++){
                if($('#name'+c).val() != null){
                  cartVal = cartVal + parseInt($('#cart-init'+c).val());
                //$('#cart').text(parseInt($('#cart').text()) + parseInt($('#cart-init'+c).val()));
                }
              }
              $('#cart').text(cartVal);


              if(parseFloat($('#price'+gold+'').val())!=NaN){
                var s = 0 ;  
                var s1 = 0 ; // sum for accept min value
                var s2 = 0 ;   // sum for not accept min value
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */

                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());
                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  $('#submit').prop('disabled', false);
                  }
                  
              } // end if
            }
          }
    }); // ajax close
  }, 100);  // end timeout for reading
  });
</script>
<script>   // stop submiting form when click enter
$('#sell-form').keypress(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});
</script>
<script>
  $('#sell-form').keypress(function(e) {
    if (e.keyCode == 13) {
      // Get the focused element:
      var focused = $(':focus');
      var id = focused.attr("id");  // extract id
      var gold =  id.slice(3);   // remove bar from id to take just the number
      //var num = parseInt(gold) +1;
      var num = parseInt(gold);
      // focus on next element
      $('#bar'+num+'').focus();
      //$('#bar'+num+'').prop('required',true);
    }
  //$('.barcode').last().focus();
});
</script>
<script>
  $('.quantity').on('keyup',function(){
                var quantity = $(this).val();
                var id = $(this).attr("id");  // extract id
                var gold =  id.slice(8);   // remove bar from id to take just the number
                var s = 0 ;
                var s1 = 0;
                var s2 = 0 ;
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                $('#sum-row'+gold).val($('#price'+gold).val() * $('#quantity'+gold).val());
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                 //tax
                 var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */
                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
                  // cart
               $('#cart-init'+gold).val($('#quantity'+gold).val());
                //alert(parseInt($('#cart').text()));
                var cartVal = 0 ;
                for(var c=0;c<=25;c++){
                  if($('#name'+c).val() != null){
                    cartVal = cartVal + parseInt($('#cart-init'+c).val());
                  //$('#cart').text(parseInt($('#cart').text()) + parseInt($('#cart-init'+c).val()));
                  }
                }
                $('#cart').text(cartVal);

                // notification for quantity not enough
                
                var repo_id = $('#repo_id').val();
                var barcode = $('#bar'+gold).val();
                $.ajax({
                    type: "get",
                    url: '/ajax/get/product/'+repo_id+'/'+barcode,
                    //dataType: 'json',
                    success: function(data){    // data is the response come from controller
                      if(data != ""){
                        $.each(data,function(i,value){
              if(value.stored == true){
                if(value.quantity < $('#quantity'+gold).val()){
                    cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
                    var audio_link = $('#error-audio').val();
                    var audio = new Audio(audio_link);
                    audio.play();
                }
                // now we check for all rows because maybe we have some repeated barcode in several rows
                  var temp_qty = 0 ;
                  for(var i=0;i<=25;i++){   // number of records
                    if($('#bar'+i).val() == value.barcode)
                      temp_qty = temp_qty + parseInt($('#quantity'+i).val());
                  }
                  if(temp_qty > value.quantity)
                      cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
              }
            });
                      }
                    }
                });
                

                  
  });
</script>
<script>  // hide and show div
    $('#toggle-recipe').on('click',function(){
    $("#recipe").toggle();
    });
    $('#toggle-invoices').on('click',function(){
    $("#invoices").toggle();
    });
</script>
<script>
  $('#cash').on('click',function(){
if($('#cash').is(':checked') && $('#card').is(':checked') && $('#stc').is(':checked')){
    $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
    $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').val($('#all_price_value').val());
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').val($('#all_price_value').val());
  $('#cardVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').val($('#all_price_value').val());
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cashVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#cashVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == true && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').val($('#all_price_value').val());
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cashVal').val(null);
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){   // error
  //$('#cash').prop('checked',true);
  //$('input[name="cashVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  //$('#cashVal').val( $('#total_price').val());
  $('#cashVal').val(null);
  $('#cardVal').val(null);
  $('#stcVal').val(null);
  //$('#submit').prop('disabled', true);
  if($('.delivered:checked').length != $('.delivered').length && $('#name0').val()!='' && parseFloat($('#percent').val())==0)   // we put name0 to prevent confirm empty invoice
  $('#submit').prop('disabled', false);
  else
  $('#submit').prop('disabled', true);
}
});
</script>
<script>
  $('#card').on('click',function(){
if($('#cash').is(':checked') && $('#card').is(':checked') && $('#stc').is(':checked')){
    $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
    $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cardVal"]').val($('#all_price_value').val());
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#cardVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cardVal"]').val($('#all_price_value').val());
  $('#cashVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').val($('#all_price_value').val());
  $('#cashVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == true && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').val($('#all_price_value').val());
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cashVal').val(null);
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){   // error
  //$('#cash').prop('checked',true);
  //$('input[name="cashVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  //$('#cashVal').val( $('#total_price').val());
  $('#cashVal').val(null);
  $('#cardVal').val(null);
  $('#stcVal').val(null);
  //$('#submit').prop('disabled', true);
  if($('.delivered:checked').length != $('.delivered').length && $('#name0').val()!='' && parseFloat($('#percent').val())==0)   // we put name0 to prevent confirm empty invoice
  $('#submit').prop('disabled', false);
  else
  $('#submit').prop('disabled', true);
}
});
</script>
<script>
  $('#stc').on('click',function(){
if($('#cash').is(':checked') && $('#card').is(':checked') && $('#stc').is(':checked')){
    $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
    $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
    $('input[name="stcVal"]').val($('#all_price_value').val());
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#cardVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').val($('#all_price_value').val());
  $('input[name="stcVal"]').val($('#all_price_value').val());
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').val($('#all_price_value').val());
  $('#cashVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#cashVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == true && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').val($('#all_price_value').val());
  $('#cashVal').val(null);
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){   // error
  //$('#cash').prop('checked',true);
  //$('input[name="cashVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  //$('#cashVal').val( $('#total_price').val());
  $('#cashVal').val(null);
  $('#cardVal').val(null);
  $('#stcVal').val(null);
  //$('#submit').prop('disabled', true);
  if($('.delivered:checked').length != $('.delivered').length && $('#name0').val()!='' && parseFloat($('#percent').val())==0)   // we put name0 to prevent confirm empty invoice
  $('#submit').prop('disabled', false);
  else
  $('#submit').prop('disabled', true);
}
});
</script>
<script>
  //$('#cashVal').val($('#final_total_price').val());
window.onload=function(){
  $('#submit').prop('disabled',true);
  $('#cashVal').val($('#final_total_price').val());
  $('#all_price_value').val($('#final_total_price').val());

  // tax
  var tax =  parseFloat($('#tax').val());
    var total_price =  parseFloat($('#total_price').val());
    var increment = (tax * total_price) / 100;
    $('#taxfield').val(increment);
    // min init
    var initmin = parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()) / 100 ;
    $('#inputmin').val(initmin);
};
  var c = $('input[name="barcode[]"]');
  var count = c.length;    // number of records
 
$('input[name="quantity[]"]').on("keyup",function(){
  var sum = 0 ;
  var s1 = 0;
  var s2 = 0 ;
  for(var i=0;i<count;i++){
    sum = sum + $('.price').eq(i).val()*$('.quantity').eq(i).val();
    //$('#total_price').val($('#total_price').val()+($('.price').eq(i).val()*$('.quantity').eq(i).val()));
  }
  $('#total_price').val(sum);
  for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
 // tax
    var tax =  parseFloat($('#tax').val());
    var total_price =  parseFloat($('#total_price').val());
    var total_price_acc =  parseFloat($('#total_price_acc').val());
    var total_price_notacc =  parseFloat($('#total_price_notacc').val());
    /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */
                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
   //console.log($('#final_total_price').val());
  $('#cashVal').val($('#final_total_price').val());     // cash value input
  $('#all_price_value').val($('#final_total_price').val());

   // update min value when total price change
    //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
    var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
    //console.log(newMin);
    $('#inputmin').val(newMin);
    $('#minVal').text(newMin);
    // check min validation
    var cash =  parseFloat($('#cashVal').val());
    var card = parseFloat($('#cardVal').val());
    var stc = parseFloat($('#stcVal').val());
     // min payment
     var min = parseFloat($('#inputmin').val());
      if(card+cash+stc<min){
      $('#submit').prop('disabled', true);
      $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
      } 
      else{
      $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
    }
     
});
</script>

</script>
<script>   // stop submiting form when click enter
  $('#sell-form').keypress(function(e) {
      if (e.keyCode == 13) {
          e.preventDefault();
          return false;
      }
  });
  </script>
<script>
window.onload=function(){
  var count_press = 0;
  $('#sell-form').keypress(function(e) {
      if (e.keyCode == 13) {
        count_press = count_press + 1 ;
        var gold =  count_press;
        $('#record'+gold).removeClass('displaynone');
        // focus on next element
        $('#bar'+gold+'').focus();
      }
  });
  $('input[name="add_rs"]').val($('select[name="add_r"]').val());
  $('input[name="axis_rs"]').val($('input[name="axis_r"]').val());
  $('input[name="cyl_rs"]').val($('select[name="cyl_r"]').val());
  $('input[name="sph_rs"]').val($('select[name="sph_r"]').val());
  $('input[name="add_ls"]').val($('select[name="add_l"]').val());
  $('input[name="axis_ls"]').val($('input[name="axis_l"]').val());
  $('input[name="cyl_ls"]').val($('select[name="cyl_l"]').val());
  $('input[name="sph_ls"]').val($('select[name="sph_l"]').val());
  $('input[name="ipdvals"]').val($('input[name="ipdval"]').val());
          $('#submit').prop('disabled', true);
  $(function () {
  $('[data-toggle="popover"]').popover()
  });
}
</script>
<script>   // stop submiting form when click enter
  $('#sell-form').keypress(function(e) {
      if (e.keyCode == 13) {
          e.preventDefault();
          return false;
      }
  });
  </script>
  <script>   // hanging
    $('.delivered').on('change',function(){
      if ($('.delivered:checked').length != $('.delivered').length)
        $('#badgecolor').removeClass('hidden').addClass('visible');
        else
        $('#badgecolor').removeClass('visible').addClass('hidden');
    });
  </script>
  
  <script>  // changing the name dynamically
    $('#customerName').on('keyup',function(){
        $('#customerN').val($(this).val());
        $('input[name="customer_name_s"]').val($(this).val());
    });
  </script>
  <script>  // delete record by clicking the icon
    $('.delete').on('click',function(){
      var id = $(this).attr("id");  // extract id
      var gold =  id.slice(6);   // remove bar from id to take just the number
      $('#bar'+gold).val(null);
      $('#name'+gold).val(null);
      $('#details'+gold).val(null);
      $('#cost_price'+gold).val(null);
                $('#total_price').val($('#total_price').val()-$('#price'+gold).val()*$('#quantity'+gold).val());
                if(parseInt($('#accept_min'+gold+'').val())==0){  // deleted record not accept min
                  $('#total_price_notacc').val($('#total_price_notacc').val()-$('#price'+gold).val()*$('#quantity'+gold).val());
                }
                if(parseInt($('#accept_min'+gold+'').val())==1){  // deleted record accept min
                  $('#total_price_acc').val($('#total_price_acc').val()-$('#price'+gold).val()*$('#quantity'+gold).val());
                }
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */
                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
      $('#price'+gold).val(null);
      $('#quantity'+gold).val(1);
      $('#d'+gold).removeClass('visible').addClass('hidden');
      $('#d'+gold).prop('checked',true); // return to default
      if ($('.delivered:checked').length == $('.delivered').length){
        $('#badgecolor').removeClass('visible').addClass('hidden');
      }

      // cart
      $('#cart-init'+gold).val(0);
              //alert(parseInt($('#cart').text()));
              var cartVal = 0 ;
              for(var c=0;c<=25;c++){
                if($('#name'+c).val() != null){
                  cartVal = cartVal + parseInt($('#cart-init'+c).val());
                //$('#cart').text(parseInt($('#cart').text()) + parseInt($('#cart-init'+c).val()));
                }
              }
              $('#cart').text(cartVal);
              
    });
    $(document).keydown(function(e) {  // delete record by clicking backspace on barcode input field
    if (e.keyCode == 46	) {
      // Get the focused element:
      var focused = $(':focus');
      var id = focused.attr("id");  // extract id
      // make sure we are on barcode field focus
      var strFirstThree = id.substring(0,3);
      if(strFirstThree=='bar'){
      var gold =  id.slice(3);   // remove bar from id to take just the number
      $('#bar'+gold).val(null);
      $('#name'+gold).val(null);
      $('#details'+gold).val(null);
      $('#cost_price'+gold).val(null);
                $('#total_price').val($('#total_price').val()-$('#price'+gold).val()*$('#quantity'+gold).val());
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var increment = (tax * total_price) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(increment+parseFloat($('#total_price').val()));
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
      $('#price'+gold).val(null);
      $('#quantity'+gold).val(1);
      $('#d'+gold).removeClass('visible').addClass('hidden');
      $('#d'+gold).prop('checked',true); // return to default
      if ($('.delivered:checked').length == $('.delivered').length){
        $('#badgecolor').removeClass('visible').addClass('hidden');
      }
      }
    }
});
    
  </script>
 <script>
  const btnscrollTotop = document.querySelector('#submit');
  btnscrollTotop.addEventListener("click" , function(){
    window.scrollTo(0,0);
  });
</script>

<script>    // cant submit if cash + card != total real price    //Except if we make invoice pending
  $('input[name="quantity[]"],#cashVal,#cardVal,#cash,#card,#stcVal,#stc').on("keyup change",function(){
     var sum;
     var cash =  parseFloat($('#cashVal').val());
     var card = parseFloat($('#cardVal').val());
     var stc = parseFloat($('#stcVal').val());
    
      // min payment
      var min = parseFloat($('#inputmin').val());
     if($('#cashVal').val()=="" && $('#cardVal').val()!="" && $('#stcVal').val()!=""){
     //if(!$('#cashVal').val() && $('#cardVal').val()){
       cash = 0 ;
       sum = card + cash + stc;
     }
    if($('#cardVal').val()=="" && $('#cashVal').val()!="" && $('#stcVal').val()!=""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       card = 0 ;
       sum = cash + card + stc;
     }
     
     if($('#cardVal').val()=="" && $('#cashVal').val()!="" && $('#stcVal').val()==""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       card = 0 ;
       stc = 0 ;
       sum = cash + card + stc;
     }
     if($('#cardVal').val()=="" && $('#cashVal').val()=="" && $('#stcVal').val()!=""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       card = 0 ;
       cash = 0 ;
       sum = cash + card + stc;
     }
     if($('#cardVal').val()!="" && $('#cashVal').val()!="" && $('#stcVal').val()==""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       stc = 0 ;
       sum = cash + card + stc;
     }
     if($('#cardVal').val()!="" && $('#cashVal').val()=="" && $('#stcVal').val()==""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       cash = 0 ;
       stc = 0 ;
       sum = cash + card + stc;
     }
     if($('#cashVal').val()=="" && $('#cardVal').val()=="" && $('#stcVal').val()==""){
      cash = 0 ;
      card = 0 ;
      stc = 0 ;
     sum = cash + card + stc ;
     }
     if($('#cashVal').val()!="" && $('#cardVal').val()!="" && $('#stcVal').val()!=""){
     //if($('#cashVal').val() && $('#cardVal').val()){
     sum = cash + card + stc ;
     }
     /*if(sum == $('#final_total_price').val()){
       $('#submit').prop('disabled', false);
     }*/
    
      if(sum > $('#final_total_price').val()){   
       $('#submit').prop('disabled', true);
     }
     else{
       if ($('.delivered:checked').length != $('.delivered').length){  // hanging
         $('#badgecolor').removeClass('hidden').addClass('visible');
       // min payment
         if(cash+card+stc<min){
         //if(sum<min)
         $('#submit').prop('disabled', true);
         $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
       }
       else{
         $('#submit').prop('disabled', false);
         $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
       }
       }  // end hanging
       if ($('.delivered:checked').length == $('.delivered').length){ //delivered
         if(sum == $('#final_total_price').val())   // delivered
         $('#submit').prop('disabled', false);   // cant submit if cash and card not equals the total
         else
         $('#submit').prop('disabled', true);
       }
       //if(cash <= 0 || card <= 0 )
       if(parseFloat($('#cashVal').val()) <=0.00 || parseFloat($('#cardVal').val())<=0.00 || parseFloat($('#stcVal').val())<=0.00){ // dont accept values less or equal to zero
           $('#submit').prop('disabled', true);
         }
       
     }
     if($('#cardVal').val()=="" && $('#cashVal').val()=="" && $('#stcVal').val()==""){
       //$('#submit').prop('disabled', true);
       if($('.delivered:checked').length != $('.delivered').length && $('#name0').val()!='' && parseFloat('#percent').val())
       $('#submit').prop('disabled', false);
       else
       $('#submit').prop('disabled', true);
     }
   });
 </script>
 <script>  /* change discount value */
  $('#max-field').on("keyup",function(){
                var maxy = $(this).val();
                var allowed = $('#max-allowed').val();
                if(parseFloat(maxy) > parseFloat(allowed)){    // warning alert
                      cuteAlert({
                        type: "error",
                        title: "تخطيت الحد الأعلى للخصم",
                        message: "الحد الأعلى هو  "+'%'+allowed,
                        buttonText: "حسنا",
                        });
                }
                var s = 0 ;
                var s1 = 0;
                var s2 = 0 ;
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                 //tax
                 var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */

                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);


                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
  });

  $('#discount-by-value').on("keyup",function(){
                var s = 0 ;
                var s1 = 0;
                var s2 = 0 ;
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                 //tax
                 var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */

                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
  });
 </script>
 <script>  /* change product price dynamically */  /* discount by changing price */
  $('.price').on('keyup',function(){
    var s = 0 ;  
                var s1 = 0 ; // sum for accept min value
                var s2 = 0 ;   // sum for not accept min value
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                    console.log('zero');
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */
                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
  });
 </script>
 
 

{{--<script>   // add new recipe
  $('#plus-recipe').on('change',function(){
    var value = $('#plus-recipe').val();
    for(s=0;s<6;s++){
      if(s==value){
        $('#extra-recipe'+s).removeClass('displaynone');
        $('#recipe_name'+s).prop('required',true);
      }
      else{
        $('#extra-recipe'+s).addClass('displaynone');
        $('#recipe_name'+s).prop('required',false);
      }
    }
  });
</script>--}}

<script>   // add new recipe
  $('#plus-recipe').on('change',function(){
    var value = $('#plus-recipe').val();
    for(s=0;s<6;s++){
      if(s<=value){    // show all recipes from index and back steps
        $('#extra-recipe'+s).removeClass('displaynone');
        $('#recipe_name'+s).prop('required',true);
      }
      else{
        $('#extra-recipe'+s).addClass('displaynone');
        $('#recipe_name'+s).prop('required',false);
      }
    }
  });
</script>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
{{-- Ajax request to autocomplete barcode --}}
<script>
  
  $(".barcode").autocomplete({
     
      source: function(request, response) {
          $.ajax({
          url: "{{url('autocomplete/invoice/products')}}",
          data: {
                  term : request.term,
                  repos_id : $('#repo_id').val(),
           },
          dataType: "json",
          success: function(data){
            //alert(data);
             var resp = $.map(data,function(obj){
                  return obj.barcode;
             }); 

             response(resp);
          }
          
      });
      
  },
  select: function (event, ui) {     // listen to the event when we select an option  
      setTimeout(    // wait 1 second then get the barcode id
      function() 
      {     
            //alert('yes');
            var barcode = $(':focus').val();
            var id = $(':focus').attr("id");  // extract id
            var gold =  id.slice(3);   // remove bar from id to take just the number
            var repo_id = $('#repo_id').val();
            $.ajax({
           type: "get",
           url: '/ajax/get/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
            if(data != ""){
              $('#bar'+gold).addClass('green').removeClass('red');
              clearTimeout($('#timeout'+gold).val());
            $.each(data,function(i,value){
              $('#name'+gold+'').val(value.name_ar);
              //$('#name'+gold+'').addClass('ajaxSuccess');
              $('#details'+gold+'').val(value.name_en);
              $('#cost_price'+gold+'').val(value.cost_price);
              //$('#details'+gold+'').addClass('ajaxSuccess');
              $('#price'+gold+'').val(value.price);
              if(value.stored == true)
                $('#ava'+gold+'').val(value.quantity);
              else
                $('#ava'+gold+'').val('/');
              $('#sum-row'+gold).val($('#price'+gold).val() * $('#quantity'+gold).val());
              //$('#price'+gold+'').prop('max',value.price);  // for manuall discount
              //$('#price'+gold+'').addClass('ajaxSuccess');
              $('#d'+gold+'').removeClass('hidden').addClass('visible');
              $('#d'+gold+'').prop('checked',false); // because the default value is hanging
              $('#accept_min'+gold).val(value.accept_min);

               // cart
               $('#cart-init'+gold).val($('#quantity'+gold).val());
              //alert(parseInt($('#cart').text()));
              var cartVal = 0 ;
              for(var c=0;c<=25;c++){
                if($('#name'+c).val() != null){
                  cartVal = cartVal + parseInt($('#cart-init'+c).val());
                //$('#cart').text(parseInt($('#cart').text()) + parseInt($('#cart-init'+c).val()));
                }
              }
              $('#cart').text(cartVal);

              if(parseFloat($('#price'+gold+'').val())!=NaN){
                var s = 0 ;  
                var s1 = 0 ; // sum for accept min value
                var s2 = 0 ;   // sum for not accept min value
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                    console.log('zero');
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==1){
                    console.log('first');
                     s1 = s1 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_acc').val(s1);  // hidden
                for(var i=0;i<=25;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0 && parseInt($('#accept_min'+i+'').val())==0){
                    console.log('second');
                     s2 = s2 + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price_notacc').val(s2);  // hidden
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var total_price_acc =  parseFloat($('#total_price_acc').val());
                var total_price_notacc =  parseFloat($('#total_price_notacc').val());
                /*
                var increment = (tax * total_price) / 100;
                var increment1 = (tax * total_price_acc) / 100;
                var increment2 = (tax * total_price_notacc) / 100;
                $('#taxfield').val(increment);
                */
                var check_discount_by_percent = $('#check-discount-by-percent').val();
                var check_discount_by_value = $('#check-discount-by-value').val();
                if($('#check-discount-by-percent').val() == '1'){
                var discount_percent = parseFloat($('#max-field').val());
                if(Number.isNaN(discount_percent))
                  discount_percent = 0;    // to accept null value for discount
                var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                discount = discount.toFixed(2);
                $('#discountVal').val(discount);
                var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                discount1 = discount1.toFixed(2);
                var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                discount2 = discount2.toFixed(2);

                var increment = (tax * (total_price-discount)) / 100;
                var increment1 = (tax * (total_price_acc-discount1)) / 100;
                var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                $('#taxfield').val(increment);
                
                $('#final_total_price').val(parseFloat(increment+parseFloat($('#total_price').val())-discount).toFixed(2));
                $('#f_total_price_acc').val(parseFloat(increment1+parseFloat($('#total_price_acc').val())-discount1).toFixed(2));
                $('#f_total_price_notacc').val(parseFloat(increment2+parseFloat($('#total_price_notacc').val())-discount2).toFixed(2));
                  if($('#check-discount-by-value').val() == '1'){
                  var discountv = parseFloat($('#discount-by-value').val());
                  if(Number.isNaN(discountv))
                    discountv = 0; // to accept null value for discount
                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discountv);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discountv);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discountv);
                  }
                }
                else{
                if($('#check-discount-by-value').val() == '1'){
                var discountv = parseFloat($('#discount-by-value').val());
                if(Number.isNaN(discountv))
                    discountv = 0;
                $('#final_total_price').val(increment+parseFloat($('#total_price').val())-discountv);
                $('#f_total_price_acc').val(increment1+parseFloat($('#total_price_acc').val())-discountv);
                $('#f_total_price_notacc').val(increment2+parseFloat($('#total_price_notacc').val())-discountv);
                  if($('#check-discount-by-percent').val() == '1'){
                  var discount_percent = parseFloat($('#max-field').val());
                  if(Number.isNaN(discount_percent))
                    discount_percent = 0;
                  var discount = (parseFloat($('#total_price').val()) ) * discount_percent / 100;
                  discount = discount.toFixed(2);
                  $('#discountVal').val(discount);
                  var discount1 = (parseFloat($('#total_price_acc').val()) ) * discount_percent / 100;
                  discount1 = discount1.toFixed(2);
                  var discount2 = (parseFloat($('#total_price_notacc').val()) ) * discount_percent / 100;
                  discount2 = discount2.toFixed(2);

                  var increment = (tax * (total_price-discount)) / 100;
                  var increment1 = (tax * (total_price_acc-discount1)) / 100;
                  var increment2 = (tax * (total_price_notacc-discount2)) / 100;
                  $('#taxfield').val(increment);

                  $('#final_total_price').val(parseFloat($('#final_total_price').val())-discount);
                  $('#f_total_price_acc').val(parseFloat($('#f_total_price_acc').val())-discount1);
                  $('#f_total_price_notacc').val(parseFloat($('#f_total_price_notacc').val())-discount2);
                  }
                }
                }
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input
                $('#all_price_value').val($('#final_total_price').val());

                // update min value when total price change
                //var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#f_total_price_acc').val()))/100 + parseFloat($('#f_total_price_notacc').val());
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                var stc = parseFloat($('#stcVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash+stc<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  $('#submit').prop('disabled', false);
                  }
                  
              } // end if
              
           });

           // warning notification if quantity not enough
           $.each(data,function(i,value){
              if(value.stored == true){
                if(value.quantity < $('#quantity'+gold).val()){
                    cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
                    var audio_link = $('#error-audio').val();
                    var audio = new Audio(audio_link);
                    audio.play();
                }
                // now we check for all rows because maybe we have some repeated barcode in several rows
                  var temp_qty = 0 ;
                  for(var i=0;i<=25;i++){   // number of records
                    if($('#bar'+i).val() == value.barcode)
                      temp_qty = temp_qty + parseInt($('#quantity'+i).val());
                  }
                  if(temp_qty > value.quantity)
                      cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
              }
            });
           /*
           $.each(data,function(i,value){
              if(value.stored && value.quantity < $('#quantity'+gold).val()){
                cuteAlert({
                  type: "error",
                  title: "كمية غير كافية",
                  message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                  buttonText: "حسنا",
                });
                var audio_link = $('#error-audio').val();
                var audio = new Audio(audio_link);
                audio.play();
                }
                // now we check for all rows because maybe we have some repeated barcode in several rows
                if(value.stored){
                  var temp_qty = 0 ;
                  for(var i=0;i<=25;i++){   // number of records
                    if($('#bar'+i).val() == value.barcode)
                      temp_qty = temp_qty + parseInt($('#quantity'+i).val());
                  }
                  console.log(temp_qty);
                  if(temp_qty > value.quantity)
                      cuteAlert({
                      type: "error",
                      title: "كمية غير كافية",
                      message: " الكمية في المخزون للمنتج غير كافية "+value.name_ar,
                      buttonText: "حسنا",
                    });
                }
              
            });
            */

            } // end if data != null
              else{  // data is Null
              $('#bar'+gold).addClass('red').removeClass('green');
            }
          }
    }); // ajax close
  }, 100);
            },
  minLength: 1
});


</script>   
@endsection