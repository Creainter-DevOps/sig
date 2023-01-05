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
.btns_actions {
  color: #fff;
}
</style>
@endsection

@section('content')
<!-- invoice list -->
@if(!empty($parametros))
  <div class="text-center">
    <a href="/licitaciones/nuevas/mas" class="btn btn-sm btn-success shadow mr-1 mb-1" data-pass-value="{{ $parametros['max'] . '-' . $parametros['min'] }}" data-button-dinamic>Borrar y Mostrar más ({{ $parametros['total']}})</a>
  </div>
@endif
<section class="invoice-list-wrapper">
  <!-- create invoice button-->
  <!-- Options and filter dropdown button-->
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
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
           <?=empty($licitacion->empresa())?"Sin rotulo": $licitacion->empresa()->rotulo();?>
          </td>
          <td style="width:200px;">{{ $licitacion->tipo_proceso }} <br /> {{ Helper::money($licitacion->monto) }}</td>
          <td>{{ $licitacion->tipo_objeto }}</td>
          <td>
            <div>
            @php
            foreach(explode(', ', $licitacion->etiquetas) as $e) {
              echo "<span style='font-size: 11px;padding: 2px 5px;background: #ffb68a;color: #fff;display: inline-block;border-radius: 5px;margin-right:5px;'>" . $e . "</span>";
            }
            @endphp
            </div>
            <a href="/licitaciones/{{ $licitacion->id }}" target="_blank" style="color: #363636;">{{ $licitacion->rotulo }}</a>
          </td>
          <td>{{ Helper::fecha($licitacion->fecha_participacion_hasta) }}<br /><span class="{{ $licitacion->estado()['class'] }}">{{ $licitacion->estado()['message'] }}</span></td>
          <td style="vertical-align: top;">
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aprobar Con
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                  @foreach ($licitacion->empresasMenu() as $e)
                    <a class="dropdown-item" href="/licitaciones/{{ $licitacion->id }}/aprobar/{{ $e->id }}" data-button-dinamic>Interés con {{ $e->razon_social }}</a>
                  @endforeach
                </div>
              </div><br />
            <a data-confirm-input="¿Por qué desea Rechazarlo?" href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger glow mr-1 mb-1" data-button-dinamic>Rechazar</a>
          </td>
        </tr>
        </tbody>
        @endforeach
    </table>
  </div>
  </div>
  </div>
</section>
@if(!empty($parametros))
  <div class="text-center">
    <a href="/licitaciones/nuevas/mas" class="btn btn-sm btn-success shadow mr-1 mb-1" data-pass-value="{{ $parametros['max'] . '-' . $parametros['min'] }}" data-button-dinamic>Borrar y Mostrar más ({{ $parametros['total']}})</a>
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
@endsection
