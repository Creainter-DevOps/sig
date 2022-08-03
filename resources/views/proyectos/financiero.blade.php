@extends('layouts.pdf')
@section('content')
@php
  $suma = [
    'contrato'   => 0,
    'penalidad'  => 0,
    'depositado' => 0,
    'pendiente'  => 0,
    'detraccion' => 0,
    'igv'        => 0,
    'gasto'      => 0,
    'gasto_efectuado' => 0,
    'gasto_pendiente' => 0,
  ];
@endphp
  <h1 style="text-align:right;">PROYECTO: ESTADO FINANCIERO</h1>
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
    <tr>
      <th>Monto Contractual</th>
      <td>{{ Helper::money($proyecto->cotizacion()->monto) }}</td>
    </tr>
    </tbody>
  </table><br />
<table class="w-100 style01">
  <thead>
    <tr>
      <th colspan="8">RELACIÓN DE PAGOS PROGRAMADOS</th>
    </tr>
    <tr class="text-center">
      <th style="width:50px">NÚMERO</th>
      <th style="width:80px">FECHA</th>
      <th>DESCRIPCIÓN</th>
      <th style="width:80px">ESTADO</th>
      <th style="width:80px">CONTRATO</th>
      <th style="width:80px">PENALIDAD</th>
      <th style="width:80px">DEPOSITO</th>
      <th style="width:80px">DETRACCIÓN</th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->pagos()) == 0)
    <tr>
      <td colspan="8" style="text-align:center;"><i>No se ha registrado pagos</i></td>
    </tr>
@else
  @foreach($proyecto->pagos() as $e)
  @php
    $suma['contrato']   += $e->monto;
    $suma['penalidad']  += $e->monto_penalidad;
    $suma['depositado'] += $e->estado_id == 3 ? $e->monto_depositado : 0;
    $suma['detraccion'] += $e->estado_id == 3 ? $e->monto_detraccion : 0;
    $suma['pendiente']  += $e->estado_id != 3 ? $e->monto : 0;
    $suma['igv']        += $e->estado_id == 3 ? (($e->monto_depositado + $e->monto_detraccion) * 0.18) : 0;
  @endphp
    <tr>
      <td class="text-center">{{ $e->numero }}</td>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td>{{ $e->descripcion }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
      <td class="text-right">{{ $e->monto('monto') }}</td>
      <td class="text-right">{{ $e->monto('monto_penalidad') }}</td>
      <td class="text-right">{{ $e->monto('monto_depositado') }}</td>
      <td class="text-right">{{ $e->monto('monto_detraccion') }}</td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
<br /><br />
<table class="w-100 style01">
  <thead>
    <tr>
      <th colspan="6">GASTOS REGISTRADOS</th>
    </tr>
    <tr>
      <th style="width:50px">NÚMERO</th>
      <th style="width:80px">FECHA</th>
      <th style="width:150px">Tipo</th>
      <th>Descripción</th>
      <th style="width:150px">Monto</th>
      <th style="width:100px">Estado</th>
    </tr>
  </thead>
  <tbody>
@if(count($proyecto->ordenes()) == 0)
    <tr>
      <td colspan="6" style="text-align:center;"><i>No se ha registrado Ordenes</i></td>
    </tr>
@else
  @foreach($proyecto->ordenes() as $e)
  @php
    $suma['gasto'] += $e->monto;
    $suma['gasto_efectuado'] += $e->estado_id == 3 ? $e->monto : 0;
    $suma['gasto_pendiente'] += $e->estado_id != 3 ? $e->monto : 0;
  @endphp
    <tr>
      <td class="text-center">{{ $e->numero }}</td>
      <td class="text-center">{{ Helper::fecha($e->fecha) }}</td>
      <td class="text-center">{{ $e->render_tipo() }}</td>
      <td>{{ $e->descripcion }}</td>
      <td class="text-center">{{ $e->monto() }}</td>
      <td class="text-center">{{ $e->estado() }}</td>
    </tr>
  @endforeach
@endif
  </tbody>
</table>
<div class="page-break"></div>
<table class="w-100 style01">
  <thead>
    <tr>
      <th colspan="5">RESUMEN FINANCIERO</th>
      <th class="text-center">{{ Helper::money($proyecto->cotizacion()->monto) }}</th>
    </tr>
    <tr>
      <th rowspan="2">INGRESOS</th>
      <th>PAGOS REGISTRADOS</th>
      <th>EN CUENTA</th>
      <th>EN DETRACCIÓN</th>
      <th>PENDIENTE</th>
      <th>AVANCE</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center">{{ Helper::money($suma['contrato']) }}</td>
      <td class="text-center">{{ Helper::money($suma['depositado']) }}</td>
      <td class="text-center">{{ Helper::money($suma['detraccion']) }}</td>
      <td class="text-center">{{ Helper::money($suma['pendiente']) }}</td>
      <td class="text-center">{{ ceil($suma['depositado'] / $suma['contrato']) }}%</td>
    </tr>
  </tbody>
  <thead>
    <tr>
      <th rowspan="2">SALIDAS</th>
      <th>GASTOS REGISTRADOS</th>
      <th>EFECTUADO</th>
      <th>PENDIENTE</th>
      <th>PENALIDAD</th>
      <th>IGV</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center">{{ Helper::money($suma['gasto']) }}</td>
      <td class="text-center">{{ Helper::money($suma['gasto_efectuado']) }}</td>
      <td class="text-center">{{ Helper::money($suma['gasto_pendiente']) }}</td>
      <td class="text-center">{{ Helper::money($suma['penalidad']) }}</td>
      <td class="text-center">{{ Helper::money($suma['igv']) }}</td>
    </tr>
    <tr>
      <th colspan="7" class="text-center" style="padding:10px;">
      UTILIDAD: {{ Helper::money($suma['depositado'] + $suma['detraccion'] - $suma['gasto_efectuado'] - $suma['igv']) }}
      de {{ Helper::money($suma['contrato'] - $suma['gasto'] - ($suma['contrato'] * 0.18)) }}</th>
    </tr>
  </tbody>
</table>
@endsection

