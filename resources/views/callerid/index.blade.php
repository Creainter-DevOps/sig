@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Callerids')
{{-- vendor style --}}
@section('vendor-styles')
@endsection
{{-- page style --}}
@section('page-styles')
@endsection

@section('content')
    <div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;text-align:right;">
          <a class="btn btn-default" href="/callerids/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
              Nuevo
          </a>
        </div>
    </div>
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Callerids</h4>

        <form action="callerids" method="POST" name="">
          {{csrf_field()}}
        <div class="col-4 d-flex justify-content-between">
        <select class="form-control" >
          <option value="2" >2</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
        </select>
        <button class="btn btn-primary" type="submit"> Enviar </button>
       </div>
        </form>
        

      </div>
      <div class="card-content">
        <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Empresa</th>
          <th>Rótulo</th>
          <th>Uri</th>
          <th>Numero</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach ($listado as $callerid)
        <tr>
          <td>{{ $callerid->id }}</td>
          <td><div>{{ isset($callerid->empresa_id) ? $callerid->empresa()->rotulo() : ''  }}</div></td>
          <td>{{ $callerid->rotulo }}</td>
          <td>{{ $callerid->uri }}</td>
          <td>{{ $callerid->number }}</td>
          <td class="text-center py-1">
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                </span>
                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(19px, -7px, 0px);">
                  <a class="dropdown-item" href="/callerids/{{ $callerid->id }}/"><i class="bx bx-show-alt mr-1"></i> Ver mas</a>
                  <a class="dropdown-item" href="{{ route('callerids.edit', ['callerid'=>  $callerid->id ]) }}"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="/callerids/{{ $callerid->id }}" href="#" > <i class="bx bx-trash mr-1"></i> Eliminar</a> 
                </div>
              </div>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
      </div>
      </div>
      <div class="card-footer"> 
        {{ $listado->links() }}
      </div>   
      <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
@endsection
{{-- page scripts --}}
@section('page-scripts')
@endsection
