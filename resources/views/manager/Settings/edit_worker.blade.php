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
  <form method="POST" action="{{route('edit.worker.permissions',$user->id)}}">
    @csrf
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
                @if($category->permissions && $category->permissions->count()>0)
                          @foreach($category->permissions as $permission)
                          {{-- condition to check if this permission containing in the owner permission --}}
                          @if($permissionsOwner->contains('id',$permission->id))
                          {{-- condition to check if the user has this permission because you cant as worker give permission you don't have to another worker --}}
                          @if($user->can($permission->name))
                    <div class="form-check form-switch">
                      <label class="form-check-label">{{$permission->name}}</label>
                           @if($permissions_on->contains('id',$permission->id))  {{-- check if permission taken so checked the button --}}
                            <input class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]" checked>
                            @else
                            <input class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]">
                            @endif
                     </div>
                       <hr>
                    @endif
                     @endif
                @endforeach
            </div>
                      @else
                              لا يوجد صلاحيات وصول لهذا القسم 
                      @endif
                 
      @endforeach  {{-- cat --}}

      <button type="submit" class="btn btn-success">حفظ</button>
              </form>
 </div>
@endsection
