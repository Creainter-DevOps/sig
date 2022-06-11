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
      @foreach ($list as $oportunidad)
      <tbody class="block" data-licitacion-id="{{ $oportunidad->id }}" data-oportunidad-id="{{ $oportunidad->id }}">
        <tr class="block_header">
          <td>
            <div style="font-size: 11px;color: #64aafb;">{{ Helper::fecha($oportunidad->created_on, true) }}</div>
            {{ $oportunidad->empresa()->rotulo() }}
          </td>
          <td style="width:200px;">{{ $oportunidad->tipo_proceso }} <br /> {{ Helper::money($oportunidad->monto) }}</td>
          <td>{{ $oportunidad->tipo_objeto }}</td>
          <td>{{ $oportunidad->rotulo }}</td>
          <td>{{ Helper::fecha($oportunidad->fecha_participacion_hasta) }}<br /><span class="{{ $oportunidad->estado()['class'] }}">{{ $oportunidad->estado()['message'] }}</span></td>
          <td style="vertical-align: top;">
            <a href="javascript:void(0);" class="btn btn-sm btn-success shadow mr-1 mb-1">Aprobar</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-danger glow mr-1 mb-1">Rechazar</a>
          </td>
        </tr>
        <tr class="block_details">
          <td colspan="7"><div>
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nomenclatura:</td>
                  <td><a href="/licitaciones/{{ $oportunidad->id }}/detalles">{{ $oportunidad->nomenclatura }}</a></td>
                </tr>
                <tr>
                  <td>Registrado:</td>
                  <td>{{ Helper::fecha($oportunidad->created_on) }}</td>
                </tr>
                <tr>
                  <td>Descripción:</td>
                  <td>{{ $oportunidad->descripcion }}</td>
                </tr>
                <tr>
                  <td>Participación:</td>
                  <td>{{ $oportunidad->participacion() }}</td>
                </tr>
                <tr>
                  <td>Propuesta:</td>
                  <td>{{ $oportunidad->propuesta() }}</td>
                </tr>
                <tr>
                  <td>Adjuntos:</td>
                  <td>
<ul>
            @foreach ($oportunidad->adjuntos() as $a)
              <li><a target="_blank" href="http://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode={{ $a->codigoAlfresco }}">{{ $a->tipoDocumento }}</a></li>
            @endforeach
          </ul>
                  </td>
                </tr>
                <tr>
                  <td>Estado:</td>
                  <td><span class="{{ $oportunidad->estado()['class'] }}">{{ $oportunidad->estado()['message'] }}</span></td>
                </tr>
              </tbody>
            </table>
            <div class="btns_actions">
              <a href="javascript:void(0);" class="btn btn-success shadow mr-1 mb-1">Aprobar</a>
              <a href="javascript:void(0);" class="btn btn-danger glow mr-1 mb-1">Rechazar</a>
            </div>
          </div></td>
        </tr>
        </tbody>
 {{--
      <!--<tbody class="block" data-licitacion-id="{{ $oportunidad->licitacion()->id }}" data-oportunidad-id="{{ $oportunidad->id }}">
        <tr class="block_header">
          <td>{{ $oportunidad->licitacion()->empresa()->rotulo() }}</td>
          <td style="width:200px;">{{ $oportunidad->licitacion()->tipo_proceso }} <br /> {{ Helper::money($oportunidad->licitacion()->monto) }}</td>
          <td>{{ $oportunidad->licitacion()->tipo_objeto }}</td>
          <td>{{ $oportunidad->licitacion()->rotulo }}</td>
          <td>{{ Helper::fecha($oportunidad->licitacion()->fecha_participacion_hasta) }}<br /><span class="{{ $oportunidad->estado()['class'] }}">{{ $oportunidad->estado()['message'] }}</span></td>
          <td style="vertical-align: top;">
            <a href="javascript:void(0);" class="btn btn-sm btn-success shadow mr-1 mb-1">Aprobar</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-danger glow mr-1 mb-1">Rechazar</a>
          </td>
        </tr>
        <tr class="block_details">
          <td colspan="7"><div>
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nomenclatura:</td>
                  <td><a href="/licitaciones/{{ $oportunidad->licitacion_id }}/detalles">{{ $oportunidad->licitacion()->nomenclatura }}</a></td>
                </tr>
                <tr>
                  <td>Registrado:</td>
                  <td>{{ Helper::fecha($oportunidad->licitacion()->created_on) }}</td>
                </tr>
                <tr>
                  <td>Descripción:</td>
                  <td>{{ $oportunidad->licitacion()->descripcion }}</td>
                </tr>
                <tr>
                  <td>Participación:</td>
                  <td>{{ $oportunidad->licitacion()->participacion() }}</td>
                </tr>
                <tr>
                  <td>Propuesta:</td>
                  <td>{{ $oportunidad->licitacion()->propuesta() }}</td>
                </tr>
                <tr>
                  <td>Adjuntos:</td>
                  <td>
<ul>
            @foreach($oportunidad->licitacion()->adjuntos() as $a)
              <li><a target="_blank" href="http://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode={{ $a->codigoAlfresco }}">{{ $a->tipoDocumento }}</a></li>
            @endforeach
          </ul>
                  </td>
                </tr>
                <tr>
                  <td>Estado:</td>
                  <td><span class="{{ $oportunidad->estado()['class'] }}">{{ $oportunidad->estado()['message'] }}</span></td>
                </tr>
              </tbody>
            </table>
            <div class="btns_actions">
              <a href="javascript:void(0);" class="btn btn-success shadow mr-1 mb-1">Aprobar</a>
              <a href="javascript:void(0);" class="btn btn-danger glow mr-1 mb-1">Rechazar</a>
            </div>
          </div></td>
        </tr>
        </tbody>-->
 --}}
        @endforeach
    </table>
  </div>
</section>
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
  var id = $(this).closest('tbody').attr('data-licitacion-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/licitaciones/' + id + '/aprobar'});
  console.log('Aprobar', id);
});
$(document).on('click', '.block .btn-danger', function(e) {
  e.stopPropagation();
  var id = $(this).closest('tbody').attr('data-licitacion-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/licitaciones/' + id + '/rechazar'});
  console.log('Eliminar', id);
});
$(document).on('click', '.block_header', function() {
  $(this).parent().find('.block_details').toggle();
});
</script>
@endsection
