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
      <div class="col-12">
        <div class="card">
        <div class="table-responsive">
        <table class="table table-striped table-reduce table-sm" style="margin-bottom:0">
          <tr>
            <th style="width:180px;">DÍA</th>
            @foreach($chartjs['resumen'] as $n)
            <th class="text-center" style="padding: 1.15rem 10px;background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ date('d/m', strtotime($n->fecha)) }}</th>
            @endforeach
          </tr>
          <tr>
            <th>LICITACIONES</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->oportunidades }}</td>
            @endforeach
          </tr>
          <tr>
            <th>PROPUESTAS</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->enviadas }}</td>
            @endforeach
          </tr>
          <tr>
            <th>SOLO HOY</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->terminados }}</td>
            @endforeach
          </tr>
           <tr>
            <th>RECHAZADOS</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->rechazados }}</td>
            @endforeach
          </tr>
        </table>
        </div>
        <div style="text-align:right;font-size:11px;padding: 0 5px;">Tiempo de consulta: {{ $chartjs['execute']->time }} ms</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
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
                    <div style="font-size:11px;"><i class="bx bx-buildings" style="font-size:12px"></i> {!! $v->inx_rotulo !!}
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
