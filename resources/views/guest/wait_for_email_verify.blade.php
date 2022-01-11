@extends('layouts.guest')
@section('links')
<style>
.hidden{
  visibility: hidden;
}
.visible{
  visibility: visible;
}
.displaynone{
  display: none;
}
</style>
@endsection
@section('body')
<div class="main-panel">
<div class="content">
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
    <div class="container-fluid">
      <div class="row">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="col-md-12">
            <form action="{{route('store.credentials')}}" method="POST">
                @csrf
                  {{-- second card --}}
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title float-right">التحقق من صحة الايميل</h4>
                        </div>
                         <div class="card-body">
                          <h3>اهلا بك سيد {{$name}}</h3>
                          <h5>من فضلك افتح صندوق البريد للايميل الخاص بك واضغط على رابط التحقق من الايميل لتتمكن من تسجيل الدخول و فتح متجرك الخاص بكل سهولة
                              {{$email}}
                          </h5>
                            </div>
                            <div class="card-footer">
                              <a href="/">العودة لصفحة تسجيل الدخول</a>
                            </div>
                          </div>
                 </form>
                </div>
              </div>
            </div>
        </div>
@endsection
@section('scripts')

@endsection