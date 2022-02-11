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
      #manual-print{
        display: none;
      }
    }
    </style>
    <body>
        <button id="manual-print" onclick="manualPrint()" class="btn btn-warning">طباعة</button>
        <h3>{{$invoice->created_at}}</h3>
        <h3>Invoice number : {{$invoice->code}}</h3>
        <div class="bordred">
          <table class="table-c">
            <thead class="head">
              <th style="width: 100px">Barcode</th>
              <th style="width: 250px" class="big-padding">Name</th> 
              <th style="width: 30px">Price</th>
              <th style="width: 30px">Quantity</th>
              @if(isset($complete_invoice))
              <th style="width: 30px"> to be delivered </th>
              @endif
              <th style="width: 30px"> delivered </th> 
            </thead>
            <input type="hidden" id="num" value="{{count($records)}}">
              @for($i=1;$i<count($records);$i++)
              <tr>
                  <td style="width: 100px">
                      {{$records[$i]['barcode']}}
                  </td>
                  <td style="width: 250px" class="big-padding">  {{-- في طباعة فاتورة الورشة نطبع بالانكليزي وإن لم يكن الاسم مسجل بالانكليزي نطبعه بالعربي --}}
                    @if($records[$i]['name_en'])
                    {{$records[$i]['name_en']}}
                    @else
                    {{$records[$i]['name_ar']}}
                    @endif
                  </td>
                  <td style="width: 30px">
                      {{$records[$i]['price']}}
                  </td>
                  <td style="width: 30px">
                      {{$records[$i]['quantity']}}
                  </td>
                  @if(isset($complete_invoice))
                  <td style="width: 30px">
                      {{$records[$i]['must_del']}}
                  </td>
                  @endif
                  <td style="width: 30px">
                      @if($records[$i]['del'] == 'نعم')
                      Yes
                      @else
                      No
                      @endif
                  </td>
            </tr>
            @endfor
          </table>
          </div>
          <br>
  
        @if($repository->isSpecial())
        @if($repository->setting->print_prescription == true)
        @if(isset($recipe) && $recipe) 
        @for($i=0;$i<count($recipe);$i++)
        <h4>   prescription  </h4>
                @if(array_key_exists('name', $recipe[$i]))
                  {{$recipe[$i]['name']}}
                @endif
        <div class="bordred">
        <table class="bordered-table" dir="ltr">
          <thead>
            <th>EYE</th>
            <th class="text-center">SPH</th>
            <th class="text-center">CYL</th>
            <th class="text-center">Axis</th>
            <th class="text-center">ADD</th>
          </thead>
          <tr>
          <th>RIGHT</th>
          <th class="text-center">
            @if(floatval($recipe[$i]['sph_r']) > 0)
            +{{$recipe[$i]['sph_r']}}
            @else
            {{$recipe[$i]['sph_r']}}
            @endif
          </th>
          <th class="text-center">
            @if(floatval($recipe[$i]['cyl_r']) > 0)
            +{{$recipe[$i]['cyl_r']}}
            @else
            {{$recipe[$i]['cyl_r']}}
            @endif
          </th>
          <th class="text-center">{{$recipe[$i]['axis_r']}}</th>
          <th class="text-center">
            @if(floatval($recipe[$i]['add_r']) > 0)
            +{{$recipe[$i]['add_r']}}
            @else
            {{$recipe[$i]['add_r']}}
            @endif
          </th>
          </tr>
          <tr>
            <th>LEFT</th>
            <th class="text-center">
            @if(floatval($recipe[$i]['sph_l']) > 0)
            +{{$recipe[$i]['sph_l']}}
            @else
            {{$recipe[$i]['sph_l']}}
            @endif
            </th>
            <th class="text-center">
            @if(floatval($recipe[$i]['cyl_l']) > 0)
            +{{$recipe[$i]['cyl_l']}}
            @else
            {{$recipe[$i]['cyl_l']}}
            @endif
            </th>
            <th class="text-center">{{$recipe[$i]['axis_l']}}</th>
            <th class="text-center">
            @if(floatval($recipe[$i]['add_l']) > 0)
            +{{$recipe[$i]['add_l']}}
            @else
            {{$recipe[$i]['add_l']}}
            @endif
            </th>
            </tr>
            <td>
            </td>
            <th style="text-align: center; font-weight: bold; font-size: 18px;">
              ipd distance
            </th>
            <th style="text-align: center;">
              {{$recipe[$i]['ipd']}}
            </th>
            <th style="text-align: center; font-weight: bold; font-size: 18px;">
              ipd near
            </th>
            <th style="text-align: center;">
              @if(isset($recipe[$i]['ipd2']))  {{-- old version --}}
              {{$recipe[$i]['ipd2']}}
              @else
              0
              @endif
            </th>
            <tr>

              <tr>
                <td>
                </td>
                <th style="text-align: center; font-weight: bold; font-size: 18px;">
                  recipe source
                </th>
                <th style="text-align: center; font-weight: bold; font-size: 18px;">
                  @if(isset($recipe[$i]['recipe_source']))  {{-- old version --}}
                  {{$recipe[$i]['recipe_source']}}
                  @else
                  customer
                  @endif
                </th>
                <th style="text-align: center; font-weight: bold; font-size: 18px;">
                  ipd source
                </th>
                <th style="text-align: center; font-weight: bold; font-size: 18px;">
                  @if(isset($recipe[$i]['ipd_source']))  {{-- old version --}}
                  {{$recipe[$i]['ipd_source']}}
                  @else
                  customer
                  @endif
                </th>
              </tr>
        </table>
        </div>
        @endfor
        @endif
        @endif
        <h4>
          customer : {{$customer->name}}
        </h4>
        <h4> customer phone : {{$customer->phone}}</h4>
        @elseif($repository->isBasic())
        <h4> customer phone : {{$phone}}</h4>
        @endif
        <div>
          {{--
        {!! $barcode !!}
            --}}
            <?php
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($customer->phone, $generator::TYPE_CODE_128)) . '">';
            ?>
        </div>
        <input type="hidden" id="repo_id" value="{{$repository->id}}">
       <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script>
        var repo_id = $('#repo_id').val();
        // prepare onafterprint event for all explorers
        var afterPrint = function() {
              window.location.href = "/create/special/invoice/form/"+repo_id;
          };
          if (window.matchMedia) {
              var mediaQueryList = window.matchMedia('print');
              mediaQueryList.addListener(function(mql) {
                  if (mql.matches) {
                      //   beforeprint
                  } else {   // after print event
                            afterPrint();
                  }
              });
          }
        // to make sure the data is loading before print //
        window.onload = function() {
          window.print();
          window.onafterprint  = afterPrint;
        }

        var manualPrint = function() {
              window.print();
              window.location.href = "/create/special/invoice/form/"+repo_id;
          };
      </script>
   </body>
</html>