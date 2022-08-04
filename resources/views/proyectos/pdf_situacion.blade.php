@extends('layouts.pdf')
@section('content')
  <h1 style="text-align:right;">PROYECTO: ESTADO DE ENTREGABLES</h1>
  <table class="w-100 style01">
    <tbody>
    <tr>
      <th style="width:200px;">Código</th>
      <td>{{ $proyecto->codigo }}</td>
    </tr>
    <tr>
      <th>Rótulo</th>
      <td>{{ $proyecto->rotulo }}</td>
    </tr>
    <tr>
      <th>Cotización</th>
      <td>{{ $proyecto->cotizacion()->codigo() }}</td>
    </tr>
    @if($proyecto->oportunidad()->licitacion_id)
    <tr>
      <th>Fecha de Buena Pro</th>
      <td>{{ Helper::fecha($proyecto->oportunidad()->licitacion()->buenapro_fecha, true) }}</td>
    </th>
    @endif
    <tr>
      <th>Firma de Contrato</th>
      <td>{{ Helper::fecha($proyecto->fecha_firma) }}</td>
    </th>
    <tr>
      <th>Firma de Inicio</th>
      <td>{{ Helper::fecha($proyecto->fecha_inicio) }}</td>
    </th>
    <tr>
      <th>Plazo de Servicio</th>
      <td>{{ $proyecto->cotizacion()->plazo_servicio }}</td>
    </tr>
    </tbody>
  </table>
  <br />
  <table class="w-100 style01">
  <thead>
    <tr>
      <th colspan="4">ENTREGABLES REGISTRADOS</th>
    </tr>
    <tr>
      <th style="width:50px">NÚMERO</th>
      <th style="width:80px">FECHA</th>
      <th style="width:100px">ESTADO</th>
      <th style="">DESCRIPCIÓN</th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->entregables()) == 0)
    <tr>
      <td colspan="4" style="text-align:center;"><i>No se ha registrado Entregables</i></td>
    </tr>
@else
  @foreach($proyecto->entregables() as $e)
    <tr>
      <td class="text-center">{{ $e->numero }}</td>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
      <td>{{ $e->descripcion }}</td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
<br />
<table class="w-100 style01">
  <thead>
    <tr>
      <th colspan="6">GASTOS REGISTRADOS</th>
    </tr>
    <tr>
      <th style="width:50px">NÚMERO</th>
      <th style="width:80px">FECHA</th>
      <th style="width:150px">TIPO</th>
      <th style="width:100px">ESTADO</th>
      <th>DESCRIPCIÓN</th>
      <th style="width:150px">MONTO</th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->ordenes()) == 0)
    <tr>
      <td colspan="6" style="text-align:center;"><i>No se ha registrado Ordenes</i></td>
    </tr>
@else
  @foreach($proyecto->ordenes() as $e)
    <tr>
      <td class="text-center">{{ $e->numero }}</td>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td class="text-center">{{ $e->render_tipo() }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
      <td>{{ $e->descripcion }}</td>
      <td class="text-center">{{ $e->monto() }}</td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
@endsection

