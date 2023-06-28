@php
$lista = App\Dashboard::actividades();
$primero = !empty($lista) ? array_shift($lista) : null;
@endphp

<div style="font-size: 10px;background: #69cd7f;color: #fff;line-height: 13px;text-align: center;">ACTIVIDADES PENDIENTES POR USUARIO</div>

@if(!empty($primero))
<table style="width:100%;">
  <thead>
    <th>Usuario</th>
    <th>Desde</th>
    <th>Cantidad</th>
  <thead>
  <tbody>
    <tr>
      <td>{{ $primero['usuario']}}</td>
      <td>{{ Helper::fecha($primero['desde']) }}</td>
      <td>{{ $primero['cantidad'] }}</td>
    </tr>
  </tbody>
  <tbody class="card_details">
    @foreach($lista as $l)
    <tr>
      <td>{{ $l['usuario']}}</td>
      <td>{{ Helper::fecha($l['desde']) }}</td>
      <td>{{ $l['cantidad'] }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endif
