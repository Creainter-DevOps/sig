@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard Analytics')
{{-- venodr style --}}
@section('vendor-styles')
<!--<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">-->
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">-->
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
    <!-- Radial Followers Primary Chart Starts -->
    <div class="col-sm-4">
      <div class="card">
        <div class="card-content">
          <div class="card-body p-0">
            <div class="d-lg-flex justify-content-between">
              <div class="widget-card-details d-flex flex-column justify-content-between p-2">
                <div>
                  <h5 class="font-medium-2 font-weight-normal">Oportunidades</h5>
                  <p class="text-muted">Actualmente tiene {{ $oportunidades->usado }} de {{ $oportunidades->limite }} oportunidades en la que puede participar en simultáneo.</p>
                </div>
              </div>
              <div id="radial-chart-primary"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Radial Followers Primary Chart Ends -->
    <!-- Radial Users Success Chart Starts -->
    <div class="col-sm-4">
      <div class="card">
        <div class="card-content">
          <div class="card-body p-0">
            <div class="d-lg-flex justify-content-between">
              <div class="widget-card-details d-flex flex-column justify-content-between p-2">
                <div>
                  <h5 class="font-medium-2 font-weight-normal">Etiquetas</h5>
                  <p class="text-muted">Actualmente tiene {{ $etiquetas->usado_total }} de {{ $etiquetas->limite_total }} permitidas para su cuenta.</p>
                </div>
              </div>
              <div id="radial-chart-success"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Radial Users Success Chart Ends -->
    <!-- Radial Registrations Danger Chart Starts -->
    <div class="col-sm-4">
      <div class="card">
        <div class="card-content">
          <div class="card-body p-0">
            <div class="d-lg-flex justify-content-between">
              <div class="widget-card-details d-flex flex-column justify-content-between p-2">
                <div>
                  <h5 class="font-medium-2 font-weight-normal">Empresa</h5>
                  <p class="text-muted">Actualmente tiene {{ $empresas->usado }} de {{ $empresas->limite }} empresa(s) registrada(s).</p>
                </div>
              </div>
              <div id="radial-chart-danger"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Radial Registrations Danger Chart Ends -->
    </div>
    <div class="row">
      <!-- Website Analytics Starts-->
    <div class="col-lg-3 col-md-3 col-12 mb-3">
    <div class="card" style="height:250px;">
      <div class="card-header">
        <h3 class="card-title mb-1">Bienvenido {{ '@' . Auth::user()->usuario }}!</h3>
        <span class="d-block text-nowrap">Tenemos una meta para esta semana</span>
      </div>
      <div class="card-body">
        <div class="row align-items-end">
          <div class="col-6">
            <h1 class="display-6 text-primary">{{ (int) ($chartjs['usuario']->enviados_semana * 100 / 150) }}%</h1>
            <small class="d-block mb-1">Nos falta poco para lograr nuestra meta, hemos enviado {{ $chartjs['usuario']->enviados_semana }}.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
        <!-- Sales Chart Starts-->
      <div class="col-xl-3 col-lg-3 col-md-6 col-12 sales-card">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title-content">
              <h4 class="card-title">Números</h4>
              <small class="text-muted">Calculado en lo que va del año</small>
            </div>
            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="d-flex justify-content-between my-1">
                <div class="sales-info d-flex align-items-center">
                  <i class='bx bx-bar-chart-alt-2 text-primary font-medium-5 mr-50'></i>
                  <div class="sales-info-content">
                    <h6 class="mb-0">Elaborados</h6>
                    <small class="text-muted">Expedientes elaborados</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ $chartjs['usuario']->elaborados }}</h6>
              </div>
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
                    <h6 class="mb-0">Monto Bruto</h6>
                    <small class="text-muted">Monto recaudado</small>
                  </div>
                </div>
                <h6 class="mb-0">{{ Helper::money($chartjs['usuario']->monto, 1) }}</h6>
              </div>-->
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 dashboard-latest-update">
          <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center pb-50">
            <h4 class="card-title">Atención en Licitaciones</h4>
          </div>
          <div class="card-content">
            <div class="card-body p-0 pb-1">
              <ul class="list-group list-group-flush">
                @foreach(App\Oportunidad::requiere_atencion($execute) as $o)
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
                      <small class="text-muted d-block">{{ strtoupper(substr($o->licitacion_rotulo,0, 17)) }}</small>
                    </div>
                  </div>
                  <span class="{{ $o->estado()['class'] }}">{{ $o->estado()['message'] }}</span>
                </li>
               @endforeach
              </ul>
            </div>
            <div style="text-align:right;font-size:11px;padding: 0 5px;">Tiempo de consulta: {{ $execute->time }} ms</div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 dashboard-latest-update">
          <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center pb-50">
            <h4 class="card-title">Facturación</h4>
          </div>
          <div class="card-content">
            <div class="card-body p-0 pb-1">
            @if(count($res = App\User::facturas_visibles($execute)) == 0)
              <div style="text-align:center;padding:30px;">Usted se encuentra al día</div>
            @else
              <ul class="list-group list-group-flush">
                @foreach($res as $o)
                <li
                  class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                  <div class="list-left d-flex">
                    <div class="list-icon mr-1">
                      <div class="avatar bg-rgba-success m-0">
                        <div class="avatar-content">
                          <i class="bx bx-money text-success font-size-base"></i>
                        </div>
                      </div>
                    </div>
                    <div class="list-content">
                      <span class="list-title">{{ Helper::fecha($o->fecha_vencimiento) }}</span>
                      <small class="text-muted d-block">{{ $o->rotulo }}</small>
                    </div>
                  </div>
                  @if(!empty($o->es_pagado))
                  <span class="text-success" title="Monto abonado: {{ $o->monto_pagado }} - A favor: {{ $o->saldo_a_favor }}">{{ Helper::money($o->monto) }}</span>
                  @else
                  <span class="text-danger" title="Monto abonado: {{ $o->monto_pagado }} - A favor: {{ $o->saldo_a_favor }}">{{ Helper::money($o->monto) }}</span>
                  @endif
                </li>
               @endforeach
              </ul>
            @endif
            </div>
            <div style="text-align:right;font-size:11px;padding: 0 5px;">Tiempo de consulta: {{ $execute->time }} ms</div>
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
            <div class="col-12">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">PROXIMOS PAGOS</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table" style="font-size:12px;">
              <thead>
                <tr>
                  <th style="width:180px;">Codigo</th>
                  <th>Rotulo</th>
                  <th style="width:120px;">Fecha</th>
                  <th style="width:200px;">Monto</th>
                  <th style="width:200px;">Soles</th>
                </tr>
              </thead>
              <tbody>
