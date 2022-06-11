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
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/chart.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="{{asset('vendors/js/calendar/clndr.js')}}"></script>
<script type="module" src="{{asset('vendors/js/calendar/moment.js')}}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/pages/dashboard-analytics.js')}}"></script>
<script>
  var events = {!! json_encode($actividades) !!}; 
</script>
<script src="{{asset('js/scripts/clndr.js')}}"></script>
<script>
var $primary = '#5A8DEE',
    $success = '#39DA8A',
    $danger = '#FF5B5C',
    $warning = '#FDAC41',
    $info = '#00CFDD',
    $label_color = '#475F7B',
    grid_line_color = '#dae1e7',
    scatter_grid_color = '#f3f3f3',
    $scatter_point_light = '#E6EAEE',
    $scatter_point_dark = '#5A8DEE',
    $white = '#fff',
    $black = '#000';

  var themeColors = [$primary, $warning, $danger, $success, $info, $label_color];

  var linechartOptions = {
    responsive: true,
    maintainAspectRatio: true,
    legend: {
      position: 'top',
    },
    hover: {
      mode: 'label'
    },
    scales: {
      xAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }],
      yAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }]
    },
    title: {
      display: true,
      text: 'World population per region (in millions)'
    }
  };

  // Chart Data
  (function() {
  var lineChartconfig = {!! json_encode($chartjs['barras']) !!};
  lineChartconfig.options = {
    responsive: false,
    maintainAspectRatio: false,
    legend: {
      position: 'top',
    },
    hover: {
      mode: 'label'
    },
    scales: {
      xAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }],
      yAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }]
    },
    title: {
      display: true,
      text: 'Eventos Registrados durante la Semana'
    }
  };
  var lineChart = new Chart(document.getElementById('line-chart-1'), lineChartconfig);
  })();

  (function() {
  var lineChartconfig = {!! json_encode($chartjs['barras2']) !!};
  lineChartconfig.options = {
    responsive: false,
    maintainAspectRatio: false,
    legend: {
      position: 'top',
    },
    hover: {
      mode: 'label'
    },
    scales: {
      xAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }],
      yAxes: [{
        display: true,
        gridLines: {
          color: grid_line_color,
        },
        scaleLabel: {
          display: true,
        }
      }]
    },
    title: {
      display: true,
      text: 'Propuestas mensuales'
    }
  };
  var lineChart = new Chart(document.getElementById('line-chart-2'), lineChartconfig);
  })();

  function getActividades(fecha, usuario_id) {
    let url = '/actividades/listado_ajax';
    let formdata = new FormData();
    formdata.append('fecha', fecha ?? '');
    formdata.append('usuario_id', usuario_id ?? '');
    fetch(url, {
      method: 'post',
      headers: {
        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formdata
    })
    .then( response => response.json() )
    .then( data => {
      let box = $('#contentActividades');
      box.empty();
      data.forEach(n => {
        box.append(`<tr>
          <td>${n.momento}</td>
          <td>${n.descripcion}</td>
          <td>${n.usuario}</td>
          <td>${n.tiempo_calculado}</td>
          </tr>`);
      });
    });
  }
  getActividades(null, null);
</script>
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row">
      <!-- Website Analytics Starts-->
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Oportunidades</h4>
            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
          </div>
          <div class="card-content">
            <div class="card-body pb-1">
              <div class="d-flex justify-content-around align-items-center flex-wrap">
                <div class="user-analytics">
                  <i class="bx bx-user mr-25 align-middle"></i>
                  <span class="align-middle text-muted">Users</span>
                  <div class="d-flex">
                    <div id="radial-success-chart"></div>
                    <h3 class="mt-1 ml-50">61K</h3>
                  </div>
                </div>
                <div class="sessions-analytics">
                  <i class="bx bx-trending-up align-middle mr-25"></i>
                  <span class="align-middle text-muted">Sessions</span>
                  <div class="d-flex">
                    <div id="radial-warning-chart"></div>
                    <h3 class="mt-1 ml-50">92K</h3>
                  </div>
                </div>
                <div class="bounce-rate-analytics">
                  <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                  <span class="align-middle text-muted">Bounce Rate</span>
                  <div class="d-flex">
                    <div id="radial-danger-chart"></div>
                    <h3 class="mt-1 ml-50">72.6%</h3>
                  </div>
                </div>
              </div>
              <canvas id="line-chart-1" style="width:100%;max-height:400px;"></canvas>
            </div>
          </div>
        </div>

      </div>
      <div class="col-md-6 col-sm-12 dashboard-referral-impression">
        <div class="card">
          <div class="card-content">
            <div class="card-body text-center pb-0" style="position: relative;">
              <canvas id="line-chart-2" style="width:100%;max-height:400px;"></canvas>
            </div>
          </div>
        </div>
      </div>
     <div class="col-md-6 col-sm-12 ">
       <div class="card">
          <div class="card-content">
            <div class="card-body text-center pb-0" style="position: relative;">
              <div class="calendar" id="mini-clndr">
                    <script type="text/template" id="calendar-template">
                        <div class="controls">
                            <div class="clndr-previous-button">‹</div>
                            <div class="month"><%= month %></div>
                            <div class="clndr-next-button">›</div>
                        </div>
                        <div class="days-container">
                            <div class="days">
                                <div class="headers">
                                    <% _.each(daysOfTheWeek, function(day) { %>
                                        <div class="day-header"><%= day %></div>
                                    <% }); %>
                                </div>
                                <div class="day-content">
                                    <% _.each(days, function(day) { %>
                                    <div class="<%= day.classes %>" id="<%= day.id %>">
                                        <span class="day-number"><%= day.day %></span>
                                        <% _.each(eventsThisMonth, function(event) { %>
                                        <% if ( event.dia == day.day && day.classes.indexOf('next-month') < 0 && day.classes.indexOf('last-month') < 0  ) { %>
                                        <div class="event" id="<%= event.id %>">
                                          <a style ="font-size:10px;" href="javascript:getActividades('<%= event.date %>',<%= event.user_id %>);">
                                            <%= event.title %> : <%= event.tiempo %> 
                                          </a>
                                        </div>
                                        <% } %>   
                                    <% }); %>
                                    </div>
                                <% }); %>
                                </div>

                            </div>
                            <!--<div class="events">
                                <div class="headers bg-">
                                    <div class="x-button">✕</div>
                                    <div class="event-header">Actividades</div>
                                </div>
                                <div class="events-list">
                                    <% _.each(eventsThisMonth, function(event) { %>
                                    <div class="event" id="<%= event.id %>">
                                        <a>
                                            <%= event.dia %>:<i class="bx bx-user mr-25 align-middle"></i> <%= event.title %><i class='bx bx-hash'></i><%= event.oportunidades %><i class='bx bxs-time' ></i><%= event.tiempo %> 
                                        </a>
                                    </div>
                                <% }); %>
                                </div>-->
                            </div>
                        </div>
                    </script>
                </div>
            </div>
          </div>
        </div>
    </div> 
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Actividades</h4>
          </div>
          <div class="card-content">
            <div class="card-body pb-1">
<div style="max-height: 320px;overflow: auto;">
<table style="width: 100%;font-size: 11px;">
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Actividad</th>
      <th>Autor</th>
      <th>T. Estimado</th>
    </tr>
  </thead>
  <tbody id="contentActividades">
  </tbody>
</table>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- Marketing Campaigns Starts -->
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Participaciones por Vencer ({{ count($participaciones_por_vencer) }})</h4>
          </div>
          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce">
              <thead>
                <tr>
                  <th>Nomenclatura</th>
                  <th>Base</th>
                  <th style="width:120px;">Estado</th>
                  <th style="width:20px;"></th>
                </tr>
              </thead>
              <tbody>
@foreach($participaciones_por_vencer as $v)
                <tr>
                  <td class="">
                    <div style="font-size:11px;">{!! $v->inx_rotulo !!}</div>
                    <div style="font-size:9px;">Aprobado el {{ Helper::fecha($v->aprobado_fecha, true) }} por {{ $v->aprobado_usuario }}</div>
                  </td>
                  <td class="text-center" style="width:100px;">
                    <span>{{ Helper::money($v->monto_base) }}</span>
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_participacion()['class'] }}">{{ $v->estado_participacion()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->fecha_participacion_hasta, true) }}</div>
                    <div style="font-size:10px;">{{ $v->etiquetas }}</div>
                  </td>
                  <td class="text-center" style="width:20px;">
                    <a href="/licitaciones/{{ $v->licitacion_id }}/detalles">
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
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Propuestas por Vencer ({{ count($propuestas_por_vencer) }})</h4>
          </div>
          <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce">
              <thead>
                <tr>
                  <th>Nomenclatura</th>
                  <th>Base</th>
                  <th style="width:120px;">Estado</th>
                  <th style="width:20px;"></th>
                </tr>
              </thead>
              <tbody>
