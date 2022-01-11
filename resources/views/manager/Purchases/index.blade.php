@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
  #modalicon:hover{
    cursor: pointer;
  }
  .blue{
    background-color: #0d6efd;
    filter: drop-shadow(5px 5px 5px #001bb7);
    transition: all .2s ease-in-out;
  }
  .blue h4,.blue h6,.blue i{
    color: white;
  }
  .blue:hover{
    background-color: #001bb7;
    transform: scale(1.1);
  }
  .yellow{
    background-color: #f4c721;
    filter: drop-shadow(5px 5px 5px #2d3e4f);
  }
  .yellow:hover{
    background-color: #c49b07;
    transition: all .2s ease-in-out;
    transform: scale(1.1);
  }
  .yellow h4,.yellow h6,.yellow i{
    color:#2d3e4f;
  }
  .red{
    background-color: #ff2626;
    filter: drop-shadow(5px 5px 5px #2d3e4f);
    transition: all .2s ease-in-out;
  }
  .red:hover{
    background-color: #c50909;
    transform: scale(1.1);
  }
  .red h4,.red h6,.red i{
    color: white;
  }
  .view{
    background-color: #bdd4ff;
    filter: drop-shadow(5px 5px 5px #2d3e4f);
    transition: all .2s ease-in-out;
  }
  .view:hover{
    background-color: #96b4ec;
    transform: scale(1.1);
  }
  .view h4,.view h6,.view i{
    color: #0d6efd;
  }
  .add{
    background-color: #28a745;
    filter: drop-shadow(5px 5px 5px #2d3e4f);
    transition: all .2s ease-in-out;
  }
  .add:hover{
    background-color: #159132;
    transform: scale(1.1);
  }
  .add h4,.add h6,.add i{
    color: white;
  }
</style>
     <div class="main-panel">
      
       <div class="content">
        @if (session('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('success') }}</strong>
        </div>
        @endif
         <div class="container-fluid">
           <div class="row">
             @can('انشاء فاتورة مشتريات')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('purchase.add',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">note_add</i>
                   <h4>{{__('purchases.create_purchase_invoice')}}</h4>
                   <h6>{{__('sales.create')}}</h6>
              </div>
            </a>
             </div>
             @endcan

             @can('دفع فاتورة مورد')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.later.purchases',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">request_quote</i>
                   <h4>{{__('purchases.pay_supplier_invoice')}}</h4>
                   <h6>{{__('purchases.pay')}}</h6>
              </div>
            </a>
             </div>
            @endcan
            {{--@can('انشاء فاتورة مشتريات')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modaltrigger">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">compare_arrows</i>
                  </div>
                  <p class="card-category">استرجاع فاتورة مشتريات</p>
                  <h6 class="card-title"></h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">استرجاع فاتورة مشتريات</h5>
                  </div>
                  <form action="{{route('retrieve.purchase.index',$repository->id)}}" method="GET">
                    @csrf
                  <div class="modal-body">
                    ابحث
                    <input type="search" name="search" class="form-control" placeholder="رقم الفاتورة | رقم فاتورة المورد | اسم المورد">
                  </div>
                  <div class="modal-footer">
                    <a data-dismiss="modal" class="btn btn-danger">{{__('buttons.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('sales.search')}}</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
            @endcan--}}
            @can('اضافة منتج مشتريات')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('purchase.products',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">add_box</i>
                   <h4>{{__('purchases.add_purchases_product')}}</h4>
                   <h6>{{__('sales.create')}}</h6>
              </div>
            </a>
             </div>
            @endcan
            @can('عرض فاتورة المشتريات')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.purchases',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">preview</i>
                   <h4>{{__('purchases.view_purchases_invoice')}}</h4>
                   <h6>{{__('sales.view')}}</h6>
              </div>
            </a>
             </div>
            @endcan
            @can('عرض الموردين')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.suppliers',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">people</i>
                   <h4>{{__('purchases.view_suppliers')}}</h4>
                   <h6>{{__('sales.view')}}</h6>
              </div>
            </a>
             </div>
            @endcan
            @can('اضافة مورد')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('add.supplier',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">person_add_alt</i>
                   <h4>{{__('purchases.add_supplier')}}</h4>
                   <h6>{{__('sales.create')}}</h6>
              </div>
            </a>
             </div>
            @endcan
          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('show.purchase.products',$repository->id)}}">
            <div class="box blue">
              <i class="material-icons">category</i>
                 <h4>{{__('repository.view_products')}}</h4>
                 <h6>{{__('sales.view')}}</h6>
            </div>
          </a>
           </div>
          @can('انشاء فاتورة مشتريات')
          <div class="col-lg-3 col-md-6 col-sm-6">
            <form action="{{route('purchase.add',$repository->id)}}" method="GET">
              @csrf
              <input type="hidden" name="old" value="yes">
            <div  onClick="javascript:this.parentNode.submit();" class="box blue">
              <i class="material-icons">pending_actions</i>
                 <h4>{{__('sales.register_invoice')}}</h4>
                 <h6>{{__('sales.by_specific_date')}}</h6>
            </div>
            </form>
           </div>
          @endcan

          


           </div>
         
           </div>
 </body>
 @endsection