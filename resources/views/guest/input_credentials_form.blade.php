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
label{
  font-weight: bold;
  padding: 10px;
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
        @if ($message = Session::get('fail'))
        <div class="alert alert-danger alert-block">
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
                      <h4 class="card-title float-right">أدخل بياناتك من فضلك كمالك للمتجر</h4>
                        </div>
                         <div class="card-body">
                          {{--
                          <div class="table-responsive">
                            <table class="table">
                              <thead class=" text-primary">
                                <th>
                                  الاسم  
                                </th>
                              <th>
                                الايميل 
                              </th>
                              <th>
                                كلمة المرور 
                              </th>
                              <th>
                                رقم الجوال 
                              </th>
                               </thead>
                                 <tbody>
                                  
                                 <tr id="notexist" class="visible">
                                   <td>
                                       <input type="text" name="ownerName" class="form-control" placeholder="الاسم " required>
                                   </td>
                                   <td>
                                    <input type="email" name="owneremail" class="form-control" placeholder="الايميل" required>
                                  </td>
                                  <td>
                                    <input type="password" name="ownerpassword" class="form-control" placeholder="كلمة المرور" required>
                                  </td>
                                  <td>
                                    <input type="text" name="ownerphone" class="form-control" placeholder="رقم الجوال" required>
                                     </td>
                                  </tr>
                                  <tr>
                                    <td>
                                  <button onclick="gtag_report_conversion('/waitFor/verify');" class="btn btn-primary"> التالي </button>
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                              </div>
                            --}}
                            <div id="credentials">
                              <label>الاسم</label>
                              <input type="text" name="ownerName" class="form-control" placeholder="الاسم " required>
                              <label>الايميل</label>
                              <input type="email" name="owneremail" class="form-control" placeholder="الايميل" required>
                              <label>كلمة المرور</label>
                              <input type="password" name="ownerpassword" class="form-control" placeholder="كلمة المرور" required>
                              <label>رقم الجوال</label>
                              <input type="text" name="ownerphone" class="form-control" placeholder="رقم الجوال" required>
                              {{--
                              <button style="margin-top:10px;" onclick="gtag_report_conversion('/');" class="btn btn-primary"> التالي </button>
                              --}}
                              <button style="margin-top:10px;" class="btn btn-primary"> التالي </button>
                            </div>
                            </div>
                          </div>
                 </form>
                </div>
              </div>
            </div>
        </div>

        <div style="margin-top: -15px">
          <a href="https://wa.me/966538027198"> <img style="float: left" src="{{asset('public/images/whatsapp_icon.png')}}" height="75px"> </a>
       </div>
@endsection
@section('scripts')

@endsection