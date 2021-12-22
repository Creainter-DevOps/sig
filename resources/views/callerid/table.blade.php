<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('proyectos.show', [ 'proyecto' => $proyecto->id ]) }}" target="_blank">Proyecto</a></th>
  </tr>
</thead>
              <tbody>
                <tr>
                  <th>Encargado</th>
                  <td>{{ $proyecto->empresa()->razon_social }}</td>
                <tr>
                  <th>Cliente:</th>
                  <td>{{ $proyecto->cliente()->rotulo() }}</td>
                </tr>
                <tr>
                  <th>Contacto:</th>
                  <td>{{ !empty($proyecto->contacto_id) ? $proyecto->Contacto()->NombresApellidos() : ''  }}</td>
                </tr>
                <tr>
                  <th>Licitación:</th>
                  <td>{!! !empty($proyecto->oportundiad_id)?  $proyecto->oportunidad()->rotulo() : ''  !!}</td>
                </tr>
                <tr>
                  <th>Directorio:</th>
                  <td><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $proyecto->folder()) !!}';">{{ $proyecto->folder() }}</a></td>
                </tr>
              </tbody>
</table>
