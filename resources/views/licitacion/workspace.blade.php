@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard Analytics')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/clndr.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
@endsection

@section('vendor-scripts')
@parent
@endsection

@section('page-scripts')
@parent
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row">
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
        <div class="card">
          <div class="card-body">
          <table class="table table-striped table-reduce text-center table-padding-less">
            <thead>
              <tr>
                <th rowspan="2">Usuario</th>
                <th rowspan="2" style="width:200px">U.Acceso</th>
                <th colspan="2">Documentos</th>
                <th colspan="3">Oportunidades</th>
              </tr>
              <tr>
                <th>Elab.</th>
                <th>Verif.</th>
                <th>Aprob.</th>
                <th>Rechaz.</th>
                <th>Archiv.</th>
              </tr>
            </thead>
            <tbody>
            @foreach(App\Dashboard::usuarios_elaborados() as $u)
              <tr>
                <th>{{ $u->usuario }}</th>
                <td style="width:200px;">{{ Helper::fecha($u->last_sesion, true) }}</td>
                <td>{{ $u->elaborados }}</td>
                <td>{{ $u->correctos }}</td>
                <td>{{ $u->aprobados }}</td>
                <td>{{ $u->rechazados }}</td>
                <td>{{ $u->archivados }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Expedientes en Elaboración</h4>
          </div>
          <div data-block-dinamic="/licitaciones/part/avance_expedientes" data-block-refresh="40" data-block-auto="true"></div>
        </div>
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Oportunidades Libres</h4>
          </div>
          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce">
              <thead>
                <tr>
                  <th>Nomenclatura</th>
                  <th style="width:120px;">Estado</th>
                  <th style="width:80px;"></th>
                </tr>
              </thead>
              <tbody>
              @foreach(App\Oportunidad::listado_propuestas_por_vencer_correo($execute) as $v)
                  <tr data-link="/oportunidades/{{ $v->id }}/">
                  <td class="" style="max-width:200px;">
                    <div style="font-size:11px;"><i class="bx bx-envelope" style="font-size:12px"></i> {!! $v->inx_rotulo !!}</div>
                    @if(empty($v->revisado_el))
                    <div style="font-size:9px;">Aprobado el {{ Helper::fecha($v->aprobado_el, true) }} por {{ $v->aprobado_por }}</div>
                    @else
                    <div style="font-size:9px;color: #21a509;">Revisado el {{ Helper::fecha($v->revisado_el, true) }} por {{ $v->revisado_por }}</div>
                    @endif
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_propuesta()['class'] }}">{{ $v->estado_propuesta()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->fecha_propuesta_hasta, true) }}</div>
                    <div style="font-size:10px;">{{ $v->etiquetas }}</div>
                  </td>
                  <td class="text-center" style="width:80px;">
            <ul class="list-inline mb-0">
              <li>
                <i class="bx bx-dots-vertical-rounded" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="/oportunidades/{{ $v->id }}/">Ver Ficha de Oportunidad</a>
                  <a class="dropdown-item" href="javascript:todo_add('/oportunidades/{{ $v->id }}/','PRECIO')">Solicitar Precio</a>
                  @foreach ([] as $e)
                    @if(!empty($e->cotizacion))
                      <a class="dropdown-item" style="background: #cfffcf">Registrado con {{ $e->razon_social }}</a>
                    @else
                      <a class="dropdown-item" href="/oportunidades/{{ $v->id }}/interes/{{ $e->id }}" data-confirm data-button-dinamic>Interés con {{ $e->razon_social }}</a>
                    @endif
                  @endforeach
                  <a class="dropdown-item" data-confirm-input="¿Por qué desea Rechazarlo?" href="/oportunidades/{{ $v->id }}/rechazar" data-button-dinamic>Rechazar Oportunidad</a>
                </div>
              </li>
            </ul>
            <div>{{ $v->montos }}</div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div style="text-align:right;font-size:11px;padding: 0 5px;">Tiempo de consulta: {{ $execute->time }} ms</div>
        </div>
      </div>
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
@php
  $subsanaciones = App\Oportunidad::listado_solicitud_subsanaciones($execute);
  $estadistica   = App\Oportunidad::estadistica_al_dia($executen);
