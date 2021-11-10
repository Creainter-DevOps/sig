@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Users View')
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
<style>
.tachado {
  text-decoration: line-through;
}
</style>
@endsection
@section('content')
<!-- users view start -->
<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
    <div class="col-12 col-sm-7">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="users view avatar" class="users-avatar-shadow rounded-circle" height="64" width="64" />
        </a>
        <div class="media-body pt-25">
          <h4 class="media-heading">{{ $licitacion->nomenclatura }}</h4>
          <span>{{ $licitacion->entidad }}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
@if(empty($oportunidad))
<div>Seguir</div>
@else
@if(!empty($oportunidad->rechazado_el))
  Rechazado el {{ Helper::fecha($oportunidad->rechazado_el, true) }}
@elseif(!empty($oportunidad->archivado_el))
  Archivado el {{ Helper::fecha($oportunidad->archivado_el, true) }}
@elseif(empty($oportunidad->revisado_el))
  <a href="/oportunidad/{{ $licitacion->id }}/revisar" class="btn btn-sm btn-success mr-25">Revisar</a>
  <a href="/oportunidad/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@elseif($oportunidad->estado == 'PENDIENTE')
  <a href="/oportunidad/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@else
  <a href="/oportunidad/{{ $licitacion->id }}/archivar" class="btn btn-sm btn-danger">Archivar</a>
@endif
@endif
    </div>
  </div>
  <!-- users view media object ends -->
  <!-- users view card data start -->
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-7">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width:200px;">Entidad:</td>
                  <td><a href="/clientes/{{ $licitacion->empresa_id }}">{{ $licitacion->entidad }}</a></td>
                </tr>
                <tr>
                  <td>Procedimiento:</td>
                  <td>{{ $licitacion->procedimiento_id }}</td>
                </tr>
                <tr>
                  <td>Nomenclatura:</td>
                  <td>{{ $licitacion->nomenclatura }}</td>
                </tr>
                <tr>
                  <td>Rotulo:</td>
                  <td>{{ $licitacion->rotulo }}</td>
                </tr>
                <tr>
                  <td>Descripción:</td>
                  <td>{{ $licitacion->descripcion }}</td>
                </tr>
                <tr>
                  <td>Participación:</td>
                  <td>{{ $licitacion->participacion() }}</td>
                </tr>
                <tr>
                  <td>Propuesta:</td>
                  <td>{{ $licitacion->propuesta() }}</td>
                </tr>
                <tr>
                  <td>Estado:</td>
                  <td><span class="{{ $licitacion->estado()['class'] }}">{{ $licitacion->estado()['message'] }}</span></td>
                </tr>
                <tr>
                  <td>Adjuntos:</td>
                  <td>
<ul>
            @foreach($licitacion->adjuntos() as $a)
              <li><a target="_blank" href="http://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode={{ $a->codigoAlfresco }}">{{ $a->tipoDocumento }}</a></li>
            @endforeach
          </ul>
                  </td>
                </tr>
                <tr>
                  <td>Valor Referencial:</td>
                  <td>{{ Helper::money($licitacion->monto) }}</td>
                </tr>
@if(!empty($oportunidad))
                <tr>
                  <td>Monto Base:</td>
                  <td>{{ Helper::money($oportunidad->monto_base) }}</td>
                </tr>
                <tr>
                  <td>Instalación:</td>
                  <td>{{ $oportunidad->instalacion_dias }} días</td>
                </tr>
                <tr>
                  <td>Servicio:</td>
                  <td>{{ $oportunidad->duracion_dias }} días</td>
                </tr>
                <tr>
                  <td>Garantía:</td>
                  <td>{{ $oportunidad->garantia_dias }} días</td>
                </tr>
                <tr>
                  <td>Min. Mensualidad:</td>
                  <td>{{ $oportunidad->mensualidad() }}</td>
                </tr>
                <tr>
                  <td>¿Qué solicita?:</td>
                  <td>{{ $oportunidad->que_es }}</td>
                </tr>
@endif
              </tbody>
            </table>
          </div>
          <div class="col-12 col-md-5">
            <h5>Cronograma</h5>
            <div class="table-responsive">
              <table class="table mb-0 table-sm" style="font-size: 10px;">
            @foreach ($licitacion->cronograma() as $cro)
              <tr>
                <th>{{ $cro->descripcionEtapa }}</th>
                @if (!Helper::es_pasado($cro->fechaInicio, $class))
                  <td style="padding-right: 10px;{{ $class }};">{{ $cro->fechaInicio }} {{ $cro->horaInicio }}</td>
                @else
                  <td class="tachado" style="padding-right: 10px;{{ $class }};">{{ $cro->fechaInicio }} {{ $cro->horaInicio }}</td>
                @endif
                @if (!Helper::es_pasado($cro->fechaFin, $class)) 
                  <td style="{{ $class }};">{{ $cro->fechaFin }} {{ $cro->horaFin }}</td>
                @else
                  <td class="tachado" style="{{ $class }};">{{ $cro->fechaFin }} {{ $cro->horaFin }}</td>
                @endif
              </tr>
            @endforeach
              </table>
            </div>
            <br />
