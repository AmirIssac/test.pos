@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
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
              <h4 class="card-title">{{__('repository.all_products')}}</h4>
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
                    
                    <th>
                      {{__('sales.price')}}   
                    </th>
                    
                    <th>
                      {{__('purchases.store_in_stock')}}
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
                     <td>
                        {{$product->price}}
                    </td>
                   <td>
                     @if($product->store_in_stock)
                     <span class="badge badge-success">{{__('purchases.yes')}}</span>
                     @else
                     <span class="badge badge-danger">{{__('purchases.no')}}</span>
                     @endif
                   </td>
                    <td>
                      
                        <a href="{{route('edit.purchase.product',$product->id)}}" class="btn btn-info"> {{__('buttons.edit')}} </a>
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
                            <span class="badge badge-warning">
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