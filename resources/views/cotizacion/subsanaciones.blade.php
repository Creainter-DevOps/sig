<div style="padding:10px;">
<div style="text-align: right;padding-bottom:5px;">
<a data-button-dinamic href="/cotizaciones/{{ $cotizacion->id }}/registrarSubsanacion" class="btn btn-sm btn-success mr-25">Registrar Subsanación</a>
</div>
<table class="table table-sm mb-0 table-bordered table-vcenter text-center"  style="width:100%;font-size:12px;">
<thead>
  <tr>
    <th>Fecha</th>
    <th>Plazo</th>
    <th>Registrado</th>
    <th>Respondido</th>
    <th>Expediente</th>
  </tr>
</thead>
<tbody>
@foreach($cotizacion->subsanaciones() as $s)
<tr>
  <td style="width:80px;">{{ Helper::fecha($s->fecha) }}</td>
  <td style="width:70px;">{{ $s->dias_habiles }}</td>
  <td style="width:150px;">
    <div>{{ Helper::fecha($s->created_on, true) }}</div>
    <div>{{ Auth::user()->byId($s->created_by) }}</div>
  </td>
  <td>
    <div>{{ Helper::fecha($s->respondido_el, true) }}</div>
    <div>{{ Auth::user()->byId($s->respondido_por) }}</div>
  </td>
  @if(!empty($s->documento_id))
  <td><a href="{{ route('subsanacion.expediente', ['subsanacion' => $s->id ])}}">Ir a Mesa de Trabajo</a></td>
  @else
  <td><a href="{{ route('subsanacion.expediente', ['subsanacion' => $s->id ])}}">Aperturar Mesa de Trabajo</a></td>
  @endif
</tr>
@endforeach
</tbody>
</table>
</div>