@if(!empty($oportunidad))
            <h5>Oportunidad</h5>
            <table class="table table-borderless" style="width:100%;">
              <tbody>
                <tr>
                  <td style="width:200px;">Fecha de Registro:</td>
                  <td>{{ Helper::fecha($oportunidad->created_on, true) }}</td>
                </tr>
                <tr>
                  <td style="width:200px;">Fecha de Actualización:</td>
                  <td>{{ Helper::fecha($licitacion->updated_on, true) }}</td>
                </tr>
                <tr>
                  <td style="width:200px;">Fecha de Aprobación:</td>
                  <td>{{ Helper::fecha($oportunidad->aprobado_el, true) }} x {{ Auth::user($oportunidad->aprobado_por)->usuario }}</td>
                </tr>
                <tr>
                  <td style="width:200px;">Fecha de Revisión:</td>
                  <td>{{ Helper::fecha($oportunidad->revisado_el, true) }} x {{ Auth::user($oportunidad->revisado_por)->usuario }}</td>
                </tr>
                <tr>
                  <td style="width:200px;">Registro de Participación:</td>
                  <td>{{ Helper::fecha($oportunidad->fecha_participacion, true) }}</td>
                </tr>
                <tr>
                  <td style="width:200px;">Envío de Propuesta:</td>
                  <td>{{ Helper::fecha($oportunidad->fecha_propuesta, true) }}</td>
                </tr>
                <tr>
                  <td>Fecha de Archivo:</td>
                  <td>{{ Helper::fecha($oportunidad->archivado_el, true) }} x {{ Auth::user($oportunidad->archivado_por)->usuario }}</td>
                </tr>
                <tr>
                  <td>Fecha de Rechazo:</td>
                  <td>{{ Helper::fecha($oportunidad->rechazado_el, true) }} x {{ Auth::user($oportunidad->rechazado_por)->usuario }}</td>
                </tr>
              </tbody>
            </table>
@endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- users view card data ends -->
@if(!empty($oportunidad))
<h5>Candidatos</h5>
<div class="row">
@foreach($oportunidad->empresas() as $e)
<div class="col-2 col-sm-2">
<div class="card">
<div class="card-header">
<h4 class="card-title">{{ $e->razon_social }} <span class="small"> - {{ $e->ruc }}</span></h4>
</div>
<div class="card-content">
<div class="card-body">
{{ $e->descripcion }}
@if(!empty($e->candidato))
<div class="text-center mb-1">
  <span class="{{ $e->candidato->estado()['class'] }}">{{ $e->candidato->estado()['message'] }}</span>
</div>
@endif
@if(empty($oportunidad->revisado_el))
<div>Debe marcar como <b>REVISADO</b></div>
@elseif(!empty($oportunidad->rechazado_el) || !empty($oportunidad->archivado_el))
<div>No disponible acciones</div>
@elseif(empty($e->candidato) && strtotime($licitacion->fecha_participacion_hasta) > time())
<div class="text-center">
  <a class="btn btn-sm btn-success" href="/oportunidad/{{ $licitacion->id }}/interes/{{ $e->id }}">Interés</a>
</div>
@elseif(empty($e->candidato) && strtotime($licitacion->fecha_participacion_hasta) <= time())
<div>Fuera de plazo</div>
@else
<div class="d-flex justify-content-end">
@if(!$e->candidato->estado()['timeout'])
  @if(empty($e->candidato->participacion_el))
    <a href="/oportunidad/{{ $licitacion->id }}/participar/{{ $e->candidato->id }}" class="btn btn-sm btn-info mr-25">Registrar Participación</a>
  @elseif(empty($e->candidato->propuesta_el))
    <a href="/oportunidad/{{ $licitacion->id }}/propuesta/{{ $e->candidato->id }}" class="btn btn-sm btn-dark">Enviar Propuesta</a>
  @endif
@endif
</div>
@endif

</div>
</div>
</div>
</div>
@endforeach
</div>

