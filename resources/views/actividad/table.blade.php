<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head">Actividad</th>
  </tr>
  <tr>
    <th>Tipo</th>
    <td>{{ $actividad->tipo }}</td>
    <th>Programado</th>
    <td>{{ Helper::fecha($actividad->fecha) }} {{ $actividad->hora }} </td>
  </tr>
  <tr>
    <th>Asignado</th>
    <td>{{ $actividad->asignados() }}</td>
    <th>Linea</th>
    <td>{{ $actividad->callerid()->rotulo }} </td>
  </tr>
  <tr>
    <th>Contacto</th>
    <td>{{ $actividad->contacto()->nombres }}</td>
    <th>Realizado</th>
    <td>{{ Helper::fecha($actividad->fecha_comienzo, 'h:i:s A') }} </td>
  </tr>
  <tr>
    <th>Descripción</th>
    <td colspan="3">{{ $actividad->texto }}</td>
  </tr>
  <tr>
    <td colspan="4">
        <table class="table table-sm" style="width:100%;">
          <thead>
            <th>Hora</th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>Estado</th>
            <th>Duración</th>
            <th>Audio</th>
          </thead>
          <tbody>
          @foreach($actividad->voip_cdr() as $c)
            <tr>
              <td>{{ Helper::fecha($c['calldate'], 'h:i:s A') }}</td>
              <td>{{ $c['src'] }}</td>
              <td>{{ $c['dst'] }}</td>
              <td>{{ $c['disposition'] }}</td>
              <td>{{ $c['duration'] }}</td>
              @if(!empty($c['recordingfile']))
                <td><audio style="max-width:100px;" controls="" src="{{ $actividad->voip_dir() }}{{ $c['recordingfile'] }}"></audio></td>
              @endif
            </tr>
          @endforeach
          </tbody>
        </table>
    </td>
  </tr>
</table>
