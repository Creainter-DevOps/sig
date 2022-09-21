@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Usuarios')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2" style="margin-bottom: 10px;">
          <a class="btn btn-primary" href="/usuarios/crear"> + Nuevo </a>
        </div>
    </div>
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Nombres</th>
          <th>U.Sesion</th>
          <th></th>
          <th width="5%">Opciones</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($listado as $usuario)
        <tr>
          <td>{{ $usuario->id }}</td>
          <td>{{ $usuario->usuario }}</td>
          <td>{{ $usuario->usuario }}</td>
          <td>{{ $usuario->sip_user}} </td>
          <td></td>
          <td class="text-center py-1">
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                </span>
                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(19px, -7px, 0px);">
                  <a class="dropdown-item" href="{{ route('usuarios.show', ['usuario' => $usuario->id ]) }}"><i class="bx bx-show-alt mr-1"></i> Ver Mas </a>
                  <a class="dropdown-item" href="{{ route('usuarios.edit', [ 'usuario' =>  $usuario->id ]) }}"  ><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="{{ route('usuarios.destroy', ['usuario' => $usuario->id ]) }}" href="#" ><i class="bx bx-trash mr-1"></i> Eliminar</a> 
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
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>  
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script>
$(document).on('click', '.block .btn-success', function(e) {
  e.stopPropagation();
  var id = $(this).closest('tbody').attr('data-candidato-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/oportunidad/' + id + '/aprobar'});
  console.log('Aprobar', id);
});
$(document).on('click', '.block .btn-danger', function(e) {
  e.stopPropagation();
  var id = $(this).closest('tbody').attr('data-candidato-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/oportunidad/' + id + '/rechazar'});
  console.log('Eliminar', id);
});
$(document).on('click', '.block_header', function() {
  $(this).parent().find('.block_details').toggle();
});
</script>
@endsection
