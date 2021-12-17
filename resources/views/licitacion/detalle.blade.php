@extends('layouts.contentLayoutMaster')
{{-- page title --}}

@section('title','Detalle Cotizacion')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection
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
          <h4 class="media-heading">Oportunidad de Negocio</h4>
          <span>Licitación del SEACE</span>
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
  <a href="/licitaciones/{{ $licitacion->id }}/revisar" class="btn btn-sm btn-success mr-25">Revisar</a>
  <a href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@elseif($oportunidad->estado == 'PENDIENTE')
  <a href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@else
  <a href="/licitaciones/{{ $licitacion->id }}/archivar" class="btn btn-sm btn-danger">Archivar</a>
@endif
@endif
    </div>
  </div>
  <!-- users view media object ends -->
  <!-- users view card data start -->
  <div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('licitacion.table', compact('licitacion'))
        </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('licitacion.cronograma', compact('licitacion'))
        </div>
      </div>
    </div>
@if(!empty($oportunidad))
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('oportunidad.table', compact('oportunidad'))
        </div>
      </div>
    </div>
  @endif
  </div>
  <div class="col-6">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
            <table class="table table-borderless">
              <tbody>
                  @if(!empty($oportunidad))
                <tr>
                  <td>Monto Base:</td>
                  <td style="display:flex;" >
                    <div data-editable="/oportunidades/{{  $oportunidad->id }}?_update=monto_base" data-name="monto_base"  >{{ Helper::money($oportunidad->monto_base) }}</div>
                  </td>
                </tr>
                <tr>
                  <td>Instalación:</td>
                  <td class="d-flex align-items-end" >
                    <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=instalacion_dias" data-name="instalacion_dias">{{ $oportunidad->instalacion_dias ?? 0 }}</div><label>días</label>
                  </td>
                </tr>
                <tr>
                  <td>Servicio:</td>
                  <td class="d-flex align-items-end ">
                    <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=duracion_dias" data-name="duracion_dias">{{ $oportunidad->duracion_dias ?? 0 }}</div> <label>días</label>
                  </td>
                </tr>
                <tr>
                  <td>Garantía:</td>
                  <td class="d-flex align-items-end">
                    <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=garantia_dias" data-name="garantia_dias">{{ $oportunidad->garantia_dias ?? 0 }}</div> <label>días</label>
                  </td>
                </tr>
                <tr>
                  <td>Estado </td>
                  <td>
                    <select class="form-control select-data" data-editable="/oportunidades/{{ $oportunidad->id }}?_update=estado" data-value="{{ $oportunidad->estado }}">
                      <option value="PENDIENTE">Pendiente</option>
                      <option value="PERDIDO">Perdido</option>
                      <option value="GANADO">Ganado</option>
                    </select> 
                   </td>  
                </tr>
@endif
              </tbody>
            </table>
      </div>
    </div>
  </div>
  </div>
  <div class="col-6">
@if(!empty($oportunidad) && !empty($oportunidad->proyecto()))
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div style="background: #b0ffc5;color: #159905;text-align: center;padding: 10px;margin-bottom: 10px;">Ya es un proyecto!</div>
        @include('proyectos.table', ['proyecto' => $oportunidad->proyecto()])
      </div>
    </div>
  </div>
@endif
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
             @if( $e->candidato->estado()['message'] == "ENVIADO" )
                <div  class="text-center mb-1">
                  <a class="btn btn-light-success" href="{{  route('oportunidad.proyecto', ['candidato' => $e->candidato->id] ) }} " >Pasar proyecto</a>
                </div>
             @endif
          @endif
@if(empty($oportunidad->revisado_el))
<div>Debe marcar como <b>REVISADO</b></div>
@elseif(!empty($oportunidad->rechazado_el) || !empty($oportunidad->archivado_el))
<div>No disponible acciones</div>
@elseif(empty($e->candidato) && strtotime($licitacion->fecha_participacion_hasta) > time())
<div class="text-center">
  <a class="btn btn-sm btn-success" href="/licitaciones/{{ $licitacion->id }}/interes/{{ $e->id }}">Interés</a>
</div>
@elseif(empty($e->candidato) && strtotime($licitacion->fecha_participacion_hasta) <= time())
<div>Fuera de plazo</div>
@else
<div class="d-flex justify-content-end">
@if(!$e->candidato->estado()['timeout'])
  @if(empty($e->candidato->participacion_el))
    <a href="/licitaciones/{{ $licitacion->id }}/participar/{{ $e->candidato->id }}" class="btn btn-sm btn-info mr-25">Registrar Participación</a>
  @elseif(empty($e->candidato->propuesta_el))
    <a href="/licitaciones/{{ $licitacion->id }}/propuesta/{{ $e->candidato->id }}" class="btn btn-sm btn-dark">Enviar Propuesta</a>
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
                    <form action="/licitaciones/{{ $licitacion->id }}/observacion" method="post">
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Observación:</label>
                          <textarea name="texto" placeholder="Ingresa un texto" class="form-control" rows="3"></textarea>
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
                  @elseif(in_array($c->evento, ['accion','rotulo']))
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
<!--<div class="col-6 col-sm-6">
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
<a href="/licitaciones/{{ $l }}/detalles" style="margin-right:5px;">{{ $l }}</a>
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
</section>-->
<!-- users view ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>  
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
