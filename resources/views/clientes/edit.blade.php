@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Editar cliente')
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
<div class="row" id="basic-table">
  <div class="col-12">
<div class="card">
        <div class="card-header">
          <h4 class="card-title">Formulario</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form form-horizontal" action="/clientes/{{ $cliente->id }}" method="POST">
              <div class="form-body">
                {!! method_field('PUT') !!}
                  @include('empresas.form')
    <div class="col-12">
        <div class="form-group">
            <label>Breve Descripción</label>
            <textarea name="descripcion" placeholder="Descripción" class="form-control">{{ old('descripcion', @$cliente->descripcion) }}</textarea>
            @if ($errors->has('descripcion'))
            <div class="invalid-feedback">{{ $errors->first('descripcion') }}</div>
            @endif
        </div>
    </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
  <div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Representantes</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                        <th>Tipo Doc.</th>
                        <th># Doc.</th>
                        <th>Nombres</th>
                        <th>Cargo</th>
                        <th>Género</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th width="5%">Opciones</th>
                    </thead>
                    <tbody>
                        @foreach ($cliente->getContactos() as $contacto)
                        <tr>
                            <td>{{ $contacto->persona()->getTipoDocumento() }}</td>
                            <td>{{ $contacto->persona()->numero_documento }}</td>
                            <td>{{ $contacto->persona()->nombres }} {{ $contacto->persona()->apellidos }}</td>
                            <td>{{ $contacto->getCargo() }}</td>
                            <td>{{ $contacto->persona()->getGenero() }}</td>
                            <td>{{ $contacto->telefono }}</td>
                            <td>{{ $contacto->correo_electronico }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a type="button" href="/clientes/{{ $cliente->id }}/del-representante/{{ $contacto->id }}" data-confirm="Eliminar" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-group" style="margin-left:20px;">{{count($cliente->getContactos())}} Representante(s)</div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRepresentanteModal" style="width: 170px;">
                        Añadir representante
                    </button>
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
