@php
$lista = App\Dashboard::competencias();
$primero = !empty($lista) ? array_shift($lista) : null;
@endphp

@if(!empty($primero))
<div>
  <div style="font-size: 10px;background: #be68ff;color: #fff;line-height: 13px;text-align: center;">SEGUIMIENTO A EMPRESAS</div>
  <div style="font-size:10px;">{{ Helper::fecha($primero['fecha'], true) }}</div>
  <div><b>{{ $primero['empresa'] }}</b></div>
  <a href="/licitaciones/{{ $primero['licitacion_id'] }}">{{ $primero['licitacion'] }}</a><br />
</div>
@if(!empty($lista))
<div class="card_details">
@foreach($lista as $l)
  <div style="padding-bottom: 3px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
    <div style="font-size:10px;">{{ Helper::fecha($l['fecha'], true) }}</div>
    <div><b>{{ $l['empresa'] }}</b></div>
    <a href="/licitaciones/{{ $l['licitacion_id'] }}" style="white-space: normal;margin: 0;">{{ $l['licitacion'] }}</a><br />
  </div>
@endforeach
</div>
@endif
@endif
