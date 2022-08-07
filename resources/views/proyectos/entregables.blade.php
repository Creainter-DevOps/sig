<div style="margin-top: -25px;text-align: right;">
  <a class="btn btn-sm m-0" href="/proyectos/{{ $proyecto->id }}/pdf/situacion" target="_blank">
    <i class="bx bx-printer"></i> Reporte
  </a>
  <button type="button" class="btn btn-sm m-0" data-popup="/entregables/crear?proyecto_id={{ $proyecto->id }}">
    <i class="bx bx-plus"></i>Nuevo Entregable
  </button>
</div>
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <thead>
    <tr>
      <th colspan="7" class="table-head">
        <a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Entregables del Proyecto</a>
      </th>
    </tr>
    <tr class="text-center">
      <th>Número</th>
      <th>Fecha</th>
      <th>Descripción</th>
      <th>Pago</th>
      <th>Estado</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->entregables()) == 0)
    <tr>
      <td colspan="7" style="text-align:center;"><i>No se ha registrado entregables</i></td>
    </tr>
@else
  @foreach($proyecto->entregables() as $e)
    <tr>
      <td class="text-center">{{ $e->numero }}</td>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td>{{ $e->descripcion }}</td>
      <td class="text-center">{{ !empty($e->pago_id) ? $e->pago()->rotulo() : '' }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
      <td style="width: 55px;text-align: center;">
         <a href="javascript:void(0)" data-popup="{{ route( 'entregables.edit', [ 'entregable' => $e->id ] ) }}"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('entregables.destroy', [ 'entregable' => $e->id ])}}"><i class="bx bx-trash"></i></a>
      </td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
