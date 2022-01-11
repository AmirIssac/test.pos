@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
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
.hidden{
    visibility: hidden;
  }
  .visible{
    visibility: visible;
  }
  .store-in-stock{
    width: 100px;
    height: 45px;
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
        <form method="POST" action="{{route('store.purchase.products',$repository->id)}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('purchases.add_purchases_product')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
                    <th>
                      Barcode  
                    </th>
                    <th>
                      {{__('repository.arabic_name')}}  
                    </th>
                    <th>
                      {{__('repository.english_name')}}
                    </th>
                    <th>
                      {{__('purchases.unit_price')}} 
                    </th> 
                    <th>
                      {{__('purchases.store_in_stock')}}
                    </th>
                  </thead>
                  <tbody>
                     <div id="record">
                      <tr>
                        <td>
                          <input type="hidden" name="repo_id" value="{{$repository->id}}">
                            <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}} " id="autofocus"  required>
                        </td>
                        <td>
                          <input type="text" name="name[]" class="form-control" placeholder="{{__('repository.arabic_name')}}" id="ar0" required>
                      </td>
                      <td>
                        <input type="text" name="details[]" class="form-control" placeholder="{{__('repository.english_name')}}">
                    </td>
                      
                        <td>
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}" required>
                        </td>
                        <td>
                          <input type="checkbox" name="stored[]" id="stored0"  class="store-in-stock" value="0">
                        </td>
                      </tr>
                      @for ($count=1;$count<=10;$count++)
                      <tr id="record{{$count}}" class="displaynone">
                      <td>
                        <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}}"  id="bar{{$count}}">
                    </td>
                    <td>
                      <input type="text" name="name[]" class="form-control" placeholder="{{__('repository.arabic_name')}}" id="ar{{$count}}">
                  </td>
                  <td>
                    <input type="text" name="details[]" class="form-control" placeholder="{{__('repository.english_name')}}">
                </td>
                    <td>
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}">
                    </td>
                    <td>
                      <input type="checkbox" name="stored[]" id="stored{{$count}}"  class="store-in-stock" value="{{$count}}">
                    </td>
                  </tr>
                      @endfor
                     </div>
                  </tbody>
                </table>
                <button  type="submit" class="btn btn-primary"> {{__('buttons.add')}} </button>
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
   /* $("input[name=price]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
    $("input[name=quantity]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
  */
</script>
<script>
  var intervalId = window.setInterval(function(){
  for(var i=0;i<count;i++){
      $('#total_price'+i+'').val($('#price'+i+'').val()*$('#quantity'+i+'').val());
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
      $('#price'+count).prop('required',true);
      count = count + 1;
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