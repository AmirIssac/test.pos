@extends('layouts.main')
@section('body')
<style>
  .card-header{
    background-color: #0d6efd;
    color: white;
    font-weight: bold;
  }
  .warning{
    background-color: #001bb7;
    color: white;
    font-weight: bold;
  }
  #myTable td{
    font-weight: bold;
    font-size: 16px;
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
  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger alert-block">
    @foreach($errors->all() as $error)
    {{$error}}
    @endforeach
  </div>
  @endif
  @if(session()->has('failures'))
    <table class="table table-danger">
      <tr>
        <th>السطر</th>
        <th>الواصفة</th>
        <th>الخطأ</th>
        <th>القيمة</th>
      </tr>
      @foreach (session()->get('failure') as $validation )
        <tr>
          <td>{{$validation->row()}}</td>
          <td>{{$validation->attribute()}}</td>
          <td>
            <ul>
              @foreach ($validation->errors() as $e )
                <li> {{$e}} </li>
              @endforeach
            </ul>
          </td>
          <td>{{$validation->values()[$validation->attribute()]}}</td>
        </tr>
      @endforeach
    </table>
  @endif 
  <form method="POST" action="{{route('import.excel',$repository->id)}}" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('repository.import_stock_by_excel')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
                    <th>
                      {{__('repository.file')}}  
                    </th>
                  </thead>
                  <tbody>
                     <tr>
                         <td>
                             <input type="file" name="excel">
                         </td>
                         <td>
                            <button type="submit" class="btn btn-primary"> {{__('buttons.confirm')}} </button>
                        </td>
                     </tr>
                  </tbody>
                </table>
              </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header warning">
          <h4 class="card-title ">  {{__('repository.important_info')}}  </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
  <div class="table-responsive">
    @if($repository->isSpecial())
    <table id="myTable" class="table">
      <tbody>
         <tr>
             <td>
              {{__('repository.file_must_has_headers')}} 
              <a href="{{route('download.excel.file','نموذج استيراد للنظارات.xlsx')}}">تحميل الملف</a>
             </td>
         </tr>
         <tr>
           <td>
            {{__('repository.order_columns')}}
           </td>
         </tr>
         <tr>
           <td>
            {{__('repository.special_column_one')}}
           </td>
         </tr>
         <tr>
          <td>
            {{__('repository.special_column_two')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_three')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_four')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_five')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_six')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_seven')}}
            <select class="form-control">
              @if(LaravelLocalization::getCurrentLocale() == 'ar')
              @foreach($types as $type)
                      <option value="" disabled selected hidden> {{__('repository.click_here_to_see_number_of_types')}} </option>
                      <option disabled> {{$type->name_ar.'  '.($type->id)}} </option>
              @endforeach
              @endif
              @if(LaravelLocalization::getCurrentLocale() == 'en')
              @foreach($types as $type)
                      <option value="" disabled selected hidden> {{__('repository.click_here_to_see_number_of_types')}} </option>
                      <option disabled> {{$type->name_en.'  '.($type->id)}} </option>
              @endforeach
              @endif
            </select>
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_eight')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_nine')}}
          </td>
        </tr>
      </tbody>
    </table>
    @else
    <table id="myTable" class="table">
      <tbody>
         <tr>
             <td>
              {{__('repository.file_must_has_headers')}}
              <a href="{{route('download.excel.file','نموذج استيراد للمخزن.xlsx')}}">تحميل الملف</a>
            </td>
         </tr>
         <tr>
           <td>
            {{__('repository.order_columns')}}
           </td>
         </tr>
         <tr>
           <td>
            {{__('repository.special_column_one')}}
           </td>
         </tr>
         <tr>
          <td>
            {{__('repository.special_column_two')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_three')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_four')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_five')}}
          </td>
        </tr>
        <tr>
          <td>
            {{__('repository.special_column_six')}}
          </td>
        </tr>
      </tbody>
    </table>
    @endif

  </div>
  </div>
        </div>
      </div>
    </div>
  </div>




</div>
</form>
  
</div>
@endsection



