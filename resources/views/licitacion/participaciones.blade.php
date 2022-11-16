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
      <div class="col-xl-12 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Registro en Oportunidades</h4>
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
@foreach(App\Oportunidad::listado_participanes_por_vencer($execute) as $v)
                <tr data-link="/oportunidades/{{ $v->id }}/">
                  <td class="">
                    <div style="font-size:11px;">{!! $v->inx_rotulo !!}</div>
                    @if(empty($v->revisado_el))
                    <div style="font-size:9px;">Aprobado el {{ Helper::fecha($v->aprobado_el, true) }} por {{ $v->aprobado_por }}</div>
                    @else
                    <div style="font-size:9px;color: #21a509;">Revisado el {{ Helper::fecha($v->revisado_el, true) }} por {{ $v->revisado_por }}</div>
                    @endif
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span>{{ $v->montos }}</span>
                    <span class="{{ $v->estado_participacion()['class'] }}">{{ $v->estado_participacion()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->fecha_participacion_hasta, true) }}</div>
                    <div style="font-size:10px;">{{ $v->etiquetas }}</div>
                  </td>
                  <td class="text-center" style="width:80px;">
            <ul class="list-inline mb-0">
              <li>
                <i class="bx bx-dots-vertical-rounded" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="/oportunidades/{{ $v->id }}/">Ver Ficha de Oportunidad</a>
                  @foreach ($v->empresasMenu() as $e)
                    @if(!empty($e->cotizacion))
                      <a class="dropdown-item" style="background: #cfffcf">Registrado con {{ $e->razon_social }}</a>
                    @else
                      <a class="dropdown-item" href="/oportunidades/{{ $v->id }}/interes/{{ $e->id }}" data-button-dinamic>Interés con {{ $e->razon_social }}</a>
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
    </div>
  </section>
@endsection

{{-- vendor scripts --}}
