@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Proveedores')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<style>
tr.block_header {
  cursor: pointer;
}
tr.block_details {
  display:none;
}
tr.block_details>td {
  padding: 5px;
}
tr.block_details>td>div {
  background: #f2f4f4;
  border-radius: 2px;
  padding: 5px;
  margin: 5px 10px;
  color: #000;
}
.btns_actions {
  color: #fff;
  text-align: right;
}
</style>
@endsection

@section('content')
    <div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;">
                <a class="btn btn-primary" href="/proveedores/crear">
                     + Nuevo
                </a>
        </div>
    </div>
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <!--<div class="card-header">
        <h4 class="card-title">Proveedores </h4>
      </div>-->
      <div class="card-content">
        <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Id</th>
          <th>RUC</th>
          <th>Razon social</th>
          <th>Seudonimo</th>
          <th>Telefono</th>
          <th>Web</th>
          <th width="5%">Opciones</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($listado as $proveedor )
        <tr>
          <td>{{ $proveedor->id }}</td>
          <td>{{ $proveedor->empresa()->ruc }}</td>
          <td>{{ $proveedor->empresa()->razon_social }}</td>
          <td>{{ $proveedor->empresa()->seudonimo }}</td>
          <td>{{ $proveedor->empresa()->telefono }}</td>
          <td>{{ $proveedor->empresa()->web }}</td>
          <td class="text-center py-1">
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                </span>
                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(19px, -7px, 0px);">
                  <a class="dropdown-item" href="{{ route('proveedores.show', ['proveedor' => $proveedor->id ]) }}"><i class="bx bx-show-alt mr-1"></i> Ver Mas </a>
                  <a class="dropdown-item" href="{{ route('proveedores.productos', ['proveedor' => $proveedor->id ]) }}"><i class="bx bx-show-alt mr-1"></i> Productos </a>
                  <a class="dropdown-item" href="{{ route('proveedores.edit', [ 'proveedor' =>  $proveedor->id ]) }}"  ><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="{{ route('proveedores.destroy', ['proveedor' => $proveedor->id ]) }}" href="#" ><i class="bx bx-trash mr-1"></i> Eliminar</a> 
                </div>
              </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $listado->links() }}
    <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div>
  </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>  
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection
