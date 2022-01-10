<div style="margin-top: -25px;text-align: right;">
  <button type="button" class="btn btn-sm m-0" data-popup="/cartas/crear?proyecto_id={{ $proyecto->id }}">
    <i class="bx bx-plus"></i>Nueva carta
  </button>
</div>
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <thead>
    <tr>
      <th colspan="7" class="table-head">
        <a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Cartas del Proyecto</a>
      </th>
    </tr>
    <tr class="text-center">
      <th>Orden</th>
      <th>Fecha</th>
      <th>Nomenclatura</th>
      <th>Asunto</th>
      <th>Folder</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @if(count($proyecto->cartas()) == 0)
    <tr>
      <td colspan="7" style="text-align:center;"><i>No se han registrado cartas</i></td>
    </tr>
  @else
  @foreach($proyecto->cartas() as $c)
    <tr>
      <td class="text-center">{{ $c->numero }}</td>
      <td class="text-center">{{ Helper::fecha($c->fecha) }}</td>
      <td class="text-center">{{ $c->nomenclatura }}</td>
      <td>{{ $c->rotulo }}</td>
      <td class="text-center"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $c->folder()) !!}';">Folder</a></td>
      <td style="width: 55px;text-align: center;">
         <a href="javascript:void(0)" data-popup="{{ route( 'cartas.edit', [ 'carta' => $c->id ] ) }}"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('cartas.destroy', [ 'carta' => $c->id ])}}"><i class="bx bx-trash"></i></a>
      </td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
