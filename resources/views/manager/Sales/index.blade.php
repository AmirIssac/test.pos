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
            @can('انشاء فاتورة')
            @if($repository->category->name=='مخزن')   {{-- مخزن --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('create.invoice',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">add_circle_outline</i>
                   <h4>{{__('sales.new_invoice')}}</h4>
                   <h6>{{__('sales.create')}}</h6>
              </div>
            </a>
             </div>
             @endif
             @if($repository->isSpecial())  {{-- محل خاص --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('create.special.invoice',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">add_circle_outline</i>
                   <h4>{{__('sales.new_invoice')}}</h4>
                   <h6>{{__('sales.create')}}</h6>
              </div>
            </a>
             </div>
             @endif
             @endcan


             @can('عرض الفواتير المعلقة')

            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.pending',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">incomplete_circle</i>
                   <h4>{{__('sales.hanging_invoice')}}</h4>
                   <h6>{{__('sales.complete')}}</h6>
              </div>
            </a>
             </div>
            @endcan

            
            @can('استرجاع فاتورة')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modaltrigger">
              <div class="box blue">
                  <i class="material-icons">compare_arrows</i>
                   <h4>{{__('sales.retrieve_invoice')}}</h4>
                   <h6>{{__('sales.retrieve')}}</h6>
              </div>
            </a>
             </div>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">{{__('sales.retrieve_invoice')}}</h5>
                    </div>
                    <form action="{{route('retrieve.index',$repository->id)}}" method="GET">
                      @csrf
                    <div class="modal-body">
                      {{__('sales.search_by_mobile_or_invnum')}}
                      <input type="search" name="search" class="form-control" placeholder="{{__('sales.mobile_invnum')}}">
                    </div>
                    <div class="modal-footer">
                      <a data-dismiss="modal" class="btn btn-danger">{{__('buttons.cancel')}}</a>
                      <button type="submit" class="btn btn-primary">{{__('sales.search')}}</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
              @endcan

              @if($repository->isSpecial())  {{-- محل خاص --}}
              @can('انشاء فاتورة')
             @if($repository->isSpecial())  {{-- محل خاص --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <form action="{{route('create.old.special.invoice',$repository->id)}}" method="GET">
                @csrf
                <input type="hidden" name="old" value="yes">
              <div onClick="javascript:this.parentNode.submit();" class="box blue">
                  <i class="material-icons">pending_actions</i>
                   <h4>{{__('sales.register_invoice')}}</h4>
                   <h6>{{__('sales.by_specific_date')}}</h6>
              </div>
              </form>
             </div>
             @endif
             @endcan
             

              @can('عرض العملاء')

            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('clients',$repository->id)}}">
              <div class="box blue">
                <i class="material-icons">people</i>
                   <h4>{{__('sales.customers')}}</h4>
                   <h6>{{__('sales.view')}}</h6>
              </div>
            </a>
             </div>
            @endcan
            @endif


            


           </div>
           </div>
 </body>
 @endsection