@endphp
<style>
.avd_container {
  width: 100%;
  padding: 10px;
  background: #f9f9f9;
  border-radius: 5px;
  min-height: 90px;
}
.avd_right {
  position: relative;
  min-height: 27px;
  border-right: 1px solid #b7b7b7;
  border-top: 10px solid transparent;
  min-width: 60px;
}
.avd_right:before {
  content: attr(data-title);
  position: absolute;
  right: 3px;
  font-size: 11px;
  top: 18px;
}
.avd_right:after {
  content: attr(data-count);
  position: absolute;
  right: 3px;
  font-size: 11px;
  top: 8px;
}
</style>
@if(!empty($estadistica->oportunidades))
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
          @if($estadistica->fecha == date('Y-m-d'))
            <h4 class="card-title">Avance de Hoy</h4>
          @else
            <h4 class="card-title">Avance del {{ date('l', strtotime($estadistica->fecha)) }}, {{ Helper::fecha($estadistica->fecha) }}</h4>
          @endif
          </div>
          <div class="card-body">
            <div class="avd_container">
              <div class="avd_right" data-title="Oportunidades" data-count="{{ $estadistica->oportunidades }}" style="width:100%;border-top-color: #c3c3c3;">
                <div class="avd_right" data-title="Con precio" data-count="{{ $estadistica->con_precio }}" style="width:80%;border-top-color: #ffcb7d;">
                @if(!empty($estadistica->con_precio))
                  <div class="avd_right" data-title="Elaborados" data-count="{{ $estadistica->elaborados }}" style="width:{{ $estadistica->elaborados * 100 / $estadistica->con_precio }}%;border-top-color: #5f9fff;">
                    <div class="avd_right" data-title="Aprobados" data-count="{{ $estadistica->aprobados }}" style="width:{{ $estadistica->aprobados * 100 / $estadistica->con_precio }}%;border-top-color: #8ce775;">
                    </div>
                  </div>
                @else
                  <div class="avd_right" data-title="Elaborados" data-count="{{ $estadistica->elaborados }}" style="width:20%;border-top-color: #5f9fff;">
                    <div class="avd_right" data-title="Aprobados" data-count="{{ $estadistica->aprobados }}" style="width:50%;border-top-color: #8ce775;">
                    </div>
                  </div>
                @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
@if(!empty($subsanaciones) && count($subsanaciones) > 0)
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Subsanaciones</h4>
          </div>
          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-sm" style="font-size:12px;">
              <thead>
                <tr>
                  <th>Oportunidad</th>
                  <th style="width:120px;">Días de Plazo</th>
                  <th style="width:120px;">Respuesta</th>
                </tr>
              </thead>
              <tbody>
              @foreach($subsanaciones as $v)
              <tr>
              <td>
                <small style="font-size: 9px;">{{ $v->entidad }}</small>
                <div style="font-size:12px;"><a href="{{ route('oportunidades.show', ['oportunidad' => $v->oportunidad_id]) }}" style="color:#606060;">{{ $v->rotulo }}</a></div>
                <div style="font-size:11px;">Cotizado el {{ Helper::fecha($v->propuesta_el, true) }}, por {{ $v->elaborado_por }}</div>
              </td>
              <td class="text-center">
                <div style="font-size:11px;">{{ Helper::fecha($v->fecha) }}</div>
                <div style="font-size:20px;">{{ $v->dias_habiles}}</div>
                <div style="font-size:11px;">{{ Helper::fecha($v->fecha_limite) }}</div>
              </td>
              <td class="text-center">
                @if(!empty($v->respondido_el))
                <div style="background: #74e559;color: #fff;text-align: center;border-radius: 4px;padding: 2px 5px;">por {{ $v->respondido_por }}</div>
                <small>{{ Helper::fecha($v->respondido_el, true) }}</small>
                @else
                @if($v->restan >= 0)
                <div style="background: #f8a72b;color: #fff;text-align: center;border-radius: 4px;padding: 2px 5px;">Pendiente</div>
                @else
                <div style="background: #f82b2b;color: #fff;text-align: center;border-radius: 4px;padding: 2px 5px;">Vencido</div>
                @endif
                @endif
                <div>
                  <a href="{{ route('subsanacion.expediente', ['subsanacion' => $v->id]) }}">Mesa de Trabajo</a>
                </div>
              </td>
              <tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