@foreach(App\Contable::proximos_pagos() as $n)
                <tr>
                  <td class="py-1"><a href="{{ route('proyectos.show', ['proyecto' => $n->proyecto_id ]) }}">{{ $n->codigo }}</a> Cuota #{{ $n->numero }}</td>
                  <td class="py-1">{{ $n->rotulo }}</td>
                  <td class="py-1">{{ Helper::fecha($n->fecha) }}</td>
                  <td class="py-1">{{ Helper::money($n->monto, $n->moneda_id) }}</td>
                  <td class="py-1">{{ Helper::money($n->soles) }}</td>
                </tr>
@endforeach
              </tbody>
            </table>
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
      <!-- Profit Report Card Starts-->
      <!-- Growth Chart Starts-->
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
$(document).ready(function () {

  var $primary = '#5A8DEE';
  var $success = '#39DA8A';
  var $danger = '#FF5B5C';
  var $warning = '#FDAC41';
  var $info = '#00CFDD';
  var $label_color = '#304156';
  var $danger_light = '#FFDEDE';
  var $gray_light = '#828D99';
  var $bg_light = "#f2f4f4";

  // Radial Followers Chart - Primary
  // --------------------------------
  var radialPrimaryoptions = {
    chart: {
      height: 250,
      type: "radialBar"
    },
    series: [{{ (int) ($oportunidades->usado * 100 / $oportunidades->limite) }}],
    plotOptions: {
      radialBar: {
        offsetY: -10,
        size: 70,
        hollow: {
          size: "70%"
        },
        dataLabels: {
          showOn: "always",
          name: {
            show: false
          },
          value: {
            colors: [$label_color],
            fontSize: "20px",
            show: true,
            offsetY: 8,
            fontFamily: "Rubik"
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    }
  };
  var radialPrimaryChart = new ApexCharts(
    document.querySelector("#radial-chart-primary"),
    radialPrimaryoptions
  );

  radialPrimaryChart.render();

    var radialSuccessoptions = {
    chart: {
      height: 250,
      type: "radialBar"
    },
    series: [{{ (int) ($etiquetas->usado_total * 100 / $etiquetas->limite_total) }}],
    colors: [$success],
    plotOptions: {
      radialBar: {
        offsetY: -10,
        size: 70,
        hollow: {
          size: "70%"
        },

        dataLabels: {
          showOn: "always",
          name: {
            show: false
          },
          value: {
            colors: [$label_color],
            fontSize: "20px",
            show: true,
            offsetY: 8,
            fontFamily: "Rubik"
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    }
  };
  var radialSuccessChart = new ApexCharts(
    document.querySelector("#radial-chart-success"),
    radialSuccessoptions
  );

  radialSuccessChart.render();

    var radialDangeroptions = {
    chart: {
      height: 250,
      type: "radialBar"
    },
    series: [{{ (int) ($empresas->usado * 100 / $empresas->limite) }}],
    colors: [$danger],
    plotOptions: {
      radialBar: {
        offsetY: -10,
        size: 70,
        hollow: {
          size: "70%"
        },

        dataLabels: {
          showOn: "always",
          name: {
            show: false
          },
          value: {
            colors: [$label_color],
            fontSize: "20px",
            show: true,
            offsetY: 8,
            fontFamily: "Rubik"
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    }
  };
  var radialDangerChart = new ApexCharts(
    document.querySelector("#radial-chart-danger"),
    radialDangeroptions
  );
  radialDangerChart.render();
});
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

