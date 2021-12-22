<div style="margin-top: -25px;text-align: right;">
  <button type="button" class="btn btn-sm m-0" data-popup="/actas/crear?proyecto_id={{ $proyecto->id }}">
    <i class="bx bx-plus"></i>Nueva acta
  </button>
</div>
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <thead>
    <tr>
      <th colspan="7" class="table-head">
        <a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Actas del Proyecto</a>
      </th>
    </tr>
    <tr class="text-center">
      <th>Orden</th>
      <th>Nomenclatura</th>
      <th>Direccion</th>
      <th>Descripcion</th>
      <th>Folder</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @if(count($proyecto->actas()) == 0)
    <tr>
      <td colspan="7" style="text-align:center;"><i>No se han registrado actas</i></td>
    </tr>
  @else
  @foreach($proyecto->actas() as $c)
    <tr>
      <td class="text-center">{{ $c->orden }}</td>
      <td class="text-center">{{ $c->nomenclatura }}</td>
      <td>{{ $c->direccion }}</td>
      <td class="text-center">{{$c->texto }}</td>
      <td class="text-center"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $c->folder()) !!}';">Folder</a></td>
      <td style="width: 55px;text-align: center;">
         <a href="javascript:void(0)" data-popup="{{ route( 'actas.edit', [ 'acta' => $c->id ] ) }}"><i class="bx bx-edit-alt"></i></a>
         <a href="javascript:void(0)" data-confirm-remove="{{ route('actas.destroy', [ 'acta' => $c->id ])}}"><i class="bx bx-trash"></i></a>
      </td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
