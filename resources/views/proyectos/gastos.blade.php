<div style="margin-top: -25px;text-align: right;">
  <button type="button" class="btn btn-sm m-0" data-popup="/gastos/crear?proyecto_id={{ $proyecto->id }}">
    <i class="bx bx-plus"></i>Nuevo Gasto
  </button>
</div>
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <thead>
    <tr>
      <th colspan="7" class="table-head">
        <a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Gastos del Proyecto</a>
      </th>
    </tr>
    <tr class="text-center">
      <th>Fecha</th>
      <th>Tipo</th>
      <th>Descripción</th>
      <th>Folder</th>
      <th>Monto</th>
      <th>Estado</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->gastos()) == 0)
    <tr>
      <td colspan="7" style="text-align:center;"><i>No se ha registrado gastos</i></td>
    </tr>
@else
  @foreach($proyecto->gastos() as $e)
    <tr>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td class="text-center">{{ $e->render_tipo() }}</td>
      <td>{{ $e->descripcion }}</td>
      <td class="text-center"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $e->folder()) !!}';">Folder</a></td>
      <td class="text-center">{{ $e->monto() }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
      <td style="width: 55px;text-align: center;">
         <a href="javascript:void(0)" data-popup="{{ route( 'gastos.edit', [ 'gasto' => $e->id ] ) }}"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('gastos.destroy', [ 'gasto' => $e->id ])}}"><i class="bx bx-trash"></i></a>
      </td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
