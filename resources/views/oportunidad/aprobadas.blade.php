@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice List')
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
<!-- invoice list -->
<section class="invoice-list-wrapper">
  <!-- create invoice button-->
  <!-- Options and filter dropdown button-->
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Nomenclatura</th>
          <th>Institución</th>
          <th>Proceso</th>
          <th>Objeto</th>
          <th>Rótulo</th>
          <th>Participación</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($list as $oportunidad)
        <tr>
          <td><a href="/oportunidad/{{ $oportunidad->id }}/detalles">{{ $oportunidad->licitacion()->nomenclatura }}</a></td>
          <td>{{ $oportunidad->licitacion()->entidad }}</td>
          <td>{{ $oportunidad->licitacion()->tipo_proceso }}</td>
          <td>{{ $oportunidad->licitacion()->tipo_objeto }}</td>
          <td>{{ $oportunidad->licitacion()->rotulo }}</td>
          <td>{{ Helper::fecha($oportunidad->licitacion()->fecha_participacion_hasta) }}</td>
@if(!$oportunidad->estado()['timeout'] || true)
          <td><span class="{{ $oportunidad->estado()['class'] }}">{{ $oportunidad->estado()['message'] }}</span></td>
          @else
            <td><a href="/oportunidad/{{ $oportunidad->id }}/archivar" class="{{ $oportunidad->estado()['class'] }}">{{ $oportunidad->estado()['message'] }}</a></td>
            @endif
        </tr>
        @endforeach
        </tbody>
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
  var id = $(this).closest('tbody').attr('data-oportunidad-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/oportunidad/' + id + '/aprobar'});
  console.log('Aprobar', id);
});
$(document).on('click', '.block .btn-danger', function(e) {
  e.stopPropagation();
  var id = $(this).closest('tbody').attr('data-oportunidad-id');
  $(this).closest('tbody').remove();
  $.ajax({ url: '/oportunidad/' + id + '/rechazar'});
  console.log('Eliminar', id);
});
$(document).on('click', '.block_header', function() {
  $(this).parent().find('.block_details').toggle();
});
</script>
@endsection
