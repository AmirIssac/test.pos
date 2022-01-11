@extends('layouts.main')

@section('body')
<style>
  .fabutton{
    background: none;
    padding: 0px;
    border: none;
  }
  form{
    display: inline-block;
  }
  i{
  transition: all .2s ease-in-out;
}
i:hover{
  transform: scale(1.3);
}
</style>
<div class="main-panel">
 
<div class="content">
  @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> تفاصيل المتجر {{$repository->name}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        تاريخ آخر فاتورة مبيعات 
                    </th>
                    <th>
                        تاريخ آخر فاتورة مشتريات 
                    </th>
                     <th>
                      عدد الاصناف في المخزون
                     </th>
                     <th>
                       عدد القطع في المخزون
                     </th>
                     <th>
                       تنبيه الكاشير
                     </th>
                     <th>
                       حالة الاشتراك
                     </th>
                     <th>
                      اعادة ضبط مصنع
                     </th>
                  </thead>
                  <tbody>
                    <tr>
                    <td>
                        @if($last_invoice)
                        {{$last_invoice->created_at}}
                        @else
                        لا يوجد
                        @endif
                    </td>
                    <td>
                        @if($last_purchase)
                        {{$last_purchase->updated_at}}
                        @else
                        لا يوجد
                        @endif
                    </td>
                    <td>
                      {{$product_types->count()}}
                    </td>
                    <td>
                      {{$number_of_products}}
                    </td>
                    <td>
                      @if(isset($repository->setting))
                      @if($repository->setting->cashier_reminder)
                      {{$repository->setting->cashier_reminder}}
                      @else
                      /
                      @endif
                      @endif
                    </td>
                    <td>
                            @if(isset($repository->setting))
                            @if(!$repository->setting->is_active)
                            <span class="badge badge-danger">
                            منتهي
                            </span>
                            @elseif($repository->setting->end_of_experience)
                            ينتهي في
                            {{$repository->setting->end_of_experience}}
                            ({{$repository->setting->end_of_experience->diffForHumans()}})
                            @else
                            <span class="badge badge-success">
                             دائم
                            </span>
                            @endif
                             <a href="{{route('show.repository.status',$repository->id)}}"> <i class="material-icons">app_registration</i></a>
                            @endif
                    </td>
                    <td>
                <a data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modaltrigger" class="btn btn-danger">
                  اعادة ضبط
                </a>
                                    <!-- Modal for refactoring repository -->
              <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">حذف سجلات المتجر {{$repository->name}}</h5>
                    </div>
                    <form action="{{route('factory.reset',$repository->id)}}" method="POST">
                      @csrf
                    <div class="modal-body">
                      هل أنت متأكد أنك تريد حذف جميع سجلات المتجر وتصفير خزينة الأموال
                    </div>
                    <div class="modal-footer">
                      <a data-dismiss="modal" class="btn btn-danger">{{__('buttons.cancel')}}</a>
                      <button type="submit" class="btn btn-primary">تأكيد</button>
                    </form>
                    </div>
                  </div>
                </div>
                    </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>



        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> المستخدمين <span class="badge badge-info">{{$users->count()}}</span> </h4>
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
                      الجوال
                     </th>
                     <th>
                       آخر تسجيل دخول
                     </th>
                     <th>
                       النوع
                     </th>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                    <td>
                        {{$user->name}}
                    </td>
                    <td>
                       {{$user->email}}
                    </td>
                    <td>
                      {{$user->phone}}
                    </td>
                    <td>
                      {{$user->last_login}}
                    </td>
                    <td>
                      @if($user->hasRole('مالك-مخزن'))
                      <i style="color:#021aa9" class="material-icons">stars</i>
                      @elseif($user->hasRole('عامل-مخزن'))
                      <span class="badge badge-danger">موظف</span>
                      @endif
                      <a href="{{route('edit.user.details',$user->id)}}"><i class="material-icons">edit</i></a>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>
</div>
@endsection