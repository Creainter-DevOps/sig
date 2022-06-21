<div class="limit-scroll">
<table class="table table-sm mb-0 table-bordered table-vcenter" style="width:100%">
  <thead>
    <tr>
      <th colspan="7" class="table-head">Contactos</th>
    </tr>
    <tr class="text-center">
      <th>Nombre</th>
      <th>Área</th>
      <th>Correo</th>
      <th>Número</th>
    </tr>
  </thead>
  <tbody>
  @foreach($cliente->contactos() as $c)
    <tr>
      <td>{{ $c->nombres }}</td>
      <td>{{ $c->area }}</td>
      <td>{{ $c->correo }}</td>
      <td>{{ $c->celular }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
