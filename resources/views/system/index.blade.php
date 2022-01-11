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
    @if (session('fail'))
    <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ session('fail') }}</strong>
  </div>
  @endif
          
            <div class="container-fluid">
            <div class="row">
           @if(Auth::user()->hasRole('مشرف'))
          <div class="col-lg-3 col-md-6 col-sm-6">
            <a>
            <div class="box blue" data-toggle="modal" data-target="#exampleModal" id="modalicon">
              <i class="material-icons">upload</i>
                 <h4>انشاء تقرير شهري للمتاجر</h4>
                 <h6>انشاء</h6>
            </div>
          </a>
           </div>

                                    <!-- Modal for making monthly report -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{__('reports.monthly_report')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true"></span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            {{__('reports.are_you_sure_you_want_to_make_monthly_report')}} {{now()->month}}
                                          </div>
                                          <div class="modal-footer">
                                            <form action="{{route('make.monthly.report.for.all')}}" method="POST">
                                              @csrf
                                              <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                            <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                          </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div> 





                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                      <form action="{{route('reset.invoices.counter')}}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary">تهيئة عداد الفواتير</button>
                                      </form>
                                     </div>
             @endif

           

</div>
  </div>
 </body>
 @endsection