@extends('layouts.main')
@section('links')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  {{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
 
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
.displaynone{
  display: none;
}
.success{
  background-color: greenyellow;
}
.success:focus{
  background-color: greenyellow;
}
.failed{
  background-color: #f14000;
}
.failed:focus{
  background-color: #f14000;
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
  @if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block">
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
        <form method="POST" action="{{route('submit.export.invoice',$repository->id)}}">
          @csrf
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title "></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="myTable" class="table">
                      <thead class="text-primary">
                        
                      </thead>
                      <tbody>
                         <div>
                          <tr>
                            <td>{{__('purchases.invoice_num')}}</td>
                            <td>
                              @if(old('code'))
                              <span style="font-size: 22px;" class="badge badge-primary">{{old('code')}}</span>
                              <input type="hidden" name="code" value="{{old('code')}}">
                              @else
                              <span style="font-size: 22px;" class="badge badge-primary">{{$code}}</span>
                              <input type="hidden" name="code" value="{{$code}}">
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>الفرع</td>
                            <td>
                              <select name="repository_reciever_id" class="form-control">
                                <option value="" disabled selected hidden>   قم باختيار الفرع الذي تريد ارسال البضاعة له  </option>
                                @foreach($sub_repositories as $sub_repository)
                                  @if(!$sub_repository->isStorehouse())
                                    <option value="{{$sub_repository->id}}"> {{$sub_repository->name}} </option>
                                  @endif
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          
                         </div>
                      </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">المنتجات</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
                    <th>
                      Barcode  
                    </th>
                    <th>
                      {{__('purchases.name')}}
                    </th>
                    <th>
                      {{__('sales.quantity')}} 
                    </th>
                    <th>
                      {{__('purchases.unit_price')}} 
                    </th>
                    <th>   {{-- for future use to save every input details in table of repository inputs --}}
                      {{__('purchases.total')}}
                      <td>
                      <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title=" {{__('purchases.total')}} =" data-content="  {{__('purchases.unit_price')}} X {{__('sales.quantity')}}">live_help</i>
                      </td>
                    </th>
                  </thead>
                  <tbody>
                     <div id="record">
                      <tr>
                        <td>
                          <input type="hidden" value="{{$repository->id}}" id="repo_id">
                          <?php $old_index = 0 ; ?>
                            <input type="text" name="barcode[]" class="form-control barcode" value="{{old('barcode.'.$old_index)}}" placeholder=" {{__('sales.scanner_input')}} " id="bar0"  required>
                          {{--  <input id="search" name="search" type="text" class="form-control" placeholder="Search" /> --}}

                        </td>
                        <td>
                          <input type="text" name="name[]" class="form-control" value="{{old('name.'.$old_index)}}" id="ar0" required readonly>
                      
                  
                    <td>
                      @if(old('quantity.'.$old_index))
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="{{old('quantity.'.$old_index)}}" placeholder="{{__('sales.quantity')}}" required>
                      @else
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}" required>
                      @endif
                  </td>
                      
                        <td>
                          @if(old('price.'.$old_index))
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="{{old('price.'.$old_index)}}" placeholder="{{__('sales.price')}}" id="price0" required>
                            @else
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}" id="price0" required>
                            @endif
                        </td>
                        <td>
                            <input id="total_price0" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" readonly>
                            <input type="hidden" name="repo_id" value="{{$repository->id}}">
                        </td>  
                        <td>
                          <a id="delete0" class="delete"><img src="{{asset('public/img/delete-icon.jpg')}}" width="45px" height="45px"></a>
                      </td>
                      </tr>
                      @for ($count=1;$count<=100;$count++)
                      @if(old('name.'.$count)) {{-- this record exist in old input so we dont hide it --}}
                      <tr id="record{{$count}}">
                      @else
                      <tr id="record{{$count}}" class="displaynone">
                      @endif
                      <td>
                        <input type="text" name="barcode[]" class="form-control barcode" value="{{old('barcode.'.$count)}}" placeholder=" {{__('sales.scanner_input')}}"  id="bar{{$count}}">
                    </td>
                    <td>
                      <input type="text" name="name[]" class="form-control" value="{{old('name.'.$count)}}" id="ar{{$count}}" readonly>
                  </td>
                <td>
                  @if(old('quantity.'.$count))
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="{{old('quantity.'.$count)}}" placeholder="{{__('sales.quantity')}}">
                  @else
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}">
                  @endif
              </td>
                  
                    <td>
                        @if(old('price.'.$count))
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="{{old('price.'.$count)}}" placeholder="{{__('sales.price')}}">
                        @else
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}">
                        @endif
                    </td>
                    <td>
                        <input id="total_price{{$count}}" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" readonly>
                    </td>
                    <td>
                      <a id="delete{{$count}}" class="delete"><img src="{{asset('public/img/delete-icon.jpg')}}" width="45px" height="45px"></a>
                  </td>
                  </tr>
                      @endfor
                     </div>
                  </tbody>
                </table>
                <label style="font-weight: bold; color: black"> {{__('purchases.total')}} </label>
                <input type="number" name="sum" id="sum" class="form-control" readonly>
            </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title ">  ملاحظة 
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="myTable" class="table">
              <thead class="text-primary">
              </thead>
              <tbody>
                 <div>
                  <tr>
                    <input style="width: 100%; height: 30px; border: 1px solid #007bff !important" type="text" name="note" placeholder="اكتب ملاحظة خاصة هنا ....">
                  </tr>
                 </div>
              </tbody>

            </table>
            <button id="submit"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> {{__('buttons.confirm')}} </button>

        </div>
    </div>
  </div>
