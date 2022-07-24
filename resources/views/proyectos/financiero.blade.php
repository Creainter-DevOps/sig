@extends('layouts.pdf')
@section('content')
@php
  $suma = [
    'contrato'   => 0,
    'penalidad'  => 0,
    'depositado' => 0,
    'detraccion' => 0,
    'igv'        => 0,
    'gasto'      => 0,
  ];
@endphp
  <h1 style="text-align:right;">PROYECTO: ESTADO FINANCIERO</h1>
  <table class="w-100 style01">
    <tbody>
    <tr>
      <th>Código</th>
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
    <tr>
      <th>Fecha Desde</th>
      <td>{{ Helper::fecha($proyecto->fecha_desde, true) }}</td>
    </tr>
    <tr>
      <th>Fecha Hasta</th>
      <td>{{ Helper::fecha($proyecto->fecha_hasta, true) }}</td>
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
    $suma['depositado'] += $e->monto_depositado;
    $suma['detraccion'] += $e->monto_detraccion;
    $suma['igv']        += ($e->monto_depositado + $e->monto_detraccion) * 0.18;
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
@if(count($proyecto->gastos()) == 0)
    <tr>
      <td colspan="6" style="text-align:center;"><i>No se ha registrado gastos</i></td>
    </tr>
@else
  @foreach($proyecto->gastos() as $e)
  @php
    $suma['gasto'] += $e->monto;
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
</table><br /><br />

<table class="w-100 style01">
  <thead>
    <tr>
      <th colspan="4">RESUMEN FINANCIERO</th>
    </tr>
    <tr>
      <th>CONTRATO</th>
      <th>PAGOS</th>
      <th>DEPOSITADO</th>
      <th>AVANCE</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center">{{ Helper::money($proyecto->cotizacion()->monto) }}</td>
      <td class="text-center">{{ Helper::money($suma['contrato']) }}</td>
      <td class="text-center">{{ Helper::money($suma['depositado']) }}</td>
      <td class="text-center">{{ ceil($suma['depositado'] / $suma['contrato']) }}%</td>
    </tr>
  </tbody>
  <thead>
    <tr>
      <th>PENALIDAD</th>
      <th>GASTO</th>
      <th>IGV</th>
      <th>EN DETRACCIÓN</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center">{{ Helper::money($suma['penalidad']) }}</td>
      <td class="text-center">{{ Helper::money($suma['gasto']) }}</td>
      <td class="text-center">{{ Helper::money($suma['igv']) }}</td>
      <td class="text-center">{{ Helper::money($suma['detraccion']) }}</td>
    </tr>
    <tr>
      <th colspan="4" class="text-center" style="padding:10px;">UTILIDAD: {{ Helper::money($suma['depositado'] - $suma['gasto'] - $suma['igv']) }}</th>
    </tr>
  </tbody>
</table>
@endsection

