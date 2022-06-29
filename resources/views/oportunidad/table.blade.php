<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <thead>
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('oportunidades.show', [ 'oportunidad' => $oportunidad->id ]) }}" target="_blank">Oportunidad: {{ $oportunidad->codigo }}</a></th>
  </tr>
</thead>
<tbody>
    <tr>
      <th>Rotulo</th>
      <td colspan="3">{{ $oportunidad->rotulo }} </td>
    </tr>
    <tr>
      <th>Carpeta</th>
      <td colspan="3"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $oportunidad->folder()) !!}';">{{ $oportunidad->folder() }}</a></td>
    </tr>
    <tr>
      <th>Palabras Claves:</th>
      <td colspan="3">{{ $oportunidad->etiquetas() }}</td>
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
    <tr>
      <th>Estado</th>
      <td colspan="3">
         <select class="form-control select-data" data-editable="/oportunidades/{{ $oportunidad->id }}?_update=estado" data-value="{{ $oportunidad->estado }}">
@foreach(App\Oportunidad::selectEstados() as $k => $n)
          <option value="{{ $k }}" style="color:#fff;background-color: {{ $n['color'] }};">{{ $n['name'] }}</option>
@endforeach
         </select>
      </td>
    </tr>
                    <tr>
                  <th>Monto Base:</th>
                  <td style="display:flex;" >
                    <div data-editable="/oportunidades/{{  $oportunidad->id }}?_update=monto_base" data-name="monto_base"  >{{ Helper::money($oportunidad->monto_base) }}</div>
                  </td>
                  <th>Instalación:</th>
                  <td class="d-flex align-items-end" >
                    <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=instalacion_dias" data-name="instalacion_dias">{{ $oportunidad->instalacion_dias ?? 0 }}</div><label>días</label>
                  </td>
                </tr>
                <tr>
                  <th>Servicio:</th>
                  <td class="d-flex align-items-end ">
                    <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=duracion_dias" data-name="duracion_dias">{{ $oportunidad->duracion_dias ?? 0 }}</div> <label>días</label>
                  </td>
                  <th>Garantía:</th>
                  <td class="d-flex align-items-end">
                    <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=garantia_dias" data-name="garantia_dias">{{ $oportunidad->garantia_dias ?? 0 }}</div> <label>días</label>
                  </td>
                </tr>
</tbody>
</table>
