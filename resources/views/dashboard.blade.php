@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard Analytics')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/clndr.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row">
      <!-- Website Analytics Starts-->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
    <div class="card h-75">
      <div class="card-header">
        <h3 class="card-title mb-1">Bienvenido {{ '@' . Auth::user()->usuario }}!</h3>
        <span class="d-block text-nowrap">Tenemos una meta para esta semana</span>
      </div>
      <div class="card-body">
        <div class="row align-items-end">
          <div class="col-6">
            <h1 class="display-6 text-primary">10%</h1>
            <small class="d-block mb-1">Nos falta poco para lograr nuestra meta.</small>
            <a href="javascript:;" class="btn btn-sm btn-primary">View sales</a>
          </div>
        </div>
      </div>
    </div>
  </div>
        <!-- Sales Chart Starts-->
      <div class="col-xl-3 col-md-6 col-12 sales-card">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title-content">
              <h4 class="card-title">Ingresos</h4>
              <small class="text-muted">Calculado en lo que va del mes</small>
            </div>
            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="d-flex justify-content-between my-1">
                <div class="sales-info d-flex align-items-center">
                  <i class='bx bx-bar-chart-alt-2 text-primary font-medium-5 mr-50'></i>
                  <div class="sales-info-content">
                    <h6 class="mb-0">Enviados</h6>
                    <small class="text-muted">Expedientes enviados</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ $chartjs['usuario']->enviados }}</h6>
              </div>
              <div class="d-flex justify-content-between my-1">
                <div class="sales-info d-flex align-items-center">
                  <i class='bx bx-check text-primary font-medium-5 mr-50'></i>
                  <div class="sales-info-content">
                    <h6 class="mb-0">Ganados</h6>
                    <small class="text-muted">Oportunidades Ganadas</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ $chartjs['usuario']->ganados }}</h6>
              </div>
              <!--<div class="d-flex justify-content-between my-1">
                <div class="sales-info d-flex align-items-center">
                  <i class='bx bx-dollar text-primary font-medium-5 mr-50'></i>
                  <div class="sales-info-content">
                    <h6 class="mb-0">Recaudado por Enviados</h6>
                    <small class="text-muted">Comisión de S/. 11</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ Helper::money($chartjs['usuario']->sueldo_enviados, 1) }}</h6>
              </div>
              <div class="d-flex justify-content-between my-1">
                <div class="sales-info d-flex align-items-center">
                  <i class='bx bx-dollar text-primary font-medium-5 mr-50'></i>
                  <div class="sales-info-content">
                    <h6 class="mb-0">Recaudado por Ganados</h6>
                    <small class="text-muted">Comisión de S/.300</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ Helper::money($chartjs['usuario']->sueldo_ganados, 1) }}</h6>
              </div>
              <div class="d-flex justify-content-between my-1">
                <div class="sales-info d-flex align-items-center">
                  <i class='bx bx-dollar text-primary font-medium-5 mr-50'></i>
                  <div class="sales-info-content">
                    <h6 class="mb-0">Recaudado por Monto</h6>
                    <small class="text-muted">Comisión de S/.300</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ Helper::money($chartjs['usuario']->sueldo_monto, 1) }}</h6>
              </div>-->
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 col-sm-12 dashboard-referral-impression">
        <div class="row">
          <!-- Referral Chart Starts-->
          <div class="col-xl-12 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body text-center pb-0">
                  <h2>$32,690</h2>
                  <span class="text-muted">Referral</span> 40%
                  <div id="success-line-chart"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- Impression Radial Chart Starts-->
          <div class="col-xl-12 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body donut-chart-wrapper">
                  <div id="donut-chart" class="d-flex justify-content-center"></div>
                  <ul class="list-inline d-flex justify-content-around mb-0">
                    <li> <span class="bullet bullet-xs bullet-warning mr-50"></span>Search</li>
                    <li> <span class="bullet bullet-xs bullet-info mr-50"></span>Email</li>
                    <li> <span class="bullet bullet-xs bullet-primary mr-50"></span>Social</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-12 col-sm-12 dashboard-latest-update">
          <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center pb-50">
            <h4 class="card-title">Atención en Licitaciones</h4>
          </div>
          <div class="card-content">
            <div class="card-body p-0 pb-1">
              <ul class="list-group list-group-flush">
                @foreach(App\Oportunidad::requiere_atencion() as $o)
                <li
                  class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                  <div class="list-left d-flex">
                    <div class="list-icon mr-1">
                      <div class="avatar bg-rgba-primary m-0">
                        <div class="avatar-content">
                          <i class="bx bxs-zap text-primary font-size-base"></i>
                        </div>
                      </div>
                    </div>
                    <div class="list-content">
                      <span class="list-title"><a href="/licitaciones/{{ $o->licitacion_id }}/detalles">{{ $o->codigo }}</a></span>
                      <small class="text-muted d-block">{{ strtoupper(substr($o->licitacion()->rotulo(),0, 17)) }}</small>
                    </div>
                  </div>
                  <span class="{{ $o->estado()['class'] }}">{{ $o->estado()['message'] }}</span>
                </li>
               @endforeach
              </ul>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="row">
          <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Oportunidades</h4>
            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
          </div>
          <div class="card-content">
            <div class="card-body pb-1">
              <canvas id="line-chart-1" style="width:100%;max-height:400px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body text-center pb-0" style="position: relative;">
              <canvas id="line-chart-2" style="width:100%;max-height:400px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!-- aCTIVITY-->
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
      <!-- Activity Card Starts-->
      <div class="col-xl-3 col-md-6 col-12 activity-card">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Activity</h4>
          </div>
          <div class="card-content">
            <div class="card-body pt-1">
              <div class="d-flex activity-content">
                <div class="avatar bg-rgba-primary m-0 mr-75">
                  <div class="avatar-content">
                    <i class="bx bx-bar-chart-alt-2 text-primary"></i>
                  </div>
                </div>
                <div class="activity-progress flex-grow-1">
                  <small class="text-muted d-inline-block mb-50">Total Sales</small>
                  <small class="float-right">$8,125</small>
                  <div class="progress progress-bar-primary progress-sm">
                    <div class="progress-bar" role="progressbar" aria-valuenow="50" style="width:50%"></div>
                  </div>
                </div>
              </div>
              <div class="d-flex activity-content">
                <div class="avatar bg-rgba-success m-0 mr-75">
                  <div class="avatar-content">
                    <i class="bx bx-dollar text-success"></i>
                  </div>
                </div>
                <div class="activity-progress flex-grow-1">
                  <small class="text-muted d-inline-block mb-50">Income Amount</small>
                  <small class="float-right">$18,963</small>
                  <div class="progress progress-bar-success progress-sm">
                    <div class="progress-bar" role="progressbar" aria-valuenow="80" style="width:80%"></div>
                  </div>
                </div>
              </div>
              <div class="d-flex activity-content">
                <div class="avatar bg-rgba-warning m-0 mr-75">
                  <div class="avatar-content">
                    <i class="bx bx-stats text-warning"></i>
                  </div>
                </div>
                <div class="activity-progress flex-grow-1">
                  <small class="text-muted d-inline-block mb-50">Total Budget</small>
                  <small class="float-right">$14,150</small>
                  <div class="progress progress-bar-warning progress-sm">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" style="width:60%"></div>
                  </div>
                </div>
              </div>
              <div class="d-flex mb-75">
                <div class="avatar bg-rgba-danger m-0 mr-75">
                  <div class="avatar-content">
                    <i class="bx bx-check text-danger"></i>
                  </div>
                </div>
                <div class="activity-progress flex-grow-1">
                  <small class="text-muted d-inline-block mb-50">Completed Tasks</small>
                  <small class="float-right">106</small>
                  <div class="progress progress-bar-danger progress-sm">
                    <div class="progress-bar" role="progressbar" aria-valuenow="30" style="width:30%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Profit Report Card Starts-->
      <div class="col-xl-3 col-md-6 col-12 profit-report-card">
        <div class="row">
          <div class="col-md-12 col-sm-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Profit Report</h4>
                <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
              </div>
              <div class="card-content">
                <div class="card-body pb-0 d-flex justify-content-around">
                  <div class="d-inline-flex mr-xl-2">
                    <div id="profit-primary-chart"></div>
                    <div class="profit-content ml-50 mt-50">
                      <h5 class="mb-0">$12k</h5>
                      <small class="text-muted">2019</small>
                    </div>
                  </div>
                  <div class="d-inline-flex">
                    <div id="profit-info-chart"></div>
                    <div class="profit-content ml-50 mt-50">
                      <h5 class="mb-0">$64k</h5>
                      <small class="text-muted">2019</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Registrations</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <div class="d-flex align-items-end justify-content-around">
                    <div class="registration-content mr-xl-2">
                      <h4 class="mb-0">56.3k</h4>
                      <i class="bx bx-trending-up success align-middle"></i>
                      <span class="text-success">12.8%</span>
                    </div>
                    <div id="registration-chart"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Growth Chart Starts-->
      <div class="col-xl-3 col-md-6 col-12 growth-card">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButtonSec"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                2019
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSec">
                <a class="dropdown-item" href="#">2019</a>
                <a class="dropdown-item" href="#">2018</a>
                <a class="dropdown-item" href="#">2017</a>
              </div>
            </div>
            <div id="growth-Chart"></div>
            <h6 class="mb-0"> 62% Company Growth in 2019</h6>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/chart.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="{{asset('vendors/js/calendar/clndr.js')}}"></script>
<script type="module" src="{{asset('vendors/js/calendar/moment.js')}}"></script>
@endsection

@section('page-scripts')
@parent
<script>
  var events = {!! json_encode($actividades) !!};
</script>
<script src="{{asset('js/scripts/clndr.js')}}"></script>
<script src="{{asset('js/scripts/pages/dashboard-analytics.js')}}"></script>
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

