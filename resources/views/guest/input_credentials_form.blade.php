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
                                  <button class="btn btn-primary"> التالي </button>
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                            
                              </div>
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