</div>
     
                             <!-- Modal for confirming -->
                             <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('purchases.confirm_prodcedure')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true"></span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{__('purchases.sure_you_want_to_make_this_proccess')}}
                                  </div>
                                  <div class="modal-footer">
                                    <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                    <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
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
{{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    <script>
  var intervalId = window.setInterval(function(){
    var sum = 0 ;
    var count = 100;
  for(var i=0;i<count;i++){
      $('#total_price'+i+'').val($('#price'+i+'').val()*$('#quantity'+i+'').val());
      sum = sum + parseFloat($('#total_price'+i+'').val());
  }
  $('#sum').val(sum);
}, 3000);
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
    $('input[type="radio"]').on('change',function(){
      if($('#cashradio').is(':checked')){
          $('#cashoption1').removeClass('displaynone');
          $('#cashoption2').removeClass('displaynone');
      }
      else{
        $('#cashoption1').addClass('displaynone');
        $('#cashoption2').addClass('displaynone');
      }
    });
  </script>
  <script>   // check the sum by the cashier balance
    $('#sum').on('change',function(){
      
      if($('#cashradio').is(':checked') && $('#cashrad').is(':checked'))
      {
          if(parseFloat($('#sum').val()) > parseFloat($('#cash_balance').val()))
              $('#submit').prop('disabled',true);
              else
              $('#submit').prop('disabled',false);
      }
      else
          $('#submit').prop('disabled',false);

      if(parseFloat($('#sum').val())==0) // no records
        $('#submit').prop('disabled',true);  
    });
  </script>
  <script>    // Ajax
  $('.barcode').on('keyup',function(){
    var barcode = $(this).val();
    var id = $(this).attr("id");  // extract id
    var gold =  id.slice(3);   // remove bar from id to take just the number
    var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
              if(data != 'no_data'){
              $.each(data,function(i,value){
              $('#'+id).addClass('success').removeClass('failed');
              $('#ar'+gold+'').val(value.name_ar);
              $('#price'+gold+'').val(value.price);
              $('#price'+gold+'').prop('readonly',false);
              });
              }
              else{
                $('#'+id).addClass('failed').removeClass('success');
                $('#ar'+gold+'').val(null);
                $('#price'+gold+'').val(0);
                $('#price'+gold+'').prop('readonly',true);
              }
          }
    }); // ajax close
  });
</script>

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
              if(data != 'no_data'){
              $.each(data,function(i,value){
              $('#'+id).addClass('success').removeClass('failed');
              $('#ar'+gold+'').val(value.name_ar);
              $('#price'+gold+'').val(value.price);
              $('#price'+gold+'').prop('readonly',false);
              });
              }
              else{
                $('#'+id).addClass('failed').removeClass('success');
                $('#ar'+gold+'').val(null);
                $('#price'+gold+'').val(0);
                $('#price'+gold+'').prop('readonly',true);
              }
          }
    }); // ajax close
  }, 100);
            },
     minLength: 1
  });

 
 </script>   
<script>   // stop submiting form when click enter
  $('form').keypress(function(e) {
      if (e.keyCode == 13) {
          e.preventDefault();
          return false;
      }
  });
  </script>
  
  <script>
    $('form').keypress(function(e) {
      if (e.keyCode == 13) {
        // Get the focused element:
        var focused = $(':focus');
        var id = focused.attr("id");  // extract id
        var string = id.slice(0, 3); // take first 3 character from id to check its bar or pri we are focused in
        if(string == 'bar')
        var gold =  id.slice(3);   // remove bar from id to take just the number
        else // we are focused on price input
        var gold =  id.slice(5);   // remove price from id to take just the number
        var count = parseInt(gold) +1;
        // focus on next element
        $('#record'+count).removeClass('displaynone');
        $('#bar'+count+'').focus();
        //$('#bar'+count).prop('required',true);
        $('#ar'+count).prop('required',true);
        $('#quantity'+count).prop('required',true);
        $('#price'+count).prop('required',true);
        $('#price'+count).prop('readonly',true);
        $('#total_price'+count).prop('required',true);
      }
      });
    </script>
  <script>  // delete record by clicking the icon
    $('.delete').on('click',function(){
      var id = $(this).attr("id");  // extract id
      var gold =  id.slice(6);   // remove bar from id to take just the number
              $('#bar'+gold+'').val(null);
              $('#ar'+gold+'').val(null);
              $('#price'+gold+'').val(0);
              $('#price'+gold+'').prop('readonly',true);
              $('#bar'+gold).removeClass('failed').removeClass('success');
    });
  </script>
@endsection