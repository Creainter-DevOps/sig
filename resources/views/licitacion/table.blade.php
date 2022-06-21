<div class="limit-scroll">
<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('licitaciones.show', [ 'licitacion' => $licitacion->id ]) }}" target="_blank">Licitación</a></th>
  </tr>
</thead>
              <tbody>
                <tr>
                  <td style="width:200px;">Entidad:</td>
                  <td>
                      <a href="/clientes/{{ $licitacion->empresa_id }}">{{ $licitacion->entidad }}</a>
                      {{ $licitacion->empresa()->rotulo() }}
                    </td>
                </tr>
                <tr>
                  <td>Expediente:</td>
                  <td>{{ $licitacion->expediente_id }}</td>
                </tr>
                <tr>
                  <td>Procedimiento:</td>
                  <td>{{ $licitacion->procedimiento_id }}</td>
                </tr>
                <tr>
                  <td>Licitación:</td>
                  <td>{!! $licitacion->rotulo() !!}</td>
                </tr>
                <tr>
                  <td>Nomenclatura:</td>
                  <td>{{ $licitacion->nomenclatura }}</td>
                </tr>
                <tr>
                  <td>Valor Referencial:</td>
                  <td>{{ Helper::money($licitacion->monto) }}</td>
                </tr>
                <tr>
                  <td>Palabras Claves:</td>
                  <td>{{ $licitacion->etiquetas() }}</td>
                </tr>
                <tr>
                  <td>Adjuntos:</td>
                  <td>
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
                <tr>
                  <td style="width:200px;">Fecha de Actualización:</td>
                  <td>
                    {{ Helper::fecha($licitacion->updated_on, true) }}
                    <a href="{{ route('licitacion.actualizar', ['licitacion' => $licitacion->id]) }}">[Actualizar]</a>
                  </td>
                </tr>

              </tbody>
            </table>
</div>
