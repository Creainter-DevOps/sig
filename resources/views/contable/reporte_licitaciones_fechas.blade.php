@extends('layouts.pdf')
@section('content')
  <h1 class="mayuscula texto-centrado">Fecha Máxima de Consentimientos</h1>
  <table class="table w-100 style01">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nomenclatura</th>
        <th>Fecha Buena Pro</th>
        <th>Consentimiento</th>
        <th>Perfeccionamiento</th>
      </tr>
    </thead>
    <tbody>
<?php foreach(App\Contable::licitaciones_fechas() as $p) { ?>
      <tr>
        <td class="texto-centrado">{{ $p->codigo }}</td>
        <td class="texto-centrado">{{ $p->nomenclatura }}</td>
        <td class="texto-centrado">{{ Helper::fecha($p->buenapro) }}</td>
        <td class="texto-centrado">{{ Helper::fecha($p->consentimiento) }}</td>
        <td class="texto-centrado">{{ Helper::fecha($p->perfeccionamiento) }}</td>
      </tr>
<?php } ?>
    </tbody>
  </table>
@endsection
