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
        @if (session('successWorker'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('successWorker') }}</strong>
        </div>
        @endif
        @if ($message = Session::get('fail'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
    
         <div class="container-fluid">
           <div class="row">
            @can('المالية')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('settings.min.form',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">paid</i>
                   <h4>{{__('settings.financial_settings')}}</h4>
                   <h6>{{__('settings.customize')}}</h6>
              </div>
            </a>
             </div>
             @endcan
            

           {{--  @can('اضافة موظف جديد')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('add.worker',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">person_add_alt</i>
                  </div>
                  <p class="card-category">{{__('settings.add')}}</p>
                  <h6 class="card-title"> {{__('settings.new_employee')}} </h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endcan --}}

           

            @can('عرض الموظفين')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.workers',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">paid</i>
                   <h4>{{__('settings.employees')}}</h4>
                   <h6>{{__('settings.customize')}}</h6>
              </div>
            </a>
             </div>
            @endcan

            @can('التطبيق')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('print.settings',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">settings_suggest</i>
                   <h4>{{__('settings.print_time_settings')}}</h4>
                   <h6>{{__('settings.customize')}}</h6>
              </div>
            </a>
             </div>
            @endcan
           
           
            @can('التطبيق')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('settings.app',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">settings_suggest</i>
                   <h4>{{__('settings.app')}}</h4>
                   <h6>{{__('settings.customize')}}</h6>
              </div>
            </a>
             </div>
            @endcan

           {{-- @if(Auth::user()->hasRole('مالك-مخزن'))  --}}
            @can('التطبيق')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('activity.log',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">device_hub</i>
                   <h4>{{__('settings.activity_record')}}</h4>
                   <h6>{{__('reports.view')}}</h6>
              </div>
            </a>
             </div>
            @endcan


           </div>
         
           </div>


 </body>
 @endsection