@foreach($propuestas_por_vencer as $v)
                <tr>
                  <td class="">
                    <div style="font-size:11px;">{!! $v->inx_rotulo !!}</div>
                    <div style="font-size:9px;">Aprobado el {{ Helper::fecha($v->aprobado_fecha, true) }} por {{ $v->aprobado_usuario }}</div>
                  </td>
                  <td class="text-center" style="width:100px;">
                    <span>{{ Helper::money($v->monto_base) }}</span>
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_propuesta()['class'] }}">{{ $v->estado_propuesta()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->fecha_propuesta_hasta, true) }}</div>
                    <div style="font-size:10px;">{{ $v->etiquetas }}</div>
                  </td>
                  <td class="text-center" style="width:20px;">
                    <a href="/licitaciones/{{ $v->licitacion_id }}/detalles">
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
<!-- Dashboard Ecommerce ends -->
      <!-- Task Card Starts -->
      <div class="col-xl-6 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Buenas Pro ({{ count($propuestas_en_pro) }})</h4>
          </div>
         <div class="table-responsive" style="padding: 0 15px;">
            <table class="table table-striped table-reduce">
              <thead>
                <tr>
                  <th>Nomenclatura</th>
                  <th style="width:120px;">Estado</th>
                  <th>Ganadora</th>
                  <th>Condición</th>
                  <th style="width:20px;"></th>
                </tr>
              </thead>
              <tbody>
@foreach($propuestas_en_pro as $v)
                <tr>
                  <td title="{{ $v->rotulo() }}">
                    {!! $v->nomenclatura !!}
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_pro()['class'] }}">{{ $v->estado_pro()['message'] }}</span>
                  </td>
                  <td>
                    {!! $v->ganadora() !!}
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span>{{ $v->render_estado() }}</span>
                  </td>
                  <td class="text-center" style="width:20px;">
                    <a href="/licitaciones/{{ $v->licitacion_id }}/detalles">
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
  </section>
  <!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
