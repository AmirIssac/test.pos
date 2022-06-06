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
  .delivered{
    background-color: #93cb52;
  }
  .pending{
    background-color: #f4c721;
  }
  .retrieved{
    background-color: #9b9ea0;
  }
  .deleted{
    background-color: #ff4454;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title"> </h4>
              <h4> {{__('sales.invoice_details')}} </h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  </thead>
                  <tbody>
                    @if(isset($recipe) && $recipe) 
                    @for($i=0;$i<count($recipe);$i++)
                    <h4>    {{__('sales.prescription')}}  </h4>
                            @if(array_key_exists('name', $recipe[$i]))
                            <span class="badge badge-info">{{$recipe[$i]['name']}}</span>
                            @else
                              <span class="badge badge-success"> وصفة اساسية</span>
                            @endif
                    <div class="bordred">
                    <table style="border: 1px solid black;" class="bordered-table" dir="ltr">
                      <thead style="border: 1px solid black;">
                        <th>EYE</th>
                        <th class="text-center">SPH</th>
                        <th class="text-center">CYL</th>
                        <th class="text-center">Axis</th>
                        <th class="text-center">ADD</th>
                      </thead>
                      <tr style="border: 1px solid black;">
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
                      <tr style="border: 1px solid black;">
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
                        <tr style="border: 1px solid black;">
                          <tr>
                            <td>
                            </td>
                            <th>
                                {{__('sales.prescription_source')}} 
                            </th>
                            <th style="text-align: center;">
                              @if(isset($recipe[$i]['recipe_source']))  {{-- old version --}}
                              {{$recipe[$i]['recipe_source']}}
                              @else
                              customer
                              @endif
                            </th>
                            <th style="text-align: center; font-weight: bold;">
                              {{__('sales.ipd_source')}} 
                            </th>
                            <th style="text-align: center; font-weight: bold;">
                              @if(isset($recipe[$i]['ipd_source']))  {{-- old version --}}
                              {{$recipe[$i]['ipd_source']}}
                              @else
                              customer
                              @endif
                            </th>
                          </tr>
                    </table>
                    </div>
                    <hr>
                    @endfor
                    @endif
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

@section('scripts')
<script>
  $('.eye').on('click',function(){
    var id = $(this).attr('id');
    if($('#th'+id).hasClass('displaynone')){  // show
    $('#th'+id).removeClass('displaynone');
    $('#tb'+id).removeClass('displaynone');
    }
    else
    {  // hide
      $('#th'+id).addClass('displaynone');
      $('#tb'+id).addClass('displaynone');
    }
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