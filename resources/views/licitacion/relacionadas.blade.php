@php
  $precio = $licitacion->rango_precios();
@endphp
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%;font-size:12px;">
              <thead>
                <th>Item</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Participé</th>
                <th>Resultado</th>
                <th>Referencial</th>
              </thead>
              <tbody>
            @foreach($licitacion->relacionadas() as $e)
            <tr>
              <td class="text-center"><a href="/licitaciones/{{ $e->id }}">{{ $e->nomenclatura }}</a></td>
              <td class="text-center">
              @if($e->estado)
              <span style="background: #a0ffac;">{{ Helper::fecha($e->fecha) }}</span>
              @else
              {{ Helper::fecha($e->fecha) }}
              @endif
              </td>

              <td title="{{ $e->rotulo }}">{{ substr($e->rotulo, 0, 75) }}</td> 
              <td class="text-center">{{ !empty($e->con_oportunidad) ? 'SI' : '' }}</td>
              <td class="text-center">{{ $e->hay_ganadora() }}</td>
              <td class="text-center" style="width:150px;" title="Valor referencial y el Monto Adjudicado">VR: {{ Helper::money($e->valor_referencial) }}<br/>AD: {{ Helper::money($e->valor_adjudicado) }}</td>
            </tr>
            @endforeach
            </tbody>
            </table>

<div>
  <b>Recomendaciones:</b><br />
  Para este tipo de licitaciones el valor referencial está desde <b>{{ Helper::money($precio->min) }} - {{ Helper::money($precio->max) }}</b>
</div>
