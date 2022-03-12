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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> {{__('purchases.suppliers')}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('purchases.name')}}
                    </th>
                    <th>
                      {{__('purchases.address')}}
                    </th>
                    <th>
                      {{__('purchases.phone')}} 
                     </th>
                     <th>
                      {{__('purchases.account_num')}} 
                     </th>
                     <th>
                      {{__('reports.actions')}}
                     </th>
                  </thead>
                  <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                     <td>{{$supplier->name}}</td>
                     <td>{{$supplier->address}}</td>
                     <td>{{$supplier->phone}}</td>
                     <td>{{$supplier->account_num}}</td>
                     <td>
                      <a style="color: #007bff" href="{{route('show.supplier.payments',$supplier->id)}}" class="active-a"> <i class="material-icons">
                        paid
                      </i> </a>
                      
                      {{--
                       <i style="color: #262d35" class="material-icons">
                        paid
                      </i> 
                      --}}
                      .
                      <form action="{{route('edit.supplier')}}" method="POST">
                        @csrf
                        <input type="hidden" name="supplier_id" value="{{$supplier->id}}">
                        <input type="hidden" name="repository_id" value="{{$repository->id}}">
                       <button type="submit" class="fabutton">
                        <i style="color: #b46600" class="material-icons eye">
                            mode_edit_outline
                         </i>
                      </button>
                      </form>
                      {{--
                      .
                      <form action="{{route('delete.supplier')}}" method="POST">
                        @csrf
                        <input type="hidden" name="supplier_id" value="{{$supplier->id}}">
                        <input type="hidden" name="repository_id" value="{{$repository->id}}">
                        <button type="submit" class="fabutton">
                          <i style="color: #cc1625" class="material-icons eye">
                            delete_forever
                           </i>
                        </button>
                      </form>
                      --}}
                    </td>
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                {{ $suppliers->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection