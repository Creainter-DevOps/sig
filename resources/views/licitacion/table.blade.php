<div class="limit-scroll">
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="6" class="table-head"><a class="link-primary"  href="{{ route('licitaciones.show', [ 'licitacion' => $licitacion->id ]) }}" target="_blank">Licitación: {{ $licitacion->nomenclatura }}</a></th>
  </tr>
</thead>
              <tbody>
                <tr>
                  <td style="width:200px;">Entidad:</td>
                  <td colspan="5">
                      <a href="/clientes/{{ $licitacion->empresa_id }}">{{ $licitacion->entidad }}</a>
                      {{ $licitacion->empresa()->rotulo() }}
                    </td>
                </tr>
                <tr>
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
                  @foreach($licitacion->adjuntos() as $a)
                    <li>
                      <a target="_blank" href="http://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode={{ $a->codigoAlfresco }}">
                        {{ $a->tipoDocumento }}
                      </a>
                    </li>
                  @endforeach
                  </ul>
                  </td>
                </tr>
                @if(!empty($licitacion->buenapro_fecha))
                <tr>
                  <th>Resultados:</th>
                  <td colspan="5">{!! $licitacion->ganadora() !!}</td>
                </tr>
                @endif
                <tr>
                  <td style="width:200px;">Fecha de Actualización:</td>
                  <td>
                    {{ Helper::fecha($licitacion->updated_on, true) }}<br />
                    <a href="{{ route('licitacion.actualizar', ['licitacion' => $licitacion->id]) }}">[Actualizar]</a>
                  </td>
                  <td>Valor Referencial:</td>
                  <td>{{ Helper::money($licitacion->monto) }}</td>
                </tr>

              </tbody>
            </table>
</div>
