@extends('layouts.main')
@section('body')
<div class="main-panel">
   
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right">جميع المستخدمين<span class="badge badge-success">{{$count}}</span>
              </h4>
                </div> 
                 <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                            اسم العميل
                        </th>
                        <th>
                            الايميل 
                        </th>
                        <th>
                            رقم الجوال 
                        </th>
                        <th>
                            حالة العميل  
                        </th>
                        <th>
                            تاريخ الانضمام   
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
                                  @if($user->getRoleNames()->first() == 'مالك-مخزن')
                                  مالك
                                  @elseif($user->getRoleNames()->first() == 'عامل-مخزن')
                                  عامل
                                  @elseif($user->getRoleNames()->first() == 'مشرف')
                                  مشرف التطبيق
                                  @else
                                  لا يتبع لمتجر بعد
                                  @endif
                                </td>
                                <td>
                                  {{$user->created_at}}
                                </td>
                            </tr>
                           @endforeach
                      </tbody>
                    </table>
                    {!! $users->links() !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
@endsection