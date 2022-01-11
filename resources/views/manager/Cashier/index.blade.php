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
        @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
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
             @can('ايداع في الكاشير')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="box blue" data-toggle="modal" data-target="#exampleModa{{$repository->id}}" id="modalicon{{$repository->id}}">
                <i class="material-icons">input</i>
                   <h4>{{__('cashier.deposit')}}</h4>
                   <h6>{{__('cashier.add')}}</h6>
              </div>
             </div>
                   <!-- Modal -->
<div class="modal fade" id="exampleModa{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModaLabel{{$repository->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('deposite.cashier',$repository->id)}}" method="POST">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModaLabel{{$repository->id}}">  {{__('cashier.deposite_in_cashier')}}    </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        {{__('cashier.determine_the_money_you_want_deposite')}}
          <input type="number" step="0.01"  min="0.01" name="money" placeholder="{{__('cashier.amount_value')}}" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
      </div>
    </div>
  </form>

  </div>
</div>
             @endcan

            {{-- @can('سحب من الكاشير') --}}
            @can('سحب من الكاشير')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="box blue" data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modalicon{{$repository->id}}">
                <i class="material-icons">money_off</i>
                   <h4>{{__('cashier.withdraw')}}</h4>
                   <h6>{{__('cashier.withdraw')}}</h6>
              </div>
             </div>
            <!-- Modal -->
<div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('withdraw.cashier',$repository->id)}}" method="POST">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}"> {{__('cashier.withdraw_from_cashier')}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        {{__('cashier.determine_the_money_you_want_withdraw')}}
          <input type="number" step="0.01" min="0.01" name="money" value="{{$repository->balance}}" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
      </div>
    </div>
  </form>

  </div>
</div>
           {{-- @endcan --}}
           @endcan


           @can('اغلاق الكاشير')
            {{--@if($repository->dailyReportsDesc->count()>0)
           @if($repository->lastDailyReportDate()==now()->format('d'))
           <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats" data-toggle="modal" data-target="#exampleModal" id="modalicon">
            <div class="card-header card-header-secondary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">live_help</i>
              </div>
              <p class="card-category">{{__('cashier.close_cashier')}}</p>
              <h6 class="card-title">   {{__('cashier.will_be_available')}}  {{$repository->timeRemaining()}} </h6>
            </div>
            <div class="card-footer">
              <div class="stats">
                {{__('cashier.unavailable')}}
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{__('cashier.employee_close')}} {{$repository->dailyReportsDesc()->first()->user->name}} {{__('cashier.in_date')}} {{$repository->dailyReportsDesc()->first()->created_at}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">موافق</button>
      </div>
    </div>
  </div>
</div>
           @else
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('daily.cashier.form',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">calculate</i>
                  </div>
                  <p class="card-category">{{__('cashier.close_cashier')}}</p>
                  <h6 class="card-title">{{__('cashier.daily')}}</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    {{__('cashier.available')}}
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endif
            @else  
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('daily.cashier.form',$repository->id)}}">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                <i class="material-icons">calculate</i>
                </div>
                <p class="card-category">{{__('cashier.close_cashier')}}</p>
                <h6 class="card-title">{{__('cashier.daily')}}</h6>
              </div>
              <div class="card-footer">
                <div class="stats">
                  {{__('cashier.available')}}
                </div>
              </div>
            </div>
          </a>
          </div>
            @endif--}}
           
          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('daily.cashier.form',$repository->id)}}">
            <div class="box blue">
              <i class="material-icons">calculate</i>
                 <h4>{{__('cashier.close_cashier')}}</h4>
                 <h6>{{__('cashier.daily')}}</h6>
            </div>
          </a>
           </div>
            @endcan


           </div>
         
           </div>
 {{-- @endforeach  --}}
 </body>
 @endsection