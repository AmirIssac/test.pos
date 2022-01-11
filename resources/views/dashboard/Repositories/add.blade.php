@extends('layouts.main')
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
.test{
  width: 100px !important;
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
            <form action="{{route('repositories.store')}}" method="POST">
                @csrf
                {{-- first card --}}
             <div class="card">
              <div class="card-header card-header-primary">
                  <h4 class="card-title float-right"> بيانات المخزن</h4>
                   </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead class="text-primary">
                                <th>
                                اسم المخزن 
                                </th>
                                <th>
                                  اسم المخزن بالانجليزية  
                                </th>
                                <th>
                                العنوان 
                                </th>
                                <th>
                                نوع المتجر   
                                </th>
                                <th>
                                  الشعار    
                                  </th>
                                  <th class="displaynone branchname">
                                    اسم الشعار    
                                    </th>
                                    <th class="displaynone branchname">
                                       رقم الشعار    
                                      </th>
                                      
                                 </thead>
                                <tbody>
                                <tr>
                                <td>
                                    <input type="text" name="repositoryName" class="form-control" placeholder="اكتب الاسم هنا" required>
                                </td>
                                <td>
                                  <input type="text" name="repositoryName_en" class="form-control" placeholder="اكتب الاسم بالانجليزية هنا">
                              </td>
                                <td>
                                    <input type="text" name="address" class="form-control" placeholder="اكتب العنوان هنا" required>
                                </td>
                                <td>
                                  <select class="form-control" name="category_id" required>
                                    @foreach($categories as $category)
                                    <option value="" disabled selected hidden> انقر هنا لاختيار نوع المتجر </option>
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td>
                                  <select id="branch" class="form-control" name="branch_id" required>
                                    <option value="" disabled selected hidden> انقر هنا لاختيار الشعار الذي يتبع له هذا المحل </option>
                                    <option value="new">شعار جديد</option>
                                    @foreach($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td class="displaynone branchname">
                                  <input name="branch_name" id="branch-name-input">
                                </td>
                                <td class="displaynone branchname">
                                  <input name="company_code" id="company_code" value="{{$code}}" readonly>
                                </td>
                                
                                </tr>
                                   <tr style="color:#007bff">
                                    <th>
                                      نوع الباقة
                                    </th>
                                    <th>
                                       تجريبي
                                    </th>
                                    <th class="displaynone endAt">
                                      ينتهي في ( افتراضيا شهر ) 
                                   </th>
                                   </tr>
                                   <tr>
                                    <td>
                                      <select class="form-control" name="package_id" required>
                                        @foreach($packages as $package)
                                        <option value="{{$package->id}}">{{$package->name_ar}}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>
                                      <input type="checkbox" name="test" value="1" id="test">
                                    </td>
                                    <td class="displaynone endAt">
                                      <input type="date" name="end_at" class="form-control">
                                    </td>
                                   </tr>
                                
                            </tbody>
                            </table>
                            </div>
                            </div>
                        </div>
                  {{-- second card --}}
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title float-right">بيانات المالك</h4>
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
                                  <div style="display: flex;">
                                    <input style="margin: 7px 10px 0 0" type="checkbox" name="exist" id="exist">
                                    <h4 style="margin-right: 10px;" id="stat"> المالك مسجل مسبقا </h4>
                                      </div>
                                 <tr id="notexist" class="visible">
                                   <td>
                                       <input type="text" name="ownerName" class="form-control" placeholder="الاسم ">
                                   </td>
                                   <td>
                                    <input type="email" name="owneremail" class="form-control" placeholder="الايميل">
                                  </td>
                                  <td>
                                    <input type="password" name="ownerpassword" class="form-control" placeholder="كلمة المرور">
                                  </td>
                                  <td>
                                    <input type="text" name="ownerphone" class="form-control" placeholder="رقم الجوال">
                                     </td>
                                  </tr>
                                  <tr id="existed" class="hidden">
                                      <td>   الايميل </td>
                                      <td>
                                      <input style="margin: 7px 10px 0 0" type="email" name="existemail" class="form-control" placeholder="ايميل المالك المسجل مسبقا">
                                      </td>
                                      </tr>
                              </tbody>
                            </table>
                            
                              </div>
                            </div>
                          </div>
                          <button class="btn btn-success"> حفظ </button>
                 </form>
                </div>
              </div>
            </div>
        </div>
@endsection
@section('scripts')
<script>
  $('#exist').change(function(){
  if($('#exist').prop('checked') == true){
    $('#existed').removeClass('hidden').addClass('visible');
    $('#notexist').removeClass('visible').addClass('hidden');
  }
  if($('#exist').prop('checked') == false){
    $('#existed').removeClass('visible').addClass('hidden');
    $('#notexist').removeClass('hidden').addClass('visible');
  }
});
</script>
<script>
  $('#branch').on('change',function(){
    if($(this).val() == 'new'){
      $('.branchname').removeClass('displaynone');
      $('#company_code').removeClass('displaynone');
      $('#branch-name-input').prop('required',true);
    }
    else{
    $('.branchname').addClass('displaynone');
    $('#company_code').addClass('displaynone');
    $('#branch-name-input').prop('required',false);
    }
  });
</script>
<script>
  $('#test').on('change',function(){
    if($('#test:checked').length > 0){
      $('.endAt').removeClass('displaynone');
    }
    else{
      $('.endAt').addClass('displaynone');
    }
  });
</script>
@endsection