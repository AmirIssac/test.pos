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
    .table-c,.table-c td,.table-c th,.table-c tr{
      border: 1px solid black;
    }
    .table-c td {
            padding: 10px;
        }
    .table-c th {
            padding: 10px 0 10px 10px;
        }
      #logorep{
        border-radius: 50%;
      }
      .info{
        font: bold 11px Arial;
        text-decoration: none;
        background-color: #0d6efd;
        color: #ffffff;
        padding: 2px 6px 2px 6px;
        border-top: 1px solid #CCCCCC;
        border-right: 1px solid #333333;
        border-bottom: 1px solid #333333;
        border-left: 1px solid #CCCCCC;
      }
      .warning{
        font: bold 11px Arial;
        text-decoration: none;
        background-color: #f4c721;
        color: #333333;
        padding: 2px 6px 2px 6px;
        border-top: 1px solid #CCCCCC;
        border-right: 1px solid #333333;
        border-bottom: 1px solid #333333;
        border-left: 1px solid #CCCCCC;
      }
    /*.big-padding{
      padding: 10px 0 10px 30px !important;
    }*/
    @media print{
      #back{
        display: none;
      }
    }
    </style>
    <body>
      <div id="back">
        <a href="{{route('show.price.invoices',$repository->id)}}" class="warning">{{__('buttons.back')}}</a>
      </div>
     {{--@if(File::exists(asset('public/storage/'.$repository->logo)))--}}
     @if($repository->logo)
    <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
    @endif
    <h2>فاتورة عرض سعر</h2>
    <h2>{{$repository->name}} / {{$repository->address}}</h2>
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
          <?php $records = unserialize($invoice->details) ?>
            @for($i=1;$i<count($records);$i++)
            <tr>
                <td style="width: 100px">
                    <input type="hidden" value="{{count($records)}}" id="num">
                    {{$records[$i]['barcode']}}
                </td>
                <td style="width: 250px" class="big-padding">  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                  {{$records[$i]['name_ar']}}
                </td>
                <td style="display: none;">
                  {{$records[$i]['cost_price']}}
                </td>
                <td style="width: 30px">
                  <p id="price{{$i}}">
                    {{$records[$i]['price']}}
                  </p>
                </td>
                <td style="width: 30px">
                  <p id="quantity{{$i}}">
                    {{$records[$i]['quantity']}}
                  </p>
                </td>
                <td style="width: 30px">
                  <p id="sum-row{{$i}}">
                    {{$records[$i]['quantity'] * $records[$i]['price']}}
                  </p>
                </td>
          </tr>
          @endfor
        </table>
        </div>
        <br>
        <p>
        <p class="p-inline"> المجموع
              <p id="total_price" class="p-inline">
              </p> </p>
              <p class="p-inline">   الضريبة
              {{$invoice->tax}}</p>
              <p class="p-inline">
           الحسم
              {{$invoice->discount}}
              </p>
        </p>
              <p>
              <p class="p-inline">
            المبلغ الإجمالي
              @if($invoice->status == 'retrieved')
              <p>{{$invoice->total_price}}-</p>
              @else
              <p>{{$invoice->total_price}}</p>
              @endif
                 
      @if($invoice->phone)
      <h4>جوال العميل {{$invoice->phone}}</h4>
      @endif
      <h4>موظف البيع {{$invoice->user->name}}</h4>
      @if($invoice->note)
      <div>
        <h4>{{$invoice->note}}</h4>
      </div>
      @endif
      @if($repository->note)
      <div>
        <h4>{{$repository->note}}</h4>
      </div>
      @endif


      
        
      <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
      <script>
        
        // to make sure the data is loading before print //
        window.onload = function() {
          var num = parseFloat($('#num').val()); // number of records
          var sum = 0;
          for(var i=1;i<num;i++){
            sum = sum + parseFloat($('#price'+i).text()) * parseFloat($('#quantity'+i).text());
          }
          $('#total_price').text(sum);
          window.print();
        }
      </script>
   </body>
</html>