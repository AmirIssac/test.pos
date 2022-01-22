@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  .select{
  
    background-color: #007bff;
    color: white
  }
  .search-btn{
  border:none;
  background-color: transparent
}
.search-btn i{
  color: #001bb7;
}
i{
  transition: all .2s ease-in-out;
}
i:hover{
  transform: scale(1.3);
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
              @if(request()->query('isStored')=='all')
              <h4 class="card-title">{{__('repository.all_products')}}</h4>
              @elseif(request()->query('isStored')=='no')
              <h4 class="card-title">{{__('repository.unavailable_in_stock')}}</h4>
              @elseif(request()->query('isStored')=='yes')
              <h4 class="card-title">{{__('repository.available_in_stock')}}</h4>
              @else
              <h4 class="card-title">{{__('repository.all_products')}}</h4>
              @endif
              {{-- filter --}}
    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
  <form action="{{route('filter.products',$repository->id)}}" method="GET">
    @csrf
    <select class="select" name="isStored">
      @if(request()->query('isStored')=='all')
      <option value="all" selected>{{__('repository.all_products')}}</option>
      <option value="yes">{{__('repository.available_in_stock')}}</option>
      <option value="no">{{__('repository.buy_from_market')}}</option>
      @elseif(request()->query('isStored')=='no')
      <option value="all">{{__('repository.all_products')}}</option>
      <option value="yes">{{__('repository.available_in_stock')}}</option>
      <option value="no" selected>{{__('repository.buy_from_market')}}</option>
      @elseif(request()->query('isStored')=='yes')
      <option value="all">{{__('repository.all_products')}}</option>
      <option value="yes" selected>{{__('repository.available_in_stock')}}</option>
      <option value="no">{{__('repository.buy_from_market')}}</option>
      @else
      <option value="all" selected>{{__('repository.all_products')}}</option>
      <option value="yes">{{__('repository.available_in_stock')}}</option>
      <option value="no">{{__('repository.buy_from_market')}}</option>
      @endif
    </select>
    <button type="submit" class="search-btn">
      <i class="material-icons">search</i>
    </button>
    </form>
    @endif
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      Barcode  
                    </th>
                    <th>
                      {{__('repository.arabic_name')}}   
                    </th>
                    <th>
                      {{__('repository.english_name')}}
                    </th>
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    <th>
                      {{__('repository.product_type')}} 
                    </th>
                    <th>
                      {{__('repository.accept_min')}}
                    </th>
                    @endif
                    @can('مشاهدة سعر التكلفة')
                    <th>
                      {{__('reports.cost_price')}}   
                  </th>
                  @endcan
                    <th>
                      {{__('sales.sell_price')}}   
                    </th>
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    <th>
                      {{__('repository.storing_method')}}
                    </th>
                    @endif
                    <th>
                      {{__('repository.quantity_available')}}   
                    </th>
                    <th>
                         
                  </th>
                  <th>
   
                </th>
                  </thead>
                  <tbody>
                    @if($products && $products->count()>0)
                    @foreach($products as $product)
                    <tr>
                     <td>{{$product->barcode}}</td>
                     <td>{{$product->name_ar}}</td>
                     <td>
                        {{$product->name_en}}
                     </td>
                     @if($repository->isSpecial())
                     <td>
                      @if(LaravelLocalization::getCurrentLocale() == 'ar')
                       {{$product->type['name_ar']}} 
                       @endif
                       @if(LaravelLocalization::getCurrentLocale() == 'en')
                       {{$product->type['name_en']}}
                       @endif
                     </td>
                     <td>
                       @if($product->isAcceptMin())
                       {{__('repository.yes')}}
                        @else
                        {{__('repository.no')}}
                       @endif
                     </td>
                     @endif
                     @can('مشاهدة سعر التكلفة')
                     <td>
                      {{$product->cost_price}}
                    </td>
                    @endcan
                     <td>
                        {{$product->price}}
                    </td>
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    @if($product->stored)
                    <td>
                       {{__('repository.available_in_stock')}}
                    </td>
                    <td>
                      @if($product->quantity<=10)
                        <span class="badge badge-danger">
                        {{$product->quantity}}
                        </span>
                      @elseif ($product->quantity>10 && $product->quantity<50)  
                        <span class="badge badge-warning">
                        {{$product->quantity}}
                        </span>
                      @else
                      <span class="badge badge-success">
                        {{$product->quantity}}
                        </span>
                      @endif
                    </td>
                    @endif
                    @endif
                    @if($repository->isSpecial() || $repository->isStorehouse())  {{-- محل خاص --}}
                    @if(!$product->stored)
                    <td>
                      {{__('repository.buy_from_market')}}
                    </td>
                    <td>
                      /
                    </td>
                    @endif
                    @endif
                    <td>
                      <form action="{{route('edit.product')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="repository_id" value="{{$repository->id}}">
                        <button style="color: white" type="submit" class="btn btn-info"> {{__('buttons.edit')}} </button>
                      </form>
                    </td>
                    {{--<td>
                      <form action="{{route('delete.product')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button type="submit" class="btn btn-danger"> {{__('buttons.delete')}} </button>
                      </form>
                    </td>--}}
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            <span class="badge-warning">
                              {{__('repository.repository_empty')}}
                            </span>
                        </td>
                    </tr>
                    @endif
                  </tbody>
                </table>
                {{ $products->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection