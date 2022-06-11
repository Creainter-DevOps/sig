@extends('layouts.pdf')
@section('content')
  <h1 class="mayuscula texto-centrado">Licitaciones: Propuestas por Semana</h1>
  <table class="tabla w-100">
    <thead>
      <tr class="texto-centrado">
        <th>Nomenclatura</th>
        <th>Requerimiento</th>
        <th>Enviar</th>
        <th>Monto</th>
        <th>Interes</th>
        <th>Participaciones</th>
        <th>Propuestas</th>
      </tr>
    </thead>
    <tbody>
<?php foreach(App\Contable::licitaciones_semanal() as $p) { ?>
      <tr>
        <td style="width:180px;font-size:10px;"><?= $p->codigo; ?><br/><?= $p->nomenclatura ?></td>
        <td style="font-size:10px;"><b><?= $p->razon_social; ?>:</b> <?= $p->rotulo; ?></td>
        <td class="texto-centrado" style="width:80px;">
          <?= Helper::fecha($p->fecha_propuesta_hasta); ?><br />
          <span class="{{ $p->estado_propuesta()['class'] }}">{{ $p->estado_propuesta()['message'] }}</span>
        </td>
        <td class="texto-derecha" style="width:80px;"><?= Helper::money($p->monto_base, 1); ?></td>
<?php if(!empty($p->rechazado_el)) { ?>
        <td colspan="3" class="texto-centrado" style="font-size:10px;color:red;">Rechazado el <?= Helper::fecha($p->rechazado_el, true) ?> por @<?= strtoupper($p->rechazado_por) ?>: <?= $p->motivo ?></td>
<?php } elseif(!empty($p->archivado_el)) { ?>
        <td colspan="3" class="texto-centrado" style="font-size:10px;color:red;">Archivado el <?= Helper::fecha($p->archivado_el, true) ?> por @<?= strtoupper($p->archivado_por) ?>: <?= $p->motivo ?></td>
<?php } else { ?>
        <td class="texto-derecha" style="width:90px;font-size:10px;"><?= $p->empresas_interes; ?></td>
        <td class="texto-derecha" style="width:90px;font-size:10px;"><?= $p->empresas_participantes; ?></td>
        <td class="texto-derecha" style="width:90px;font-size:10px;"><?= $p->empresas_propuestas; ?></td>
<?php } ?>
      </tr>
<?php } ?>
    </tbody>
  </table>
@endsection
