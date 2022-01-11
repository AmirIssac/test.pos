@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
}
#plus{
  color: #007bff;
}
form #plus:hover{
  cursor: pointer;
}
form #tooltip:hover{
  cursor: default;
}
.measurements input{
  width: 45px;
  margin-top: 10px;
}
.displaynone{
  display: none;
}
.table-c {
            width:100%;
            height: 30px;
            /*table-layout: fixed;*/
        }
        .table-c td {
            border: 2px solid #007bff;
            padding: 10px;
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
h6{
  color: #f14000;
  font-weight: bold;
}

.delete{
  transition: all .2s ease-in-out;
}
.delete:hover{
  cursor: pointer;
  transform: scale(1.4);
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
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid">
      <div class="row">
        <form method="POST" action="{{route('store.product')}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('repository.add_product_to_stock')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table-c">
                  <thead class="text-primary">
                    <th style="width: 17%">
                      Barcode  
                    </th>
                    <th style="width: 15%">
                      {{__('repository.arabic_name')}}  
                    </th> 
                    <th style="width: 11%">
                      {{__('repository.english_name')}}
                    </th>
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    <th style="width: 10%">
                      {{__('repository.product_type')}}
                    </th>
                    @endif
                    <th style="width: 1%">
                      {{__('repository.accept_min')}}  
                    </th>
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    <th style="width: 8%">
                      {{__('repository.storing_method')}} 
                    </th>
                    @endif
                    <th style="width: 7%">
                      {{__('sales.quantity')}} 
                    </th>
                    <th style="width: 8%">
                      {{__('reports.cost_price')}}  
                    </th>
                    <th style="width: 8%">
                      {{__('sales.sell_price')}}  
                    </th>
                    <th style="width: 10%">   {{-- for future use to save every input details in table of repository inputs --}}
                      {{__('sales.total_price')}}  
                      <th  style="width: 1%">
                        <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title=" {{__('sales.total_price')}} =" data-content=" {{__('reports.cost_price')}} X {{__('sales.quantity')}}">live_help</i>
                      </th>
                    </th>
                  </thead>
                  <tbody>
                       <tr id="record0">
                        <td>
                            <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}} " id="bar0"  required>
                            <h6 class="displaynone" id="exist0">{{__('repository.booked_will_be_ignored')}}</h6>
                        </td>
                        <td>
                          <input type="text" name="name[]" class="form-control" placeholder="{{__('repository.arabic_name')}}" id="ar0" required>
                      </td>
                      <td>
                        <input type="text" name="details[]" class="form-control" placeholder="{{__('repository.english_name')}}" id="en0">
                    </td>
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    <td style="width: 10%">
                      @if(LaravelLocalization::getCurrentLocale() == 'ar')
                      <select id="sel0" name="type[]" class="form-control sel">
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name_ar}}</option>
                        @endforeach
                      </select>
                      @endif
                      @if(LaravelLocalization::getCurrentLocale() == 'en')
                      <select id="sel0" name="type[]" class="form-control sel">
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name_en}}</option>
                        @endforeach
                      </select>
                      @endif
                      <span class="measurements displaynone" id="meas0">
                      <input type="number" id="sph0" min="-20.00" max="20.00" step="0.25" name="sph[]" placeholder="sph">
                      <input type="number" id="cyl0" min="-20.00" max="20.00" step="0.25" name="cyl[]" placeholder="cyl">
                      <input type="number" id="add0" min="0.00" max="20.00" step="0.25" name="add[]" placeholder="add">
                      <input type="text" id="ty0" name="typee[]" placeholder="type">
                      </span>
                  </td>
                  @endif
                  <td>
                    <input type="checkbox" name="acceptmin[]" value="0" checked>
                  </td>
                  @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                  <td>
                    <select id="stored0" name="stored[]" class="form-control">
                      <option value="yes">{{__('repository.available_in_stock')}}</option>
                      <option value="no">{{__('repository.buy_from_market')}}</option>
                    </select>
                  </td>
                  @endif
                    <td>
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}" required>
                  </td>
                      <td>
                        <input id="cost_price0"  type="number" name="cost_price[]" step="0.01" min="0" class="form-control" value="" placeholder="{{__('reports.cost_price')}}" required>
                      </td>
                        <td>
                            <input id="price0"  type="number" name="price[]" step="0.01" min="0" class="form-control target" value="" placeholder="{{__('sales.price')}}" required>
                        </td>
                        <td>
                            <input id="total_price0" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" required>
                            <input type="hidden" id="repo_id" name="repo_id" value="{{$repository->id}}">
                        </td> 
                        <td>
                        <i style="color: #f14000; font-weight: bold" id="delete0" class="material-icons delete">delete</i>
                        </td>
                      </tr>
                      @for ($count=1;$count<=10;$count++)
                      <tr id="record{{$count}}" class="displaynone">
                      <td>
                        <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}}"  id="bar{{$count}}">
                        <h6 class="displaynone" id="exist{{$count}}">{{__('repository.booked_will_be_ignored')}}</h6>
                    </td>
                    <td>
                      <input type="text" name="name[]" class="form-control" placeholder="{{__('repository.arabic_name')}}" id="ar{{$count}}">
                  </td>
                  <td>
                    <input type="text" name="details[]" class="form-control" placeholder="{{__('repository.english_name')}}" id="en{{$count}}">
                </td>
                @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                <td>
                  @if(LaravelLocalization::getCurrentLocale() == 'ar')
                  <select id="sel{{$count}}" name="type[]" class="form-control sel">
                    @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->name_ar}}</option>
                    @endforeach
                  </select>
                  @endif
                 @if(LaravelLocalization::getCurrentLocale() == 'en')
                  <select id="sel{{$count}}" name="type[]" class="form-control sel">
                    @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->name_en}}</option>
                    @endforeach
                  </select>
                  @endif
                  <span class="measurements displaynone" id="meas{{$count}}">
                  <input type="number" id="sph{{$count}}" min="-20.00" max="20.00" step="0.25" name="sph[]" placeholder="sph">
                  <input type="number" id="cyl{{$count}}" min="-20.00" max="20.00" step="0.25" name="cyl[]" placeholder="cyl">
                  <input type="number" id="add{{$count}}" min="0.00" max="20.00" step="0.25" name="add[]" placeholder="add">
                  <input type="text" id="ty{{$count}}" name="typee[]" placeholder="type">
                  </span>
              </td>
              @endif
              <td>
                <input type="checkbox" name="acceptmin[]" value="{{$count}}" checked>
              </td>
              @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
              <td>
                <select id="stored{{$count}}" name="stored[]" class="form-control">
                  <option value="yes">{{__('repository.available_in_stock')}}</option>
                  <option value="no">{{__('repository.unavailable_in_stock')}}</option>
                </select>
              </td>
              @endif
                <td>
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}">
              </td>
                  <td>
                    <input id="cost_price{{$count}}"  type="number" name="cost_price[]" step="0.01" min="0" class="form-control" value="" placeholder="{{__('reports.cost_price')}}">
                  </td>
                    <td>
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" min="0" class="form-control target" value="" placeholder="{{__('sales.price')}}">
                    </td>
                    <td>
                        <input id="total_price{{$count}}" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}">
                    </td>
                    <td>
                      <i style="color: #f14000; font-weight: bold" id="delete{{$count}}" class="material-icons delete">delete</i>
                    </td>
                  </tr>
                      @endfor
                     </div>
                  </tbody>
                </table>
                <button style="margin-top: 10px;"  type="submit" class="btn btn-primary"> {{__('buttons.add')}} </button>
                <i id="plus" class="material-icons">add_circle</i>
            </div>
        </div>
      </div>
    </div>
