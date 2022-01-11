@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
  #modaltrigger:hover{
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
</style>
     <div class="main-panel">
      
       <div class="content">
        @if (session('retrievedSuccess'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('retrievedSuccess') }}</strong>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('success') }}</strong>
        </div>
        @endif
    
         <div class="container-fluid">
           <div class="row">
           
             @if($repository->isStorehouse())  {{-- مستودع --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('export.invoice.form',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">share</i>
                   <h4>تصدير بضاعة</h4>
                   <h6>انشاء فاتورة</h6>
              </div>
            </a>
             </div>

             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.exports',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">visibility</i>
                   <h4>عرض فواتير التصدير</h4>
                   <h6>{{__('sales.view')}}</h6>
              </div>
            </a>
             </div>

             @endif


            


           </div>
           </div>
 </body>
 @endsection