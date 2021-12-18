@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Editar cliente')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection

@section('content')
<div class="row" id="basic-table">
  <div class="col-12">
<div class="card">
        <div class="card-header">
          <h4 class="card-title">Editar Cliente</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form form-horizontal form-data" action="/clientes/{{ $cliente->id }}" method="POST">
              <div class="form-body">
                {!! method_field('PUT') !!}
                  @include('clientes.form')
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
  <div>
    <!--<div class="block">
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
        </div>-->
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
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
@endsection
