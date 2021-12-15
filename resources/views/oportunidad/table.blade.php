<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('oportunidades.show', [ 'oportunidad' => $oportunidad->id ]) }}" target="_blank">Oportunidad</a></th>
  </tr>
    <tr>
      <th>Código</th>
      <td>{{ $oportunidad->codigo }}</td>
      <th>Rotulo</th>
      <td>{{ $oportunidad->que_es }} </td>
    </tr>
    <tr>
      <th>Carpeta</th>
      <td colspan="3"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $oportunidad->folder()) !!}';">{{ $oportunidad->folder() }}</a></td>
    </tr>
    <tr>
      <th>Aprobado</th>
      <td>{{ Helper::fecha($oportunidad->aprobado_el, true) }} {{ $oportunidad->aprobado_por }}</td>
      <th>Rechazado</th>
      <td>{{ Helper::fecha($oportunidad->rechazado_el, true) }} {{ $oportunidad->rechazado_por }}</td>
    </tr>
    <tr>
      <th>Revisado</th>
      <td>{{ Helper::fecha($oportunidad->revisado_el, true) }} {{ $oportunidad->revisado_por }}</td>
      <th>Archivado</th>
      <td>{{ Helper::fecha($oportunidad->archivado_el, true) }} {{ $oportunidad->archivado_por }}</td>
    </tr>
    <tr>
      <th>Participación</th>
      <td>{{ Helper::fecha($oportunidad->fecha_participacion, true) }}</td>
      <th>Propuesta</th>
      <td>{{ Helper::fecha($oportunidad->fecha_propuesta, true) }} </td>
    </tr>
</table>
