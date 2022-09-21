@extends('layouts.contentLayoutMaster')
{{-- page title --}}
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
<!-- invoice list -->
@if(!empty($parametros))
  <div class="text-center">
    <a href="/licitaciones/nuevas/mas" class="btn btn-sm btn-success shadow mr-1 mb-1" data-pass-value="{{ $parametros['max'] . '-' . $parametros['min'] }}" data-button-dinamic>Mostrar más ({{ $parametros['total']}})</a>
  </div>
@endif
<section class="invoice-list-wrapper">
  <!-- create invoice button-->
  <!-- Options and filter dropdown button-->
  <div class="table-responsive">
    <table class="table table-dark mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Institución</th>
          <th>Proceso</th>
          <th>Objeto</th>
          <th>Rótulo</th>
          <th>Participación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      @foreach ($list as $licitacion)
      <tbody class="block" data-licitacion-id="{{ $licitacion->id }}" data-licitacion-id="{{ $licitacion->id }}">
        <tr class="block_header">
          <td>
            <div style="font-size: 11px;color: #64aafb;">{{ Helper::fecha($licitacion->created_on, true) }}</div>
            {{ $licitacion->empresa()->rotulo() }}
          </td>
          <td style="width:200px;">{{ $licitacion->tipo_proceso }} <br /> {{ Helper::money($licitacion->monto) }}</td>
          <td>{{ $licitacion->tipo_objeto }}</td>
          <td>{{ $licitacion->rotulo }}</td>
          <td>{{ Helper::fecha($licitacion->fecha_participacion_hasta) }}<br /><span class="{{ $licitacion->estado()['class'] }}">{{ $licitacion->estado()['message'] }}</span></td>
          <td style="vertical-align: top;">
            <a href="/licitaciones/{{ $licitacion->id }}/aprobar" class="btn btn-sm btn-success shadow mr-1 mb-1" data-button-dinamic>Aprobar</a>
            <a data-confirm-input="¿Por qué desea Rechazarlo?" href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger glow mr-1 mb-1" data-button-dinamic>Rechazar</a>
          </td>
        </tr>
        <tr class="block_details">
          <td colspan="7"><div>
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nomenclatura:</td>
                  <td><a href="/licitaciones/{{ $licitacion->id }}/detalles">{{ $licitacion->nomenclatura }}</a></td>
                </tr>
                <tr>
                  <td>Registrado:</td>
                  <td>{{ Helper::fecha($licitacion->created_on) }}</td>
                </tr>
                <tr>
                  <td>Descripción:</td>
                  <td>{{ $licitacion->descripcion }}</td>
                </tr>
                <tr>
                  <td>Participación:</td>
                  <td>{{ $licitacion->participacion() }}</td>
                </tr>
                <tr>
                  <td>Propuesta:</td>
                  <td>{{ $licitacion->propuesta() }}</td>
                </tr>
                <tr>
                  <td>Adjuntos:</td>
                  <td>
<ul>
            @foreach ($licitacion->adjuntos() as $a)
              <li><a target="_blank" href="{{ config('constants.static_seace') . $a->codigoAlfresco }}">{{ $a->tipoDocumento }}</a></li>
            @endforeach
          </ul>
                  </td>
                </tr>
                <tr>
                  <td>Estado:</td>
                  <td><span class="{{ $licitacion->estado()['class'] }}">{{ $licitacion->estado()['message'] }}</span></td>
                </tr>
              </tbody>
            </table>
            <div class="btns_actions">
              <a href="/licitaciones/{{ $licitacion->id }}/aprobar" class="btn btn-sm btn-success shadow mr-1 mb-1" data-button-dinamic>Aprobar</a>
              <a data-confirm-input="¿Por qué desea Rechazarlo?" href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger glow mr-1 mb-1" data-button-dinamic>Rechazar</a>
            </div>
          </div></td>
        </tr>
        </tbody>
        @endforeach
    </table>
  </div>
</section>
@if(!empty($parametros))
  <div class="text-center">
    <a href="/licitaciones/nuevas/mas" class="btn btn-sm btn-success shadow mr-1 mb-1" data-pass-value="{{ $parametros['max'] . '-' . $parametros['min'] }}" data-button-dinamic>Mostrar más ({{ $parametros['total']}})</a>
  </div>
@endif
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
$(document).on('click', '.block_header', function() {
  $(this).parent().find('.block_details').toggle();
});
</script>
@endsection
