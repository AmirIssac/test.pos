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
            <form action="{{route('store.repository')}}" method="POST">
                @csrf
                {{-- first card --}}
             <div class="card">
              <div class="card-header card-header-primary">
                  <h4 class="card-title float-right">قم بانشاء متجرك الخاص بكل سهولة</h4>
                   </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead class="text-primary">
                                <th>
                                اسم المتجر 
                                </th>
                                <th>
                                  اسم المتجر بالانجليزية  
                                </th>
                                <th>
                                العنوان 
                                </th>
                                <th>
                                نوع المتجر   
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
                                    <input type="text" name="repositoryName" id="repo_name" class="form-control" placeholder="اكتب الاسم هنا" required>
                                </td>
                                <td>
                                  <input type="text" name="repositoryName_en" class="form-control" placeholder="اكتب الاسم بالانجليزية هنا" required>
                              </td>
                                <td>
                                    <input type="text" name="address" class="form-control" placeholder="اكتب العنوان هنا" required>
                                </td>
                                <td>
                                  <select class="form-control" name="category_id" required>
                                    @foreach($categories as $category)
                                    @if($category->name == 'محل خاص' || $category->name == 'مخزن')
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                    @endif
                                    @endforeach
                                  </select>
                                </td>
                                
                                <td class="displaynone branchname">
                                  <input name="branch_name" id="branch-name-input" required>
                                </td>
                                <td class="displaynone branchname">
                                  <input name="company_code" id="company_code" value="{{$code}}" readonly required>
                                </td>
                                </tr>
                                <tr>
                                  <td>
                                    <button class="btn btn-primary"> تأكيد </button>
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
<script>
$('#repo_name').on('keyup change',function(){
  $('#branch-name-input').val($(this).val());
  });
</script>
@endsection