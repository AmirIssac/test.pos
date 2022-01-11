@extends('layouts.main')
@section('body')
<div class="main-panel">
   
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right">كل المخازن<span class="badge badge-success">{{$repositories->count()}}</span>
              </h4>
                </div> 
                 <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th>
                          اسم المتجر
                        </th>
                        <th>
                           الايميل
                        </th>
                        <th>
                          رقم الجوال  
                        </th>
                        <th>
                          المالك
                       </th>
                       <th>
                            نوع المتجر
                        </th>
                        <th>
                          الباقة
                      </th>
                      <th>
                        نوع الاشتراك
                      </th>
                       </thead>
                         <tbody>
                         @if($repositories && $repositories->count()>0)
                         @foreach($repositories as $repository)
                         {{-- get the owner details --}}
                         <?php 
                         if($repository->users()->count()>0){
                              $users = $repository->users;
                              foreach($users as $user){
                                if($user->hasRole('مالك-مخزن')){
                                  $owner = $user;
                                  break;
                                }
                              }
                        }
                        else{
                              $owner = null;
                        }
                         ?>
                         <tr>
                           <td>
                             {{$repository->id}}
                           </td>
                           <td>
                             {{$repository->name}}
                           </td>
                           <td>
                             @if($owner)
                             {{$owner->email}}
                             @else
                             Null
                             @endif
                           </td>
                           <td>
                            @if($owner)
                             {{$owner->phone}}
                             @else
                             Null
                             @endif
                          </td>
                          <td>
                            @if($owner)
                            {{$owner->name}}
                            @else
                             Null
                             @endif
                          </td>
                          <td>
                            {{$repository->category->name}}
                          </td>
                           <td>
                            {{$repository->package->name_ar}}
                          </td>
                          <td>
                            @if(isset($repository->setting))
                            @if(!$repository->setting->is_active)
                            منتهي
                            @elseif($repository->setting->end_of_experience)
                            فعال | تجريبي
                            @else
                            فعال | دائم
                            @endif
                            @endif
                          </td>
                          <td>
                            <a style="color: #007bff" href="{{route('repositories.show',$repository->id)}}" class="active-a"> <i class="material-icons">
                              visibility
                            </i> </a>
                          {{--
                           <td>
                            {{$repository->owner()}}   
                           </td> --}}
                          </tr>
                         @endforeach
                         @else
                         <tr>
                           <td>
                            لا يوجد مخازن في النظام
                           </td>
                           <td>
                             لا يوجد
                           </td>
                         </tr>
                         @endif
                             <tr>
                            <td> مخزن جديد </td>
                            <td> <a style="color: white" href="{{route('repositories.create')}}" role="button" class="btn btn-primary"> إنشاء </a> </td>
                        </tr>
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