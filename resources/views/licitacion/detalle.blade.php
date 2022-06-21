@extends('layouts.contentLayoutMaster')
{{-- page title --}}

@section('title','Detalle Licitacion')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/widgets.css')}}">

@endsection
{{-- page styles --}}
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
<!--<div>Seguir</div>-->
<a class="btn btn-success"href="/licitaciones/{{ $licitacion->id }}/aprobar">Aprobar</a>  
@else
@if(!empty($oportunidad->rechazado_el))
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por qué motivo?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <div class="text-center">Rechazado el {{ Helper::fecha($oportunidad->rechazado_el, true) }}</div>
@elseif(!empty($oportunidad->archivado_el))
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por qué motivo?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <div class="text-center">Archivado el {{ Helper::fecha($oportunidad->archivado_el, true) }}</div>
  <a class="btn btn-primary" href="/licitaciones/{{$oportunidad->licitacion_id}}/documento" ><i class="bx bxs-file-pdf"></i></a>
@elseif(empty($oportunidad->aprobado_el))
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por qué motivo?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <a href="/licitaciones/{{ $licitacion->id }}/aprobar" class="btn btn-sm btn-success mr-25">Aprobar</a>
  <a href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@elseif(empty($oportunidad->revisado_el))
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por qué motivo?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <a href="/licitaciones/{{ $licitacion->id }}/revisar" class="btn btn-sm btn-success mr-25">Revisar</a>
  <a href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@elseif($oportunidad->estado == 'PENDIENTE')
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por qué motivo?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <a href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger mr-25">Rechazar</a>
@else
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por qué motivo?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <a href="/licitaciones/{{ $licitacion->id }}/archivar" class="btn btn-sm btn-danger">Archivar</a>
@endif
@endif
    </div>
  </div>
  <div class="row">
@if(!empty($oportunidad) && !empty($oportunidad->cliente_id))
    <div class="col-12">
      <div style="text-align: center;background: #6ea1ff;margin-bottom: 5px;color: #ffff;">EL CLIENTE</div>
      <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('clientes.table', ['cliente' => $oportunidad->cliente()])
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('clientes.contactos', ['cliente' => $oportunidad->cliente()])
          </div>
        </div>
      </div>
      </div>
    </div>
@endif
    <div class="col-12">
      <div style="text-align: center;background: #ffb16e;margin-bottom: 5px;color: #ffff;">LA OPORTUNIDAD</div>
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
            <table class="table table-borderless table-sm">
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
                  <td>Estado</td>
                  <td><h3>{{ $oportunidad->render_estado() }}</h3></td>
                </tr>
@endif
              </tbody>
            </table>
      </div>
    </div>
  </div>
  </div>
  <div class="col-6">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
@if(!empty($oportunidad->id))
        <label>Apuntes</label>
        <div data-ishtml data-editable="/oportunidades/{{  $oportunidad->id }}?_update=observacion">{!! $oportunidad->observacion !!}</div>
@endif
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
</div>
@if(!empty($licitacion->buenapro_fecha) && !empty($oportunidad->id) && empty($oportunidad->conclusion_el))
<h5>Resultado de la Licitación</h5>
<div class="text-center">
  <input type="text" data-editable="/oportunidades/{{  $oportunidad->id }}?_update=motivo" placeholder="¿Por el precio?" style="margin-right: 10px;" value="{{ $oportunidad->motivo }}">
  <a class="btn btn-danger" style="color:#fff;" href="{{  route('oportunidades.cerrar', ['oportunidad' => $oportunidad->id] ) }}">Se perdió</a>
</div>
@endif
  
<style>
.certificado_button {

}
.certificado_button:hover + .certificado_body {
  display: block;
}
.certificado_body {
  position: fixed;
  width: 800px;
  height: 600px;background: white;z-index: 9999999999999;top: 29px;left: 50%;
  margin-left: -400px;padding: 10px 20px;border: 1px solid #727272;
  display: none;
}
.wrapper {
  max-width: 330px;
  font-family: 'Helvetica';
  font-size: 14px;
}

