@extends('layouts.pdf')
@section('content')
  <h1 class="mayuscula texto-centrado">Reporte de Facturas por Cobrar</h1>
  <table class="tabla w-100">
    <thead>
      <tr class="texto-centrado">
        <th>Proyeto</th>
        <th>Descripción</th>
        <th>Número</th>
        <th>Fecha</th>
        <th>Monto</th>
        <th>Penalidad</th>
        <th>Detracción</th>
      </tr>
    </thead>
    <tbody>
<?php $totales = []; foreach(App\Contable::facturas_por_cobrar() as $p) {
  if(!isset($totales[$p->moneda_id])) {
    $totales[$p->moneda_id] = array('monto' => 0, 'penalidad' => 0, 'detraccion' => 0);
  }
  $totales[$p->moneda_id]['monto'] += $p->monto;
  $totales[$p->moneda_id]['penalidad'] += $p->monto_penalidad;
  $totales[$p->moneda_id]['detraccion'] += $p->monto_detraccion;
?>
      <tr>
        <td><?= $p->rotulo; ?></td>
        <td style="width:100px;"><?= $p->descripcion; ?></td>
        <td class="texto-centrado" style="width:70px;"><?= $p->numero; ?></td>
        <td class="texto-centrado" style="width:90px;"><?= Helper::fecha($p->fecha); ?></td>
        <td class="texto-derecha" style="width:90px;"><?= Helper::money($p->monto, $p->moneda_id); ?></td>
        <td class="texto-derecha" style="width:90px;"><?= Helper::money($p->monto_penalidad, $p->moneda_id); ?></td>
        <td class="texto-derecha" style="width:90px;"><?= Helper::money($p->monto_detraccion, $p->moneda_id); ?></td>
      </tr>
<?php } ?>
    </tbody>
  </table>
<br /><br />
<table>
  <tr>
    <td style="width:750px;">.</td>
    <td>
<?php foreach($totales as $moneda_id => $t) { ?>
      <table>
        <tr>
          <th class="texto-izquierda" style="width:120px;">Monto Total</th>
          <td class="texto-derecha"><?= Helper::money($t['monto'], $moneda_id) ?></td>
        </tr>
        <tr>
          <th class="texto-izquierda">Penalidad Total</th>
          <td class="texto-derecha"><?= Helper::money($t['penalidad'], $moneda_id) ?></td>
        </tr>
        <tr>
          <th class="texto-izquierda">Detracción Total</th>
          <td class="texto-derecha"><?= Helper::money($t['detraccion'], $moneda_id) ?></td>
        </tr>
      </table>
<?php } ?>
    </td>
  </tr>
</table>
@endsection
