<div class="limit-scroll">
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="6" class="table-head"><a class="link-primary"  href="{{ route('licitaciones.show', [ 'licitacion' => $licitacion->id ]) }}" target="_blank">Licitación: {{ $licitacion->nomenclatura }}</a></th>
  </tr>
</thead>
              <tbody>
                <tr>
                  <td style="width:100px;">Entidad:</td>
                  <td colspan="5"><a href="/empresas/{{ $licitacion->empresa_id }}">{{ $licitacion->empresa()->rotulo() }}</a></td>
                </tr>
                <tr>
                  <td>Tipo:</td>
                  <td>{{ $licitacion->tipo_objeto }}</td>
                  <td>Expediente:</td>
                  <td>{{ $licitacion->expediente_id }}</td>
                  <td>Procedimiento:</td>
                  <td>{{ $licitacion->procedimiento_id }}</td>
                </tr>
                <tr>
                  <td>Licitación:</td>
                  <td colspan="5">{!! $licitacion->rotulo() !!}</td>
                </tr>
                <tr>
                  <td>Palabras Claves:</td>
                  <td colspan="5">{{ $licitacion->etiquetas() }}</td>
                </tr>
                <tr>
                  <td>Adjuntos:</td>
                  <td colspan="5">
                  <ul>
                  @php
                    if(file_exists(($d = config('constants.internal') . 'util/alfresco/token.txt'))) { 
                      $token = file_get_contents($d);
                    } else {
                      $token = '--';
                    }
                  @endphp
                  @foreach($licitacion->adjuntos() as $a)
                    <li>
                      <a target="_blank" href="{{ config('constants.app_url') . config('constants.static_seace') . $a->codigoAlfresco }}" title="Publicado el {{ $a->fechaPublicacion }}">
                        {{ $a->tipoDocumento }}
                      </a>
                      <a target="_blank" href="http://prodcont.seace.gob.pe/alfresco/d/a/workspace/SpacesStore/{{ $a->codigoAlfresco }}/{{ str_replace(' ', '_', $a->nombreArchivo) }}?ticket={{ $token }}">[Alt]</a>
                      <small>{{ $a->fechaPublicacion }}</small>
                    </li>
                  @endforeach
                  </ul>
                  </td>
                </tr>
                @if(!empty($licitacion->buenapro_fecha))
                <tr>
                  <th>Resultados:</th>
                  <td colspan="5">
                    {!! $licitacion->ganadora() !!} (<i>{{ Helper::fecha($licitacion->buenapro_fecha, true) }}</i>)
                    @if($licitacion->buenapro_fecha && empty($proyecto) && !empty($oportunidad))
                    <div style="padding:10px;background: #ff6c6c;color: #fff;text-align: center;">
                      <div>¿Perdimos, por qué?</div>
                      <div>
                       <select class="form-control select-data" data-editable="/oportunidades/{{ $licitacion->oportunidad()->id }}?_update=perdido_por" data-value="{{ $licitacion->oportunidad()->perdido_por }}">
                       <option value="">Seleccione</option>
@foreach(App\Oportunidad::selectPerdidos() as $k => $n)
          <option value="{{ $k }}" style="color:#fff;background-color: {{ $n['color'] }};">{{ $n['name'] }}</option>
@endforeach
         </select> 
                      </div>
                    </div>
                    @endif
                  </td>
                </tr>
                @endif
                <tr>
                  <td style="width:200px;">Fecha de Actualización:</td>
                  <td colspan="2">
                    {{ Helper::fecha($licitacion->updated_on, true) }}<br />
                    <a href="{{ route('licitacion.actualizar', ['licitacion' => $licitacion->id]) }}">[Actualizar]</a>
                  </td>
                  <td>Valor Referencial:</td>
                  <td colspan="2">{{ Helper::money($licitacion->monto) }}</td>
                </tr>

              </tbody>
            </table>
            <table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
              <thead>
                <th>Item</th>
                <th>Descripción</th>
                <th>Unidad</th>
                <th>Cantidad</th>
                <th>Referencial</th>
                <th>Adjudicado</th>
              </thead>
              <tbody>
            @foreach($licitacion->items() as $e)
            <tr>
              <td>{{ $e->item }}</td>
              <td>{{ substr($e->descripcion, 0, 30) }}</td> 
              <td>{{ $e->unidad_medida }}</td>
              <td>{{ $e->cantidad_solicitada }}</td>
              <td>{{ Helper::money($e->valor_referencial) }}</td>
              <td>{{ Helper::money($e->monto_adjudicado) }}</td>
            </tr>
            @endforeach
            </tbody>
            </table>
</div>
