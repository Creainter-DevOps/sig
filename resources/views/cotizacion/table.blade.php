<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="4" class="table-head"><a  href="{{ route('cotizaciones.show', ['cotizacion' => $cotizacion->id ]) }}" target="_blank" >Cotización</a></th>
  </tr>
</thead>
<tbody>
  <tr>
      <th>Código</th>
      <td>{{ $cotizacion->codigo() }}</td>
      <th>Fecha</th>
      <td style="width:200px">{{ $cotizacion->fecha }}</td>
  </tr>
  <tr>
      <th>Oportunidad</th>
      <td>{{   isset($cotizacion->oportunidad_id) ? $cotizacion->oportunidad()->rotulo() : " "   }}</td>
      <th>Empresa</th>
      <td>{{ $cotizacion->empresa()->seudonimo }}</td>
  </tr>
  <tr>
    <th>Monto</th>
    <td>{{ $cotizacion->monto() }} </td>
    <th>Validez</th>
    <td> {{Helper::fecha( $cotizacion->validez )}} </td>
  </tr>
  <tr>
    <th>Directorio:</th>
    <td colspan="3"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $cotizacion->folder()) !!}';">{{ $cotizacion->folder() }}</a></td>
  </tr>
</tbody>
</table>
