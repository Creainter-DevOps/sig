<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="5" class="table-head"><a  href="{{ route('cotizaciones.show', ['cotizacion' => $cotizacion->id ]) }}" target="_blank" >Cotización</a></th>
  </tr>
</thead>
<tbody>
  <tr>
      <th>Código</th>
      <td>{{ $cotizacion->codigo() }}</td>
      <th>Empresa</th>
      <td colspan="2" style="width:200px">{{ $cotizacion->empresa()->seudonimo }}</td>
  </tr>
  <tr>
    <th>Rótulo</th>
    <td colspan="4"><div data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=rotulo">{{ $cotizacion->rotulo }}</div></td>
  </tr>
  <tr>
    <th>Emitida</th>
    <td><input type="date" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=fecha" value="{{ $cotizacion->fecha }}"></td>
    <th>Validez</th>
    <td colspan="2"><input type="date" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=validez" value="{{ $cotizacion->validez }}"></td>
  </tr>
  <tr>
    <th>Instalación</th>
    <td><input type="text" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=plazo_instalacion" value="{{ $cotizacion->plazo_instalacion }}"></td>
    <th>Servicio</th>
    <td colspan="2"><input type="text" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=plazo_servicio" value="{{ $cotizacion->plazo_servicio }}"></td>
  </tr>
  <tr>
    <th>Garantía</th>
    <td><input type="text" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=plazo_garantia" value="{{ $cotizacion->plazo_garantia }}"></td>
    <th>Monto</th>
    <td><input type="number" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=monto" value="{{ $cotizacion->monto }}" min="0" max="999999999" step="0.01"></td>
    <td>
      <select name="moneda_id" data-value="{{ $cotizacion->moneda_id }}" data-editable="/cotizaciones/{{ $cotizacion->id }}?_update=moneda_id">
        @foreach (App\Pago::selectMonedas() as $k => $v)
        <option value="{{ $k }}">{{ $v }}</option>
        @endforeach
      </select>
    </td>
  </tr>
@if(empty($cotizacion->oportunidad()->licitacion_id))
  <tr>
    <th>Directorio:</th>
    <td colspan="4"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $cotizacion->folder()) !!}';">{{ $cotizacion->folder() }}</a></td>
  </tr>
@endif
</tbody>
</table>
