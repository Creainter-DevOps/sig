<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('contactos.show', [ 'contacto' => $contacto->id ]) }}" target="_blank">CONTACTO</a></th>
  </tr>
    <tr>
      <th>ID</th>
      <td>{{ $contacto->id }}</td>
      <th>DNI</th>
      <td>{{ $contacto->dni ?? ''  }} </td>
    </tr>
    <tr>
      <th>Nombres</th>
      <td>{{ $contacto->nombres ?? '' }} </td>
      <th>Apellidos</th>
      <td>{{ $contacto->apellidos ?? '' }} </td>
    </tr>
    <tr>
      <th>Celular</th>
      <td>{{ $contacto->celular ?? '' }}</td>
      <th>Correo</th>
      <td>{{ $contacto->correo ?? '' }} </td>
    </tr>
</table>