.StepProgress {
  position: relative;
  padding-left: 45px;
  list-style: none;
}
.StepProgress::before {
  display: inline-block;
  content: '';
  position: absolute;
  top: 0;
  left: 15px;
  width: 10px;
  height: 100%;
  border-left: 2px solid #CCC;
}
.StepProgress-item {
  position: relative;
  counter-increment: list;
}
.StepProgress-item:not(:last-child) {
  padding-bottom: 20px;
}
.StepProgress-item::before {
  display: inline-block;
  content: '';
  position: absolute;
  left: -30px;
  height: 100%;
  width: 10px;
}
.StepProgress-item::after {
  content: '';
  display: inline-block;
  position: absolute;
  top: 0;
  left: -37px;
  width: 12px;
  height: 12px;
  border: 2px solid #CCC;
  border-radius: 50%;
  background-color: #FFF;
}
.StepProgress-item.is-done::before {
  border-left: 2px solid green;
}
.StepProgress-item.is-done::after {
  content: "✔";
  font-size: 10px;
  color: #FFF;
  text-align: center;
  border: 2px solid green;
  background-color: green;
}
.StepProgress-item.current::before {
  border-left: 2px solid green;
}
.StepProgress-item.current::after {
  content: counter(list);
  padding-top: 1px;
  width: 19px;
  height: 18px;
  top: -4px;
  left: -40px;
  font-size: 14px;
  text-align: center;
  color: green;
  border: 2px solid green;
  background-color: white;
}
.StepProgress strong {
  display: block;
}
</style>

@if(!empty($oportunidad))
<h5>Cotizaciones</h5>
<div class="row">
@foreach($oportunidad->empresas() as $e)
  <div class="col-2 col-sm-2">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">{{ $e->razon_social }} <span class="small"> - {{ $e->ruc }}</span></h6>
      </div>
      <div class="card-content">
        <div class="card-body">
          {{ $e->descripcion }}
            @if(empty($oportunidad->revisado_el) && false)
              <div>Debe marcar como <b>REVISADO</b></div>
             @elseif(empty($e->cotizacion) && strtotime($licitacion->fecha_participacion_hasta) > time())
              <div class="text-center">
                <a class="btn btn-sm btn-success" href="/licitaciones/{{ $licitacion->id }}/interes/{{ $e->id }}">Interés</a>
             </div>
            @elseif(empty($e->cotizacion) && strtotime($licitacion->fecha_participacion_hasta) <= time())
            <div>Fuera de plazo</div>
            @else
              <div class="wrapper">
                <ul class="StepProgress">
                <li class="StepProgress-item is-done">
                  <strong>Participación</strong>
                  @if(!empty($e->cotizacion))
                  <div class="text-center mb-1">
                    <span class="{{ $e->cotizacion->estado_participacion()['class'] }}">{{ $e->cotizacion->estado_participacion()['message'] }}</span>
                    @if(!empty($e->cotizacion->seace_participacion_log))
              <!--<div style="font-size: 11px;background: #29237e;margin-top: 4px;border-radius: 4px;padding: 5px;color: #fff;max-height: 160px;overflow: auto;">{!! nl2br($e->cotizacion->seace_participacion_log) !!}</div> -->
              @if(!empty($e->cotizacion->seace_participacion_fecha))
                <div style="text-align: center;margin-top: 5px;">
                  <span class="badge badge-primary certificado_button">Constancia</span>
                  <div class="certificado_body">{!! $e->cotizacion->seace_participacion_html !!}</div>
                  <div style="font-size:11px;">{{ Helper::fecha($e->cotizacion->seace_participacion_fecha, true) }}</div>
                </div>
              @endif
            @endif
                  </div>
                  @endif
                   @if(!$e->cotizacion->estado()['timeout'])
                    @if(empty($e->cotizacion->participacion_el))
                      <a href="/licitaciones/{{ $licitacion->id }}/participar/{{ $e->cotizacion->id }}" class="btn btn-sm btn-info mr-25">Registrar Participación</a>
                    @endif
                  @endif
                </li>
                <li class="StepProgress-item is-done">
                  <strong>Propuesta</strong>
                  @if(!empty($e->cotizacion))
                  <div class="text-center mb-1">
                    <span class="{{ $e->cotizacion->estado_propuesta()['class'] }}">{{ $e->cotizacion->estado_propuesta()['message'] }}</span>
                  </div>
                  @endif
                  @if( $e->cotizacion)
                    <div class="text-center" style="margin-bottom:10px;">
                      <a class="btn btn-sm btn-success" href="/expediente/{{ $e->cotizacion->id }}/inicio">Armar Expediente</a>
                    </div>
                  @endif
                   @if(!$e->cotizacion->estado()['timeout'])
                    @if(empty($e->cotizacion->propuesta_el))
                      <a href="/licitaciones/{{ $licitacion->id }}/propuesta/{{ $e->cotizacion->id }}" class="btn btn-sm btn-dark">Enviar Propuesta</a>
                    @endif
                  @endif
                </li>
                </ul>
              </div>
            @endif
      </div>
  </div>
</div>
</div>
@endforeach
</div>
</div>
<div class="row">
@if(!empty($oportunidad))
  <div class="col-12">
    @include('actividad.create', ['into' => [ 'licitacion_id'=> $oportunidad->licitacion_id ,   'oportunidad_id' => $oportunidad->id]])
</div>
@endif
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
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>

@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
<script src="{{asset('js/scripts/cards/widgets.js')}}"></script>
@endsection
