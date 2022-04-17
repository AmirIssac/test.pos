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
</style>
     <div class="main-panel">
      
       <div class="content">
        
         <div class="container-fluid">
           <div class="row">
            @can('عرض الفواتير')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.invoices',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">receipt</i>
                   <h4>{{__('reports.invoices')}}  {{$invoices_count}}</h4>
                   <h6>{{__('reports.view')}}</h6>
              </div>
            </a>
             </div>
             @if($repository->isBasic())
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.price.invoices',$repository->id)}}">
              <div class="box blue">
                <span class="badge badge-danger">NEW
                <i class="material-icons">receipt</i>
                </span>
                   <h4>{{__('sales.view_price_invoice')}}</h4>
                   <h6>{{__('reports.view')}}</h6>
              </div>
            </a>
             </div>
             @endif
             @endcan
             @can('عرض التقارير اليومية')

             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('daily.reports.index',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">auto_stories</i>
                   <h4>{{__('reports.daily_reports')}}</h4>
                   <h6>{{__('reports.view')}}</h6>
              </div>
            </a>
             </div>
             @endcan
            
             @can('عرض التقارير اليومية')

             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('view.monthly.reports',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">description</i>
                   <h4>{{__('reports.monthly_reports')}}</h4>
                   <h6>{{__('reports.view')}}</h6>
              </div>
            </a>
             </div>
             @endcan
             {{--
             <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats" data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modalicon{{$repository->id}}">
                  <div class="card-header card-header-success card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">note_add</i>
                   </div>
                   <p class="card-category">{{__('reports.create_monthly_report')}}</p>
                   <h6 class="card-title">{{__('reports.create')}}</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">note_add</i>
                   </div>
                 </div>
               </div>
             </div>
                                        <!-- Modal for making monthly report -->
                                        <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">{{__('reports.monthly_report')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true"></span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                {{__('reports.are_you_sure_you_want_to_make_monthly_report')}} {{now()->month}}
                                              </div>
                                              <div class="modal-footer">
                                                <form action="{{route('make.monthly.report',$repository->id)}}" method="POST">
                                                  @csrf
                                                  <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                                <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                              </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div> --}}
           </div>
         
           </div>
 </body>
 @endsection