@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Licitaciones Dashboard')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
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
          <th style="width:300px;">Institución</th>
          <th colspan="2">Proceso</th>
          <th>Rótulo</th>
          <th style="width:100px;">Participación</th>
          <th style="width:250px;">Estado</th>
        </tr>
      </thead>
      @foreach ($list as $licitacion )
      <tbody class="block" data-licitacion-id="{{ $licitacion->id }}" data-oportunidad-id="{{ $licitacion->id }}">
        <tr class="block_header">
          <td>{{ $licitacion->empresa()->rotulo() }}</td>
          <td style="width:200px;">{{ $licitacion->tipo_proceso }} <br /> {{ Helper::money($licitacion->monto) }}</td>
          <td>{{ $licitacion->tipo_objeto }}</td>
          <td>{{ $licitacion->rotulo }}</td>
          @if(!empty($licitacion->oportunidad()->aprobado_el))
            <td>{{ Helper::fecha( $licitacion->oportunidad()->aprobado_el ) }}</td>
          @else
            <td></td>
          @endif
           <td style="text-align:center;">
             <span class="{{ $licitacion->estado()['class'] }}">{{ $licitacion->estado()['message'] }}</span>
@if(!empty($licitacion->oportunidad()->archivado_el))
  <div style="color:#ff7878;">Archivado el {{ Helper::fecha($licitacion->oportunidad()->archivado_el) }}</div>
@elseif(!empty($licitacion->oportunidad()->rechazado_el))
  <div style="color:#ff7878;">Rechazado el {{ Helper::fecha($licitacion->oportunidad()->rechazado_el) }}</div>
@endif

@if(!$licitacion->estado()['timeout'])
  @if(!empty($licitacion->oportunidad()->archivado_el) || !empty($licitacion->oportunidad()->rechazado_el))
    <a href="/licitaciones/{{ $licitacion->id }}/aprobar" class="btn btn-sm btn-success mr-25">Volver a Aprobar</a>
  @endif
@endif
           </td>
        </tr>
        <tr class="block_details">
          <td colspan="7"><div>
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nomenclatura</td>
                  <td><a href="/licitaciones/{{ $licitacion->id }}/detalles">{{ $licitacion->nomenclatura }}</a></td> 
                </tr>
                <tr>
                  <td>Registrado</td>
                  <td>{{ Helper::fecha($licitacion->created_on) }}</td>
                </tr>
                <tr>
                  <td>Descripción</td>
                  <td>{{ $licitacion->descripcion }}</td>
                </tr>
                <tr>
                  <td>Participación</td>
                  <td>{{ $licitacion->participacion() }}</td>
                </tr>
                <tr>
                  <td>Propuesta</td>
                  <td>{{ $licitacion->propuesta() }}</td>
                </tr>
                <tr>
                  <td>Adjuntos</td>
                  <td>
                </td>
                </tr>
              </tbody>
            </table>
        </tr>
        </tbody>
        @endforeach
    </table>
  </div>
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script>
$(document).on('click', '.block .btn-success', function(e) {
  e.stopPropagation();
  e.preventDefault();
  var id = $(this).closest('tbody').attr('data-licitacion-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/licitaciones/' + id + '/aprobar'});
  console.log('Aprobar', id);
});
$(document).on('click', '.block .btn-danger', function(e) {
  e.stopPropagation();
  e.preventDefault();
  var id = $(this).closest('tbody').attr('data-licitacionn-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/licitaciones/' + id + '/rechazar'});
  console.log('Eliminar', id);
});
$(document).on('click', '.block_header', function() {
  $(this).parent().find('.block_details').toggle();
});
</script>
@endsection
