@extends('layouts.massege')
@section('links')
<style>
  table span{
    width: 50px;
  }
   /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
                        <h4 class="card-title float-right">
                          </h4>
                          </div>
                           <div class="card-body">
                            <h3>
                              تذكير باغلاق الكاشير  
                            </h3>
                            <h5> 
                              @if($daily_report)
                                إن آخر اغلاق للكاشير في متجرك تم بتاريخ {{$daily_report->created_at->format('Y-m-d')}}
                                بتوقيت {{$daily_report->created_at->format('h:i A')}}
                              @endif
                            </h5>
                              </div>
                              <div class="card-footer">
                                <form action="{{route('ignore.cashier.reminder',$repository->id)}}" method="POST">
                                  @csrf
                                <button class="btn btn-danger">تجاهل</button>
                                <a href="{{route('daily.cashier.form.from.warning',$repository->id)}}" class="btn btn-primary">الانتقال لصفحة اغلاق الكاشير</a>
                              </form>
                              </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
@endsection