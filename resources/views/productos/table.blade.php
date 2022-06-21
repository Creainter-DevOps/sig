<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head">Producto</th>
  </tr>
<tbody>
  <tr>
      <th>Nombre</th>
      <td>{{ $producto->nombre }}</td>
      <th>Tipo</th>
      <td>{{ App\Producto::fillTipo()[ $producto->tipo ] }}</td>
  </tr>
  <tr>
      <th>Precio</th>
      <td>{{ $producto->precio_unidad }}</td>
      <th>Unidad</th>
      <td>{{ $producto->unidad }}</td>
  </tr>
  <tr>
      <th>Modelo</th>
      <td>{{ $producto->modelo }}</td>
      <th>Marca</th>
      <td>{{ $producto->marca  }}</td>
  </tr>
  <tr>
      <th>Descripcion</th>
      <td colspan="3">{{ $producto->descripcion  }}</td>
  </tr>
</tbody>
</table>
