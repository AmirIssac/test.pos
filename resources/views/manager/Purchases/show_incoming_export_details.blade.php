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
  @if ($message = Session::get('refused'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
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
              <h4 class="card-title"> {{$export->updated_at}}</h4>
                 <h4><span class="badge badge-success">{{$export->code}}</span></h4>
                 @if(request()->is('show/incoming/export/details/*'))
                 @if($export->status == 'pending')
                 <h5><span class="badge badge-info">تدقيق البضاعة</span></h5>
                 @endif
                 @endif
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @if($export->status != 'refused')
                <form action="{{route('accept.export.invoice',$export->id)}}" method="post">
                  @csrf
                @elseif($export->status == 'refused')
                <form action="{{route('retrieve.export.invoice',$export->id)}}" method="post">
                  @csrf
                @endif
                <table class="table">
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
                        {{__('repository.accept_min')}}  
                    </th>
                    <th>
                        {{__('repository.storing_method')}} 
                    </th>
                    <th>
                        {{__('reports.cost_price')}}  
                    </th>
                    <th>
                        {{__('sales.sell_price')}}  
                    </th>
                    <th>
                        {{__('sales.quantity')}} 
                    </th>
                  </thead>
                  <tbody>
                    <?php $count = 0; ?>
                    @foreach($export->exportRecords as $record)
                    <tr>
                        <td>
                            <input type="hidden" name="barcode[]" value="{{$record->barcode}}">
                            {{$record->barcode}}
                        </td>
                        <td>
                            <input type="hidden" name="name[]" value="{{$record->name_ar}}">
                            {{$record->name_ar}}
                        </td>
                        <td>
                          <input type="hidden" name="details[]" value="{{$record->name_ar}}">
                            {{$record->name_en}}
                        </td>
                        {{-- product type --}}
                        <select style="display: none"  name="type[]">
                          <option value="{{$record->type_id}}" selected>type id</option>
                        </select>
                        <td>
                        @if($record->accept_min)
                        <input style="display: none" type="checkbox" name="acceptmin[]" value="{{$count}}" checked>
                        {{__('repository.yes')}}
                         @else
                         <input style="display: none" type="checkbox" name="acceptmin[]" value="{{$count}}">
                         {{__('repository.no')}}
                        @endif
                        </td>
                        <td>
                        @if($record->stored)
                        <select style="display: none" name="stored[]" class="form-control">
                          <option value="yes" selected>{{__('repository.available_in_stock')}}</option>
                        </select>
                       {{__('repository.available_in_stock')}}
                       @else
                       <select style="display: none" name="stored[]" class="form-control">
                        <option value="no" selected>{{__('repository.buy_from_market')}}</option>
                      </select>
                       {{__('repository.buy_from_market')}}
                       @endif
                        </td>
                        <td>
                          <input style="display: none"  type="number" name="cost_price[]" value="{{$record->cost_price}}">
                            {{$record->cost_price}}
                        </td>
                        <td>
                          <input style="display: none"  type="number" name="price[]" value="{{$record->price}}">
                            {{$record->price}}
                        </td>
                        <td>
                          <input style="display: none" type="number" name="quantity[]" value="{{$record->quantity}}">
                            {{$record->quantity}}
                        </td>
                    </tr>
                    <?php $count++ ; ?>
                    @endforeach
                    <tr style="font-weight: 900">
                        <td>
                            المستودع
                        </td>
                        <td>
                          الفرع
                      </td>
                        <td>
                          {{__('purchases.total_price')}} 
                        </td>
                        <td>
                          {{__('purchases.status')}}
                        </td>
                        <td>
                          موظف المستودع
                        </td>
                        <td>
                          @if($export->user_reciever) {{-- exist --}}
                          موظف الفرع
                          @endif
                        </td>
                        <td>
                          ملاحظة
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{$export->repository_sender->name}}
                       </td>
                       <td>
                        {{$export->repository_reciever->name}}
                       </td>
                       <td>
                        {{$export->total_price}}
                       </td>
                       <td>
                        {{$export->status}}
                       </td>
                       <td>
                           {{$export->user_sender->name}}
                       </td>
                       <td>
                        @if($export->user_reciever) {{-- exist --}}
                        {{$export->user_reciever->name}}
                        @endif
                      </td>
                      <td>
                        @if($export->note && $export->status != 'delivered')
                        {{$export->note}}
                        @else
                        لا يوجد
                        @endif
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        @if($export->status == 'pending')
                        @if(request()->is('show/incoming/export/details/*'))
                        <button class="btn btn-primary">قبول واستلام</button>
                        <button type="button" data-toggle="modal" data-target="#exampleModal{{$export->id}}" id="modalicon" class="btn btn-danger">رفض</button>
                        @else
                        <h4 style="color: #c79c01; font-weight: bold">بانتظار التسليم</h4>
                        @endif
                        @elseif($export->status == 'delivered')
                         <h4 style="color: #28a745; font-weight: bold">تم القبول والتسليم</h4>
                         @elseif($export->status == 'refused')
                         <h4 style="color: #c43201; font-weight: bold">مرفوضة</h4>
                         @elseif($export->status == 'retrieved')
                         <h4 style="color: #c79c01; font-weight: bold">مسترجعة</h4>
                        @endif
                      </td>
                      <td>
                        @if($export->status == 'refused' && !request()->is('show/incoming/export/details/*'))
                        <button class="btn btn-warning">استرجاع</button>
                        @endif
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </form>

        <!-- Modal for refusing the export invoice -->
        <div class="modal fade" id="exampleModal{{$export->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$export->id}}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{$export->id}}">رفض الفاتورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"></span>
                </button>
              </div>
              <form action="{{route('refuse.export.invoice',$export->id)}}" method="POST">
                @csrf
              <div class="modal-body">
                <h5>هل أنت متأكد أنك تريد رفض الفاتورة ؟</h5>
               <h6>ملاحظة</h6>
                <input type="text" name="note" class="form-control">
              </div>
              <div class="modal-footer">
                <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
              </form>
              </div>
            </div>
          </div>
        </div>
               

              </div>
              </div>
            </div>
          </div>
        </div>

      </div>
     
    </div>
</div>
@endsection

