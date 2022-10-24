@extends('layouts.pdf')
@section('content')
  <h1 class="mayuscula texto-centrado">Estado Situacional de Proyectos</h1>
  <table class="table w-100 style01">
    <thead>
      <tr>
        <th rowspan="2">Código</th>
        <th colspan="4">Fecha</th>
        <th rowspan="2">Contrato</th>
        <th colspan="3">Ingresos</th>
        <th colspan="3">Salidas</th>
        <th colspan="2">Utilidad</th>
      </tr>
      <tr class="texto-centrado">
        <th>BuenaPro</th>
        <th>Firma</th>
        <th>Desde</th>
        <th>Hasta</th>
        <th>Regist.</th>
        <th>Efect.</th>
        <th>Pend.</th>
        <th>Regist.</th>
        <th>Efect.</th>
        <th>Pend.</th>
        <th>Contrato</th>
        <th>Actual</th>
      </tr>
    </thead>
    <tbody>
<?php foreach(App\Contable::proyectos_activos() as $p) { ?>
      <tr>
        <td class="texto-centrado" style="width:70px;font-size:10px;">{{ $p->codigo }}<br />{{ $p->alias }}</td>
        <td class="texto-centrado" style="width:60px;font-size:10px;">{!! Helper::color($p->buenapro_fecha, 'date', '#000000', '#000000','#000000') !!}</td>
        <td class="texto-centrado" style="width:60px;font-size:10px;">{{ Helper::fecha($p->fecha_firma) }}</td>
        <td class="texto-centrado" style="width:60px;font-size:10px;">{!! Helper::color($p->fecha_desde, 'date', '#019f01', '#00ff00','#000000') !!}</td>
        <td class="texto-centrado" style="width:60px;font-size:10px;">{!! Helper::color($p->fecha_hasta, 'date', '#ff0000', '#00ff00','#019f01') !!}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->monto, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->monto_registrado, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->monto_efectuado, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->monto_pendiente, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->gasto_registrado, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->gasto_efectuado, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{{ Helper::money($p->gasto_pendiente, 1) }}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{!! Helper::color($p->utilidad_contrato, 'numeric', '#ff0000', '#000000','#019f01', Helper::money($p->utilidad_contrato, 1)) !!}</td>
        <td class="texto-derecha" style="width:65px;font-size:10px;">{!! Helper::color($p->utilidad_actual, 'numeric', '#ff0000', '#000000','#019f01', Helper::money($p->utilidad_actual, 1)) !!}</td>
      </tr>
<?php } ?>
    </tbody>
  </table>
@endsection
