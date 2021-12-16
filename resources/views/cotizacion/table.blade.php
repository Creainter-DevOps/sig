<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="4" class="table-head"><a  href="{{ route('cotizaciones.show', ['cotizacion' => $cotizacion->id ]) }}" target="_blank" >Cotización</a></th>
  </tr>
</thead>
<tbody>
  <tr>
      <th>Código</th>
      <td>{{ $cotizacion->codigo }}</td>
      <th>Cliente</th>
      <td>{{ $cotizacion->cliente()->empresa()->razon_social }}</td>
  </tr>
  <tr>
      <th>Oportunidad</th>
      <td>{{   isset($cotizacion->oportunidad_id) ? $cotizacion->oportunidad()->rotulo() : " "   }}</td>
      <th>Contacto</th>
      <td>{{ $cotizacion->contacto_id ?? 0 }}</td>
  </tr>
  <tr>
      <th>Fecha</th>
      <td>{{ Helper::fecha( $cotizacion->fecha ) }} </td>
      <th>Validez</th>
      <td> {{Helper::fecha( $cotizacion->validez )}} </td>
   </tr>
   <tr>
      <th>Descripción</th>
      <td>{{ $cotizacion->descripcion }} </td>
      <th>M.Total</th>
   <td>{{ $cotizacion->monto_total }} </td>
  </tr>
  <tr>
    <th>Directorio:</th>
    <td colspan="3"><a href="#" onclick="window.location.href='odir:{!! addslashes(Auth::user()->dir_sharepoint . $cotizacion->folder()) !!}';">{{ $cotizacion->folder() }}</a></td>
  </tr>
  <tr>
    <th>Observaciones</th>
    <td colspan="3"><textarea class="form-control"  disabled >{{ $cotizacion->observacion  }}</textarea></td>  
  </tr>
</tbody>
</table>