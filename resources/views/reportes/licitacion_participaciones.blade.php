<style>
table {
  font-size: 11px;  
}
th, td {
  border: 1px solid #b3b3b3;
  overflow: hidden; text-overflow: ellipsis;
}
h1 {
  padding: 10px;
  font-size: 17px;
}
.tr_par {
}
.tr_impar {
}
</style>
<h1>Relación de Licitaciones Aprobadas: {{ date('d/m/Y H:i:s') }}</h1>
<table>
  <thead>
    <tr>
      <th style="width:105px;">Aprobado</th>
      <th style="width:170px;">Institución</th>
      <th style="width:280px;">Oportunidad</th>
      <th style="width:90px;">Empresa</th>
      <th style="width:40px;"></th>
      <th style="width:100px;">Participación</th>
      <th style="width:100px;">Propuesta</th>
      <th style="width:100px;">Buena Pro</th>
    </tr>
  </thead>
  @php
    $i = 0;
  @endphp
  @foreach($listado as $o)
    @php
      $i++;
    @endphp
    <tbody>
    @if($i % 2 === 0)
    <tr class="tr_par">
    @else
    <tr class="tr_impar">
    @endif
      <td rowspan="{{ count($o['children']) + 1 }}" style="text-align:center;">
        {{ $i }}<br />
        {{ $o['codigo'] }}<br/>
        {{ Helper::fecha($o['aprobado_el'], true) }}<br/>
        {{ $o['aprobado_por'] }}
        </td>
      <td rowspan="{{ count($o['children']) + 1 }}">{{ $o['institucion'] }}</td>
      <td rowspan="{{ count($o['children']) + 1 }}"><div style="width: 280px; word-wrap: break-word;">{{ strtoupper($o['rotulo']) }}</div></td>
      <th></th>
      <th>Monto</th>
      <th>{{ Helper::fecha($o['fecha_participacion_hasta'], true) }}</th>
      <th>{{ Helper::fecha($o['fecha_propuesta_hasta'], true) }}</th>
      <th>{{ Helper::fecha($o['fecha_buena_hasta'], true) }}</th>
    </tr>
    @if(!empty($o['children']))
      @foreach($o['children'] as $e)
      <tr>
        <td style="text-align:center;">{{ $e['empresa'] }}</td>
        <td style="text-align:center;">{{ $e['monto'] }}</td>
        <td style="text-align:center;">{{ Helper::fecha($e['participacion_el'], true) }}<br />{{ $e['participacion_por'] }}</td>
        <td style="text-align:center;">{{ Helper::fecha($e['propuesta_el'], true) }}<br />{{ $e['propuesta_por'] }}</td>
        @if(!empty($e['ganadores']))
          <td style="text-align:center;">{{ implode(',', array_map(function($n) { return $n['empresa']; }, json_decode($e['ganadores'], true))) }}</td>
        @else
          <td></td>
        @endif
      </tr>
      </tbody>
      @endforeach
    @else
      <tbody>
      <tr>
      </tr>
      </tbody>
    @endif
  @endforeach
</table>
