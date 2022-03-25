<!DOCTYPE html>
 <html dir="rtl">
    <head>
    	<!-- Metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="keywords" content="amir" />
        <meta name="description" content="amir" />
        <meta name="author" content="amir" />

        <!-- Title  -->
        <title>Rofood</title>
      <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        
    </head>
    <style>
      input {
    border:none;
    background-image:none;
    background-color:transparent;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    width: 25px;
    }
    .bordered-table{
      border: 1px solid black;
    }
    .bordered-table td , .bordered-table th {
      border: 1px solid black;
    }
    .p-inline{
        display: inline;
        padding : 10px;
    }
    .modal{
      color: red;
      font-size: 25px;
    }
    .table-c,.table-c td,.table-c th,.table-c tr{
      border: 1px solid black;
    }
    .table-c td {
            padding: 10px;
        }
    .table-c th {
            padding: 10px 0 10px 10px;
        }
    .big-padding{
      padding: 10px 0 10px 30px !important;
    }
    #logorep{
        border-radius: 50%;
      }
    @media print{
      .modal{
        display: none;
      }
      #back{
        display: none;
      }
    }
    </style>
    <body>
      <div id="back">
      @if($repository->isSpecial())
      @if(!isset($saving_old_invoice))
      <a href="{{route('sales.index',$repository->id)}}" class="btn btn-warning">{{__('buttons.back')}}</a>
      @else
      <form action="{{route('sales.index',$repository->id)}}" method="GET">
        @csrf
        <input type="hidden" name="old" value="yes">
        <button class="btn btn-warning">{{__('buttons.back')}}</button>
      </form>
      @endif
      @endif
      @if($repository->isBasic())
      <a href="{{route('sales.index',$repository->id)}}" class="btn btn-warning">{{__('buttons.back')}}</a>
      @endif
      </div>
      {{--
      @if(File::exists(asset('public/storage/'.$repository->logo))) --}}
      @if($repository->logo)
      <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
      @endif
    <h2>{{$repository->name}}</h2>
    <h3>{{$repository->address}}</h3>
    <h4>رقم الفاتورة {{$invoice->code}}</h4>
    <h4>التاريخ {{$invoice->created_at}}</h4>
    <h4>الرقم الضريبي {{$repository->tax_code}}</h4>
      <div class="bordred">
        <table class="table-c">
          <thead class="head">
            <th style="width: 100px">Barcode</th>
            <th style="width: 250px" class="big-padding">الاسم</th> 
            <th style="width: 30px">السعر</th>
            <th style="width: 30px">الكمية</th>
            <th style="width: 30px">المجموع</th>
          </thead>
          <input type="hidden" id="num" value="{{$num}}">
            @for($i=1;$i<$num;$i++)
            <tr>
                <td style="width: 100px">
                    {{$records[$i]['barcode']}}
                </td>
                <td style="width: 250px" class="big-padding">  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                  {{$records[$i]['name_ar']}}
                </td>
                <td style="width: 30px">
                    {{$records[$i]['price']}}
                </td>
                <td style="width: 30px">
                    {{$records[$i]['quantity']}}
                </td>
                <td style="width: 30px">
                  {{$records[$i]['quantity'] * $records[$i]['price']}}
              </td>
          </tr>
          @endfor
        </table>
        </div>
        <br>
            @if(isset($sum))
            <p class="p-inline">المجموع
                {{$sum}}
            </p>
            <p class="p-inline">الضريبة
                {{$tax}}
            <p class="p-inline">الحسم
                {{$discount}}
            </p>
            @endif
            
            <p>
            <p class="p-inline">المبلغ الإجمالي
                {{$total_price}}
            </p>
            </p>
            <p>
            <p class="p-inline">المبلغ الإجمالي
                {{$total_price}}
            </p>
            </p>

            <p>
           
            </p>
      
      @if($invoice->phone)
      <h4>جوال العميل {{$invoice->phone}}</h4>
      @endif
      
      <h4>موظف البيع {{$employee->name}}</h4>
      @if($note)
      <div>
        <h4>{{$note}}</h4>
      </div>
      @endif
      @if($repository->note)
      <div>
        <h4>{{$repository->note}}</h4>
      </div>
      @endif



      <input type="hidden" value="{{$repository->id}}" id="repo_id">
      @if(isset($complete_invoice)) {{-- completing invoice --}}
      <input type="hidden" value="true" id="is-completing">
      @else
      <input type="hidden" value="false" id="is-completing">
      @endif
      @if(isset($saving_old_invoice))
      <input type="hidden" value="true" id="old-invoice">
      @else
      <input type="hidden" value="false" id="old-invoice">
      @endif
      <?php
        if($repository->isSpecial())
          $repo_type = 'special';
        elseif($repository->isBasic())
          $repo_type = 'basic';
      ?>
      <input type="hidden" id="repo_type" value="{{$repo_type}}">
      {{-- input to check if we want to print additional recipe --}}
      @if($repository->isSpecial() && $repository->setting->print_additional_recipe == true)
        <input type="hidden" id="additional_recipe" value="yes">
        <input type="hidden" id="inv_id" value="{{$invoice->id}}">
      @endif
      {{-- <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
      </script> --}}
       <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script>
        
       

    
        // to make sure the data is loading before print //
        window.onload = function() {
          var num = parseFloat($('#num').val()); // number of records
          var sum = 0;
          var repo_type = $('#repo_type').val();
          for(var i=1;i<num;i++){
            sum = sum + parseFloat($('#price'+i).text()) * parseFloat($('#quantity'+i).text());
          }
          $('#total_price').text(sum);
          var repo_id = $('#repo_id').val();
          var is_completing = $('#is-completing').val();
          var print_additional_recipe = $('#additional_recipe').val();
          var invoice_id = $('#inv_id').val();
          result = confirm('تم البيع بنجاح هل تريد طباعة الفاتورة');

          // prepare onafterprint event for all explorers
          var completeInvoiceAfterPrint = function() {
              window.location.href = "/show/pending/invoices/"+repo_id;
          };
          var afterPrint = function() {
            if($('#old-invoice').val()=='false'){
                  if(repo_type == 'special' && print_additional_recipe == 'yes'){
                  window.location.href = "/print/additional/recipe/"+invoice_id;
                  }
                  if(repo_type == 'special' && print_additional_recipe != 'yes'){
                    window.location.href = "/sales/"+repo_id;
                  }
                  if(repo_type == 'basic'){
                  window.location.href = "/sales/"+repo_id;
                  }
                  }
                  else{
                  window.location.href = "/sales/"+repo_id;
                  }
          };
          if (window.matchMedia) {
              var mediaQueryList = window.matchMedia('print');
              mediaQueryList.addListener(function(mql) {
                  if (mql.matches) {
                      //   beforeprint
                  } else {   // after print event
                    if(result == true){
                        if(is_completing == 'true')
                            completeInvoiceAfterPrint();
                        else
                            afterPrint();
                    }
                  }
              });
          }


          if(result == true){
              if(is_completing == 'true'){
                  window.print();
                  window.onafterprint  = completeInvoiceAfterPrint;
                  /*  good way but not work fine on chrome
                  window.onafterprint = function(){
                  console.log('after_print');
                  window.location.href = "/show/pending/invoices/"+repo_id;
                  }
                  */
              }
              else{
                  window.print();
                  window.onafterprint  = afterPrint;
                  /*
                  window.onafterprint = function(){
                  //window.onafterprint = (event) => {
                  if($('#old-invoice').val()=='false'){
                  if(repo_type == 'special' && print_additional_recipe == 'yes'){
                  window.location.href = "/print/additional/recipe/"+invoice_id;
                  }
                  if(repo_type == 'special' && print_additional_recipe != 'yes'){
                    window.location.href = "/create/special/invoice/form/"+repo_id;
                  }
                  if(repo_type == 'basic'){
                  window.location.href = "/create/invoice/form/"+repo_id;
                  }
                  }
                  else{
                  window.location.href = "/sales/"+repo_id;
                  }
                  }
                  */
              }
          }
          else{
            if(is_completing == 'true')
               window.location.href = "/show/pending/invoices/"+repo_id;
            else{
                  if($('#old-invoice').val()=='false'){
                  if(repo_type == 'special'){
                  console.log('yes');
                  window.location.href = "/sales/"+repo_id;
                  }
                  if(repo_type == 'basic'){
                  window.location.href = "/sales/"+repo_id;
                  }
                  }
                  else
                  window.location.href = "/sales/"+repo_id;
            }
          }
        }
      </script>
   </body>
</html>