@extends('layouts.main')
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
textarea{
  border:2px solid #9229ac;
  border-radius: 10px;
}

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  margin-right: 35px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}


/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: #001bb7;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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
    @if (session('errors'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('errors') }}</strong>
    </div>
    @endif
 
    <div class="container-fluid">
      
      <div class="row">
        <form action="{{route('submit.settings.app',$repository->id)}}"  method="post" enctype="multipart/form-data">
          @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('settings.repository_logo')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.repository_logo')}}
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          <input type="file" name="logo" class="form-control">
                      </td>
                      <td>
                        <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      {{--@if(File::exists(asset('public/storage/'.$repository->logo)))--}}
                      <img style="border-radius: 50%;" src="{{asset('public/storage/'.$repository->logo)}}" width="100px;" height="100px">
                      {{--@else
                        {{__('settings.no_logo_please_upload_one')}}
                      @endif--}}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </form>
      <form action="{{route('general.settings',$repository->id)}}"  method="post">
        @csrf
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">{{__('settings.general_settings')}}</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    {{__('settings.store_name')}}
                 </th>
                 <th>
                  {{__('settings.english_name')}}
               </th>
                 <th>
                  {{__('settings.address')}} 
               </th>
               @if($repository->isBasic())
               <th>
                  {{__('settings.register_customer_data')}}
               </th>
               @endif
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="text" name="repo_name" value="{{$repository->name}}" class="form-control" required>
                    </td>
                    <td>
                      <input type="text" name="repo_name_en" value="{{$repository->name_en}}" class="form-control">
                    </td>
                    <td>
                      <input type="text" name="address" value="{{$repository->address}}" class="form-control" required>
                  </td>  
                  <td>
                    @if($repository->isBasic())
                      @if($repository->setting->customer_data)
                      <label class="switch">
                        <input type="checkbox" name="customer_data" value="yes" checked>
                        <span class="slider round"></span>
                      </label>
                      @else
                      <label class="switch">
                        <input type="checkbox" name="customer_data" value="yes">
                        <span class="slider round"></span>
                      </label>
                      @endif
                    @endif
                  </td>  
                    <td>
                      <button type="submit" class="btn btn-danger"> {{__('buttons.confirm')}} </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
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
  window.onload=function(){
    $(function () {
  $('[data-toggle="popover"]').popover()
  });
  };
  </script>
@endsection