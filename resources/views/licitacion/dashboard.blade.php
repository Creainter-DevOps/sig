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
        <table class="table table-striped table-reduce" style="margin-bottom:0">
          <tr>
            <th style="width:180px;">RESUMEN DEL MES</th>
            @foreach($chartjs['resumen'] as $n)
            <th class="text-center" style="padding: 1.15rem 10px;background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ date('d', strtotime($n->fecha)) }}</th>
            @endforeach
          </tr>
          <tr>
            <th>OPORTUNIDADES</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->oportunidades }}</td>
            @endforeach
          </tr>
          <tr>
            <th>PARTICIPANDO</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->enviadas2 }}</td>
            @endforeach
          </tr>
          <!--<tr>
            <th>PROPUESTAS</th>
            @foreach($chartjs['resumen'] as $n)
            <td class="text-center" style="background:{{ date('d', strtotime($n->fecha)) == date('d') ? '#b7ffaf' : '' }}">{{ $n->enviadas }}</td>
            @endforeach
          </tr>-->
        </table>
        </div>
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
            <h4 class="card-title">Registro en Oportunidades ({{ count($participaciones_por_vencer) }})</h4>
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
@foreach($participaciones_por_vencer as $v)
                @if(!empty($v->correo_id))
                  <tr style="background: #fff9dc;">
                @else
                  <tr>
                @endif
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
                    <a href="/oportunidades/{{ $v->id }}/">
                      <i class="bx bx-show-alt"></i>
                    </a>
                    <div>{{ $v->montos }}</div>
                  </td>
                </tr>
@endforeach
              </tbody>
            </table>
            <!-- table ends -->
          </div>
        </div>
        <div class="dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Resultado en Oportunidades ({{ count($propuestas_en_pro) }})</h4>
          </div>
         <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce">
              <thead>
                <tr>
                  <th>Nomenclatura</th>
                  <th>Participación</th>
                  <th>Ganadora</th>
                  <th>Elaborado por</th>
                  <th style="width:20px;"></th>
                </tr>
              </thead>
              <tbody>
@foreach($propuestas_en_pro as $v)
                <tr>
                  <td title="{{ $v->rotulo() }}" class="text-center">
                    <div>{!! $v->nomenclatura !!}</div>
                    <div><span class="{{ $v->estado_pro()['class'] }}">{{ $v->estado_pro()['message'] }}</span></div>
                  </td>
                  <td class="text-center">
                    {{ $v->participantes() }}
                  </td>
                  <td>
                    {!! $v->ganadora() !!}
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span style="font-size: 10px;">{!! implode('<br/>', explode(',', $v->elaborado_por)) !!}</span>
                  </td>
                  <td class="text-center" style="width:20px;">
                    <a href="/oportunidades/{{ $v->id }}/">
                      <i class="bx bx-show-alt"></i>
                    </a>
                  </td>
                </tr>
@endforeach
              </tbody>
            </table>
            <!-- table ends -->
          </div>
        </div>
      </div>
      </div>
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Expedientes ({{ count($propuestas_por_vencer) }})</h4>
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
@foreach($propuestas_por_vencer as $v)
                @if(!empty($v->correo_id))
                  <tr style="background: #fff9dc;">
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
                    <a href="/oportunidades/{{ $v->id }}/">
                      <i class="bx bx-show-alt"></i>
                    </a>
                    <div>{{ $v->montos }}</div>
                  </td>
                </tr>
              @else
              <tr>
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
                    <a href="/oportunidades/{{ $v->id }}/">
                      <i class="bx bx-show-alt"></i>
                    </a>
                    <div>{{ $v->montos }}</div>
                  </td>
                </tr>
              @endif
@endforeach
              </tbody>
            </table>
            <!-- table ends -->
          </div>
        </div>
      </div>
<!-- Dashboard Ecommerce ends -->
      <!-- Task Card Starts -->
    </div>
  </section>
  <!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
