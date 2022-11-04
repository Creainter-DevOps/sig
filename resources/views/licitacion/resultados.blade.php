@extends('layouts.contentLayoutMaster')
@section('title','Dashboard Analytics')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/clndr.css')}}">
@endsection

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
<section id="dashboard-analytics">
    <div class="row">
      <div class="col-xl-12 col-12 dashboard-marketing-campaign">
        <div class="dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Resultado en Oportunidades</h4>
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
@foreach(App\Oportunidad::listado_propuestas_buenas_pro($execute) as $v)
                <tr data-link="/oportunidades/{{ $v->id }}/">
                  <td title="{{ $v->rotulo() }}" class="text-center">
                    <div>{!! $v->nomenclatura !!}</div>
                    <div><span class="{{ $v->estado_pro()['class'] }}">{{ $v->estado_pro()['message'] }}</span></div>
                  </td>
                  <td class="text-center">
                    {{ $v->participantes() }}
                  </td>
                  <td>
                    {!! $v->ganadora() !!}
                    @if(!empty($v->perdido_por))
                    <div style="color: red;text-align: center;font-size: 10px;background: #ffdfdf;">{{ App\Oportunidad::selectPerdidos()[$v->perdido_por]['name'] }}</div>
                    @endif
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
          </div>
          <div style="text-align:right;font-size:11px;padding: 0 5px;">Tiempo de consulta: {{ $execute->time }} ms</div>
        </div>
      </div>
      </div>
    </div>
  </section>
@endsection