@endif
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Oportunidades por Licitación</h4>
          </div>
          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce">
              <thead>
                <tr>
                  <th>Nomenclatura</th>
                  <th style="width:120px;">Estado</th>
                  <th style="width:80px;"></th>
                </tr>
              </thead>
              <tbody>
@foreach(App\Oportunidad::listado_propuestas_por_vencer($execute) as $v)
              <tr data-link="/oportunidades/{{ $v->id }}/">
                  <td class="" style="max-width:200px;">
                    <div style="font-size:11px;">
                    @if(!empty($v->cantidad_similar))
                    <a href="/oportunidades/{{ $v->id }}" style="color: #000000;"><i class="bx bx-buildings" style="font-size:12px"></i>{!! $v->inx_rotulo !!}</a>
                    @else
                    <a href="/oportunidades/{{ $v->id }}" style="color: #727E8C;"><i class="bx bx-buildings" style="font-size:12px"></i>{!! $v->inx_rotulo !!}</a>
                    @endif
                    @if(!empty($v->tiene_bases))
                    <i class="bx bx-check" style="font-size:15px;color:green;"></i>
                    @endif
                    </div>
                    @if(empty($v->revisado_el))
                    <div style="font-size:9px;">Aprobado el {{ Helper::fecha($v->aprobado_el, true) }} por {{ $v->aprobado_por }}</div>
                    @else
                    <div style="font-size:9px;color: #21a509;">Revisado el {{ Helper::fecha($v->revisado_el, true) }} por {{ $v->revisado_por }}</div>
                    @endif
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_propuesta()['class'] }}">{{ $v->estado_propuesta()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->fecha_propuesta_hasta, true) }}</div>
                    <div style="font-size:10px;">{{ $v->etiquetas }}</div>
                  </td>
                  <td class="text-center" style="width:80px;">
            <ul class="list-inline mb-0">
              <li>
                <i class="bx bx-dots-vertical-rounded" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="/oportunidades/{{ $v->id }}/">Ver Ficha de Oportunidad</a>
                  <a class="dropdown-item" href="javascript:todo_add('/oportunidades/{{ $v->id }}/','MONTO')">Solicitar Monto</a>
                  @foreach ([] as $e)
                    @if(!empty($e->cotizacion))
                      <a class="dropdown-item" style="background: #cfffcf">Registrado con {{ $e->razon_social }}</a>
                    @else
                      <a class="dropdown-item" href="/oportunidades/{{ $v->id }}/interes/{{ $e->id }}" data-confirm data-button-dinamic>Interés con {{ $e->razon_social }}</a>
                    @endif
                  q
                  @endforeach
                  <a class="dropdown-item" data-confirm-input="¿Por qué desea Rechazarlo?" href="/oportunidades/{{ $v->id }}/rechazar" data-button-dinamic>Rechazar Oportunidad</a>
                </div>
              </li>
            </ul>
                    <div>{{ $v->montos }}</div>
                  </td>
                </tr>
@endforeach
              </tbody>
            </table>
            <!-- table ends -->
          </div>
          <div style="text-align:right;font-size:11px;padding: 0 5px;">Tiempo de consulta: {{ $execute->time }} ms</div>
        </div>
      </div>
<!-- Dashboard Ecommerce ends -->
      <!-- Task Card Starts -->
    </div>
  </section>
  <!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
