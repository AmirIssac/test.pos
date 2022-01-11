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

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
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
 
    <div class="container-fluid">
      <form action="{{route('settings.min',$repository->id)}}"  method="post">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('settings.determine_min')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.min')}}  <span class="badge badge-success">%{{$repository->min_payment}}</span>  
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          <input type="number" name="min" min="0" max="100" value="{{$repository->min_payment}}" class="form-control" placeholder="  اكتب هنا النسبة المئوية مثال 30 تعني 30% " required>
                      </td>
                      <td>
                          <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>

      <form action="{{route('settings.tax',$repository->id)}}"  method="post">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('settings.determine_tax')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.tax')}}  <span class="badge badge-success">%{{$repository->tax}}</span>  
                    </th>
                    <th>
                      {{__('settings.tax_num')}}  
                     </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          <input type="number" name="tax" min="0" max="100" value="{{$repository->tax}}" class="form-control" placeholder="اكتب هنا قيمة الضريبة" required>
                      </td>
                      <td>
                        <input type="text" name="taxcode" value="{{ $repository->tax_code }}" class="form-control" placeholder="اكتب هنا  الرقم الضريبي" required>
                    </td>
                      <td>
                          <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      </form>

      <form action="{{route('settings.max.discount',$repository->id)}}"  method="post">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">تحديد الحد الأعلى للخصم</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      الحد الأعلى للخصم  <span class="badge badge-success">%{{$repository->max_discount}}</span>  
                    </th>
                   
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          <input type="number" name="max_discount" min="0" max="100" value="{{$repository->max_discount}}" class="form-control" required>
                      </td>
                      <td>
                          <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>


      <form action="{{route('discount.settings',$repository->id)}}"  method="post">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('settings.determine_discount_proccess')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.proccess')}}  
                    </th>
                   <th>
                   </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        {{__('settings.percent_discount')}}
                      </td>
                      <td>
                        @if($repository->setting->discount_by_percent == true)
                        <!-- Rounded switch -->
                        <label class="switch">
                        <input type="checkbox" name="discount_by_percent" checked>
                        <span class="slider round"></span>
                        </label>
                        @else
                        <label class="switch">
                        <input type="checkbox" name="discount_by_percent">
                        <span class="slider round"></span>
                        </label>
                        @endif
                      </td>
                    </tr>  
                    @if(!$repository->isBasic() && !$repository->isSpecial())
                    <tr>
                      <td>
                        {{__('settings.value_discount')}}
                      </td>
                      <td>
                        @if($repository->setting->discount_by_value == true)
                        <label class="switch">
                        <input type="checkbox" class="form-control" name="discount_by_value" checked>
                        <span class="slider round"></span>
                        </label>
                        @else
                        <label class="switch">
                        <input type="checkbox" class="form-control" name="discount_by_value">
                        <span class="slider round"></span>
                        </label>
                        @endif
                      </td>
                    </tr>
                    @endif
                    <tr>
                      <tr>
                        <td>
                          {{__('settings.edit_price_discount')}}   
                        </td>
                        <td>
                          @if($repository->setting->discount_change_price == true)
                          <label class="switch">
                          <input type="checkbox" class="form-control" name="discount_change_price" checked>
                          <span class="slider round"></span>
                        </label>
                          @else
                          <label class="switch">
                          <input type="checkbox" class="form-control" name="discount_change_price">
                          <span class="slider round"></span>
                        </label>
                          @endif
                        </td>
                      </tr>
                      <tr>
                      <td>
                        <button type="submit" class="btn btn-success">{{__('buttons.confirm')}}</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>

      

      </div>
    
    </div>
</div>
@endsection