<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head">Empresa</th>
  </tr>
<tbody>
  @if ($empresa != null)
  <tr>
      <th>Ruc</th>
      <td>{{ $empresa->ruc }}</td>
      <th>Cliente</th>
      <td>{{ $empresa->razon_social }}</td>
  </tr>
  <tr>
      <th>Seudonimo</th>
      <td>{{ $empresa->seudonimo }}</td>
      <th>Dirección</th>
      <td>{{ $empresa->direccion }}</td>
  </tr>
  @else

  <tr>
      <td colspan="4">Sin informacion de empresa </td>
  </tr>
  @endif
</tbody>
</table>
