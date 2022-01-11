@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
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
        @if (session('editProductSuccess'))
        <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ session('editProductSuccess') }}</strong>
      </div>
      @endif
      @if (session('deleteProductSuccess'))
      <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ session('deleteProductSuccess') }}</strong>
    </div>
    @endif
    @if (session('fail'))
    <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ session('fail') }}</strong>
  </div>
  @endif
          
            <div class="container-fluid">
            <div class="row">
              @can('ادخال بضاعة للمخزون')
              <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('add.product.form',$repository->id)}}">
                <div class="box blue">
                  <i class="material-icons">qr_code_scanner</i>
                     <h4>{{__('repository.add_stock')}}</h4>
                     <h6>scanner</h6>
                </div>
              </a>
               </div>
              @endcan
                  @can('استيراد ملف excel')
              <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('import.excel.form',$repository->id)}}">
                <div class="box blue">
                  <i class="material-icons">download</i>
                     <h4>{{__('repository.import_stock')}}</h4>
                     <h6>Excel</h6>
                </div>
              </a>
               </div>
              @endcan
              @can('عرض البضائع')

          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('show.products',$repository->id)}}">
            <div class="box blue">
              <i class="material-icons">category</i>
                 <h4>{{__('repository.view_products')}}</h4>
                 <h6>{{__('reports.view')}}</h6>
            </div>
          </a>
           </div>
          @endcan

          @if($repository->isSpecial())
          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('show.incoming.exports',$repository->id)}}">
            <div class="box blue">
              <i class="material-icons">visibility</i>
                 <h4>فواتير المستودع</h4>
                 <h6>{{__('sales.view')}}</h6>
            </div>
          </a>
           </div>
           @endif
           

</div>
  </div>
 </body>
 @endsection