<div class="row">
<div class="col-6 col-sm-6">
    <!-- Timeline Widget Starts -->
    <div class="timline-card">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title">
            Historico
          </h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#inlineForm">
              <i class="bx bx-plus"></i>Add
            </button>
              <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel33">Historico</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                      </button>
                    </div>
                    <form action="/oportunidad/{{ $licitacion->id }}/observacion" method="post">
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <div class="form-group">
                          <label>¿Qué pide?:</label>
                          <input type="text" name="que_es" placeholder="Ingresa la descripción" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" />
                        </div>
                        <div class="form-group">
                          <label>Monto Base:</label>
                          <input type="number" name="monto_base" placeholder="Ingresa un monto" class="form-control" />
                        </div>
                        <div class="form-group">
                          <label>Instalación (Días):</label>
                          <input type="number" name="instalacion_dias" placeholder="Ingresa una cantidad" class="form-control" />
                        </div>
                        <div class="form-group">
                          <label>Servicio (Días):</label>
                          <input type="number" name="duracion_dias" placeholder="Ingresa una cantidad" class="form-control" />
                        </div>
                        <div class="form-group">
                          <label>Garantía (Días):</label>
                          <input type="number" name="garantia_dias" placeholder="Ingresa una cantidad" class="form-control" />
                        </div>
                        <div class="form-group">
                          <label>Observación:</label>
                          <textarea name="texto" placeholder="Ingresa un texto" class="form-control"></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">Cancelar</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                          <i class="bx bx-check d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">Guardar</span>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
<!--login form Modal -->

            <ul class="widget-timeline">
@foreach($oportunidad->timeline() as $c)
              <li class="timeline-items timeline-icon-success active">
                <div class="timeline-time">{{ Helper::fecha($c->created_on, true) }}</div>
@if(in_array($c->evento, ['texto']))
<h6 class="timeline-title">{{ $c->creado() }}, registró una observación:</h6>
<div class="timeline-content"><div>{!! nl2br($c->texto) !!}</div></div>
@elseif(in_array($c->evento, ['duracion_dias','instalacion_dias','garantia_dias']))
<h6 class="timeline-title">El usuario {{ $c->creado() }} indica:</h6>
<div class="timeline-content"><div>{{ strtoupper($c->evento) }}: {!! $c->texto !!} días</div></div>
@elseif(in_array($c->evento, ['monto_base']))
<h6 class="timeline-title">{{ $c->creado() }} ha definido un monto:</h6>
<div class="timeline-content"><div>Monto Base: {{ Helper::money($c->texto) }} soles</div></div>
@elseif(in_array($c->evento, ['accion','que_es']))
<h6 class="timeline-title">{{ $c->creado() }}:</h6>
<div class="timeline-content"><div>{{ $c->texto }}</div></div>
@else
<h6 class="timeline-title">{{ $c->creado() }}:</h6>
<div class="badge badge-light-secondary mr-1 mb-1">{{ $c->evento }} {{ $c->texto }}</div>
@endif
              </li>
@endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Timeline Widget Ends -->
</div>
<div class="col-6 col-sm-6">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title">
            Análisis de Oportunidad
          </h4>
        </div>
        <div class="card-content">
          <div class="card-body">
<table class="table mb-0 table-sm" style="font-size:11px;">
<thead>
<tr>
  <td>Servicio</th>
  <td>Min</th>
  <td>Prom.</td>
  <th>Max.</th>
</tr>
</thead>
<tbody>
@foreach($oportunidad->similares() as $s)
<tr>
  <td>
    <div style="font-weight: bold;font-size: 9px;">{{ $s->licitaciones}} x {{ $s->entidad }} - {{ $s->anho }}</div>
    <div style="">{{ $s->rotulo }}</div>
<div>
@foreach(explode(',', $s->ids) as $l)
<a href="/oportunidad/{{ $l }}/detalles" style="margin-right:5px;">{{ $l }}</a>
@endforeach
</div>
  </td>
@if($s->minimo == $s->maximo)
  <td colspan="3" style="width:80px;font-size:11px;text-align:right;">{{ Helper::money($s->minimo) }}</td>
@else
  <td style="width:80px;font-size:11px;text-align:right;">{{ Helper::money($s->minimo) }}</td>
  <td style="width:80px;font-size:11px;text-align:right;">{{ Helper::money($s->promedio) }}</td>
  <td style="width:80px;font-size:11px;text-align:right;">{{ Helper::money($s->maximo) }}</td>
@endif
</tr>
@endforeach
</tbody>
</table>

</div>
</div>
</div>
@endif
</div>
</div>
</section>
<!-- users view ends -->
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
