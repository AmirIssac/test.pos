@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  #warning{
    font-size: 38px;
  }
  #code{
    float: left;
  }
  #myTable th{
   color: black;
   font-weight: bold;
  }
  #myTable td{
   color: black;
   font-weight: bold;
  }
</style>
@endsection
@section('body')
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
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> {{$repository->name}} فرع {{$repository->address}}  </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('edit.repository.status',$repository->id)}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      حالة الاشتراك
                    </th>
                    <th>
                        ينتهي في
                    </th>
                    <th>
                        تفعيل
                    </th>
                    <th>
                        تعطيل
                    </th>
                    <th>
                        تعديل مدة الاشتراك 
                    </th>
                  </thead>
                  <tbody>
                   <tr>
                       <td>
                           @if($setting->is_active)
                           <span class="badge badge-success">
                               فعال
                           </span>
                           @else
                           <span class="badge badge-danger">
                               متوقف
                           </span>
                           @endif
                       </td>
                       <td>
                           @if($setting->end_of_experience)
                           {{$setting->end_of_experience}}
                           @else
                           /
                           @endif
                       </td>
                       <td>
                           @if(!$setting->is_active)
                           <input type="radio" name="activate" value="1">
                           @else
                           <input type="radio" name="activate" value="1" checked>
                           @endif
                       </td>
                       <td>
                        @if(!$setting->is_active)
                        <input type="radio" name="activate" value="0" checked>
                        @else
                        <input type="radio" name="activate" value="0">
                        @endif
                    </td>
                    <td>
                        <input type="date" name="end_at" class="form-control">
                    </td>
                   </tr>
                   <tr>
                     <td>
                     <button type="submit" class="btn btn-primary">تأكيد</button>
                     </td>
                   </tr>
                  </tbody>
                </table>
            </form>

              </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
</div>
@endsection