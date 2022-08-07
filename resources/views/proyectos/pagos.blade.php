<div style="margin-top: -25px;text-align: right;">
  <a class="btn btn-sm m-0" href="/proyectos/{{ $proyecto->id }}/financiero" target="_blank">
    <i class="bx bx-printer"></i> Reporte
  </a>
  <button type="button" class="btn btn-sm m-0" data-popup="/pagos/crear?proyecto_id={{ $proyecto->id }}">
    <i class="bx bx-plus"></i>Nuevo Pago
  </button>
</div>
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <thead>
    <tr>
      <th colspan="7" class="table-head">
        <a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Pagos del Proyecto</a>
      </th>
    </tr>
    <tr class="text-center">
      <th>Número</th>
      <th>Fecha</th>
      <th>Descripción</th>
      <th>Monto</th>
      <th>Estado</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->pagos()) == 0)
    <tr>
      <td colspan="7" style="text-align:center;"><i>No se ha registrado pagos</i></td>
    </tr>
@else
  @foreach($proyecto->pagos() as $e)
    <tr>
      <td class="text-center">{{ $e->numero }}</td>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td>{{ $e->descripcion }}</td>
      <td class="text-center">{{ $e->monto() }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
      <td style="width: 55px;text-align: center;">
         <a href="javascript:void(0)" data-popup="{{ route( 'pagos.edit', [ 'pago' => $e->id ] ) }}"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('pagos.destroy', [ 'pago' => $e->id ])}}"><i class="bx bx-trash"></i></a>
      </td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
