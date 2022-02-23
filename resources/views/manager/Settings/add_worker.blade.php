@extends('layouts.old_bootstrap')
@section('body')
    

    <!-- Start Content -->
    <div class="content add-new-emp">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
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
    <form action="{{route('store.worker',$repository->id)}}" method="POST">
      @csrf
            <h3 class="text-center mb-4 fw-bold">{{__('settings.emp_data')}}</h3>
            <div class="box">
                <div class="row">
                    <div class="col-md-6 pt-4">
                        <div class="form-group d-flex align-items-center">
                            <label for="">{{__('settings.name')}}</label>
                            <input type="text" name="name" class="form-control" placeholder="{{__('settings.name')}}" required>
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label for="">{{__('settings.password')}}</label>
                            <input type="password" name="password" class="form-control" placeholder="{{__('settings.password')}}" required>
                        </div>
                    </div>
                    <div class="col-md-6 pt-4">
                        <div class="form-group d-flex align-items-center">
                            <label for="">{{__('settings.email')}}</label>
                            <input type="email" name="email" class="form-control" placeholder="{{__('settings.email')}}" required>
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label for="">{{__('settings.mobile')}}</label>
                            <input type="text" name="phone" class="form-control" placeholder="{{__('settings.mobile')}}" required>
                        </div>
                    </div>
                </div>
            </div>
            <?php $user = Auth::user(); ?>
            <!-- الصلاحيات -->
            @foreach($categories as $category)
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold mb-3">{{$category->name}}</h5>
                {{--<div class="form-check fs-6">
                    <input type="checkbox" name="" class="ms-2" checked id="all-terms">
                    <label for="all-terms" class="fw-bold color-main">تحديد كل الصلاحيات</label>
                </div>--}}
            </div>
            <div class="box">
                <div class="d-flex justify-content-between options-header">
                    <div>الصلاحية</div>
                    <div>منح/سحب</div>
                </div>
                <hr>
                @foreach($category->permissions as $permission)
                   @if($permissionsOwner->contains('id',$permission->id))  {{-- display the permissions the just owner has --}}
                    {{-- condition to check if the user has this permission because you cant as worker give permission you don't have to another worker --}}
                    @if($user->can($permission->name))
                      @if($permission->name == 'فاحص')
                      <div style="display: none" class="form-check form-switch">
                      <label style="display: none" class="form-check-label">{{$permission->name}}</label>
                      <input style="display: none;" class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]" checked>
                      </div>
                      @else
                      <div class="form-check form-switch">
                      <label class="form-check-label">{{$permission->name}}</label>
                      <input class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]">
                      </div>
                      <hr>
                      @endif
                    @endif
                     @endif
                @endforeach
            </div>
            @endforeach
           
            <div class="d-flex my-4">
                <button class="btn btn-main me-auto" type="submit">حفظ</button>
            </div>
        </form>
        
    </div>
    

   @endsection