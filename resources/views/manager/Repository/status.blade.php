@extends('layouts.massege')
@section('links')
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
                            حالة متجرك {{$repository->name}} 
                            @if($repository->setting->is_active)
                            (فعال)
                            @else
                            (متوقف)
                            @endif
                        </h3>
                          <h5> 
                              يرجى مراجعة الادارة لتجديد الباقة وتفعيل المتجر من جديد وشكرا لك لاستخدامك
                              Rofood
                          </h5>
                          <h6> للتواصل معنا : info@rofood.co </h6>
                            </div>
                            <div class="card-footer">
                            @if(!$repository->setting->is_active)
                              <a href="{{route('switch.sub')}}">تبديل الفرع</a>
                            @endif
                            </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
@endsection
@section('scripts')

@endsection