</form>
  </div>
</div>
</div>
@endsection
@section('scripts')

<script>
  var intervalId = window.setInterval(function(){
  for(var i=0;i<count;i++){
      $('#total_price'+i+'').val($('#cost_price'+i+'').val()*$('#quantity'+i+'').val());
  }
}, 500);
</script>

<script>
    var count = 1;
    $('form #plus').on('click',function(){
      $('#record'+count).removeClass('displaynone');
      $('#bar'+count).focus();
      $('#bar'+count).prop('required',true);
      $('#ar'+count).prop('required',true);
      $('#quantity'+count).prop('required',true);
      $('#cost_price'+count).prop('required',true);
      $('#price'+count).prop('required',true);
      $('#total_price'+count).prop('required',true);
      count = count + 1;
    });

    $('.delete').on('click',function(){
      var id = $(this).attr("id");  // extract id
      var gold =  id.slice(6);   // remove bar from id to take just the number
      $('#bar'+gold).val(null);
      $('#ar'+gold).val(null);
      $('#en'+gold).val(null);
      $('#quantity'+gold).val(null);
      $('#cost_price'+gold).val(null);
      $('#price'+gold).val(null);
      $('#total_price'+gold).val(0);
      $('#bar'+gold).prop('required',false);
      $('#ar'+gold).prop('required',false);
      $('#quantity'+gold).prop('required',false);
      $('#cost_price'+gold).prop('required',false);
      $('#price'+gold).prop('required',false);
      $('#total_price'+gold).prop('required',false);
      $('#record'+gold).addClass('displaynone');
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
  <script>
    $('.sel').on('change',function(){
      var id = $(this).attr("id");  // extract id
      var gold =  id.slice(3);   // remove sel from id to take just the number    
      var type_id = $('#sel'+gold).val();
      $.ajax({
           type: "get",
           url: '/ajax/get/typeName/'+type_id,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
              //alert(data.name);
              var string = data.name_ar;
              var substring = 'عدس';
              if(string.includes(substring)){   // now we display the measurements fields
              //alert(gold);
                $('#meas'+gold).removeClass('displaynone');
              }
              else{
                $('#meas'+gold).addClass('displaynone');
                // make the measurements inputs null
                $('#sph'+gold).val(null);
                $('#cyl'+gold).val(null);
                $('#add'+gold).val(null);
                $('#ty'+gold).val(null);
              }
          }
        });
      });
     
  </script>

<script>
  $('.barcode').on('keyup',function(){
  var repo_id = $('#repo_id').val();
  var barcode = $(this).val();
  var id = $(this).attr("id");  // extract id
  var gold =  id.slice(3);   // remove bar from id to take just the number    
  $.get('/ajax/check/barcode/exist/'+repo_id, {barcode : barcode}, 
      function(returnedData){
           if(returnedData == 'error')
           {
            $('#bar'+gold).removeClass('green').addClass('red');
            $('#exist'+gold).removeClass('displaynone');
           }
           else{
            $('#bar'+gold).removeClass('red').addClass('green');
            $('#exist'+gold).addClass('displaynone');
           }
  });
  });
  </script>
@endsection