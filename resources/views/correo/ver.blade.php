<div style="text-align:right;">
  <a href="{{ route('correos.responder', $correo->id) }}" class="btn btn-primary btn-sm">Responder Correo</a>
</div>
<div style="padding: 10px 20px;">
@php
$oportunidad = $correo->oportunidad();
@endphp
@if(!empty($oportunidad))
  <a href="/oportunidades/{{ $oportunidad->id }}"><h1>Cotización #{{ $oportunidad->codigo }}</h1></a>
@endif
<div>
<table class="table table-striped table-reduce table-sm">
<tr>
  <th>Desde</th>
  <td>{{ $correo->correo_desde }}</td>
  <td><b>{{ $correo->contacto()->nombres }} / {{ $correo->contacto()->celular }}</b></td>
</tr>
<tr>
  <th>Hasta</th>
  <td colspan="2">{{ $correo->correo_hasta }}</td>
</tr>
<tr>
  <th>Asunto</th>
  <td colspan="2">{{ $correo->asunto }}</td>
</tr>
<tr>
  <th>Fecha</th>
  <td colspan="2">{{ fecha($correo->fecha) }} {{ hora($correo->fecha) }} (<b>{{ tiempo_transcurrido($correo->fecha) }}</b>)</td>
</tr>
@if(!empty($correo->leido_el))
<tr>
  <th>Leido</th>
  <td colspan="2">{{ fecha($correo->leido_el) }} {{ hora($correo->leido_el) }} por {{ Auth::user()->byId($correo->leido_por) }}</td>
</tr>
@endif
</table>
</div>

@if(!empty($correo->adjuntos_cantidad) && !empty($correo->adjuntos))
<div style="background: #93c8ff;padding: 4px;margin-bottom: 10px;border-radius: 4px;color: #fff;font-size:11px;">
<ul style="margin-bottom:0;padding-bottom:0">
@foreach($correo->adjuntos as $a)
<li><a href="/correos/{{ $correo->id }}/descargar/{{ $a['id'] }}" download="{{ $a['name'] }}" style="color: #000;">{{ $a['name'] }}  [{{ $a['size'] }} bytes]</a></li>
@endforeach
</ul>
</div>
@endif


@if(!empty($correo->link))
<div style="text-align: center;background: #ededed;border-radius: 5px;">
Para poder ver el correo original, haga click <a href="javascript:window.open('{{ urlencode($correo->link) }}', 'correo', 'height = 800, width = 950, left = 500, top = 100, scrollbars = yes, resizable = yes, menubar = no, toolbar = yes, location = no, directories = no, status = yes')">Aquí</a>.
</div><br>
@endif

@if(!empty($correo->metadata))
          @foreach(json_decode($correo->metadata, true) as $k => $v)
          @if(!empty($v))
            <b>{{ $k }}: </b> {{ $v }}<br />
          @endif 
          @endforeach
          <br/>
@endif

{!! nl2br($correo->texto) !!}
</div>
