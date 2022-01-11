@extends('layouts.main')
@section('links')
<style>
  .on{
    border-radius:50%;
    background-color: #44bb54;
    width: 25px;
    height:25px;
  }
  .off{
    border-radius:50%;
    background-color: #e41b35;
    width: 25px;
    height:25px;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  <form method="POST" action="{{route('make.edit.role.permissions',$role->id)}}">
    @csrf
    @foreach($categories as $category)
    <div class="container-fluid">
     
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4  class="card-title "> {{$category->name}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                   
                    <th>
                      صلاحية الوصول
                    </th>
                    <th>
                        منح \ سحب
                    </th>
                  </thead>
                  <tbody> 
                      

                          @if($category->permissions && $category->permissions->count()>0)
                          @foreach($category->permissions as $permission)
                      <tr>
                        
                        <td>
                            {{$permission->name}}
                        </td>
                        <td>
                            @if($role_permissions->contains('id',$permission->id))  {{-- check if permission taken so checked the button --}}
                            <input style="visibility: hidden" type="checkbox" class="btn-check" id="btn-check-{{$permission->id}}" value="{{$permission->name}}" name="permissions[]" checked autocomplete="off">
                            <label class="on" for="btn-check-{{$permission->id}}"></label>
                            @else
                            <input style="visibility: hidden" type="checkbox" class="btn-check" id="btn-check-{{$permission->id}}" value="{{$permission->name}}" name="permissions[]" autocomplete="off">
                            <label class="off" for="btn-check-{{$permission->id}}"></label>
                            @endif
                        </td>
                      </tr>
                      @endforeach
                      
                      @else
                      <tr>
                          <td>
                              لا يوجد صلاحيات وصول لهذا القسم 
                          </td>
                      </tr>
                      @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      @endforeach  {{-- cat --}}

      <button type="submit" class="btn btn-primary">حفظ</button>
              </form>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
        $('input[type=checkbox]').click(function(){
            if($(this).is(":checked")){
              //$(this).next().html("ON");
              $(this).next().removeClass( "off" ).addClass( "on" );
            }
            else if($(this).is(":not(:checked)")){
             //$(this).next().html("OFF");
              $(this).next().removeClass( "on" ).addClass( "off" );
            }
        });
    });
</script>
@endsection