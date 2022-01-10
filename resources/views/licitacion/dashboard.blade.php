@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard Analytics')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/chart.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
@endsection

@section('page-scripts')
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

  var lineChartctx = $("#line-chart-1");
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
  var linechartData = {
    labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
    datasets: [{
      label: "Africa",
      data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478],
      borderColor: $primary,
      fill: false
    }, {
      data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
      label: "Asia",
      borderColor: $success,
      fill: false
    }, {
      data: [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
      label: "Europe",
      borderColor: $danger,
      fill: false
    }, {
      data: [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
      label: "Latin America",
      borderColor: $warning,
      fill: false
    }, {
      data: [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
      label: "North America",
      borderColor: $label_color,
      fill: false
    }]
  };
  var lineChartconfig = {
    type: 'line',
    options: linechartOptions,
    data: linechartData
  };
  lineChartconfig = {!! json_encode($chartjs['barras']) !!};
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
      text: 'World population per region (in millions)'
    }
  };
  var lineChart = new Chart(lineChartctx, lineChartconfig);

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
      <div class="col-xl-3 col-md-12 col-sm-12">
        <div class="row">
          <!-- Conversion Chart Starts-->
          <div class="col-xl-12 col-md-6 col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between pb-xl-0 pt-xl-1">
                <div class="conversion-title">
                  <h4 class="card-title">Conversion</h4>
                  <p>60%
                    <i class="bx bx-trending-up text-success font-size-small align-middle mr-25"></i>
                  </p>
                </div>
                <div class="conversion-rate">
                  <h2>89k</h2>
                </div>
              </div>
              <div class="card-content">
                <div class="card-body text-center">
                  <div id="bar-negative-chart"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-12 col-md-6 col-12">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                        <div class="avatar-content">
                          <i class="bx bx-user text-primary font-medium-2"></i>
                        </div>
                      </div>
                      <div class="total-amount">
                        <h5 class="mb-0">$38,566</h5>
                        <small class="text-muted">Conversion</small>
                      </div>
                    </div>
                    <div id="primary-line-chart"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <div class="avatar bg-rgba-warning m-0 p-25 mr-75 mr-xl-2">
                        <div class="avatar-content">
                          <i class="bx bx-dollar text-warning font-medium-2"></i>
                        </div>
                      </div>
                      <div class="total-amount">
                        <h5 class="mb-0">$53,659</h5>
                        <small class="text-muted">Income</small>
                      </div>
                    </div>
                    <div id="warning-line-chart"></div>
                  </div>
                </div>
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
                    {!! $v->rotulo() !!}
                  </td>
                  <td class="text-center" style="width:100px;">
                    <span>{{ Helper::money($v->monto_base) }}</span>
                    <div style="font-size: 10px;">({{ $v->timeline()->count() }} obs.)</div>
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_participacion()['class'] }}">{{ $v->estado_participacion()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->licitacion()->fecha_participacion_hasta, true) }}</div>
                    <div style="font-size:11px;">{{ $v->cantidad_participadas }} de {{ $v->cantidad_interes }}</div>
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
                    {!! $v->rotulo() !!}
                  </td>
                  <td class="text-center" style="width:100px;">
                    <span>{{ Helper::money($v->monto_base) }}</span>
                    <div style="font-size: 10px;">({{ $v->timeline()->count() }} obs.)</div>
                  </td>
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_propuesta()['class'] }}">{{ $v->estado_propuesta()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->licitacion()->fecha_propuesta_hasta, true) }}</div>
                    <div style="font-size:11px;">{{ $v->cantidad_propuestas }} de {{ $v->cantidad_participadas }}</div>
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
                  <th>Condición</th>
                  <th style="width:20px;"></th>
                </tr>
              </thead>
              <tbody>
@foreach($propuestas_en_pro as $v)
                <tr>
                  <td>
                    {!! $v->rotulo() !!}
                  </td>
                  <!--<td class="text-center" style="width:120px;">
                    <span>{{ Helper::money($v->monto_base) }}</span>
                    <div style="font-size: 10px;">({{ $v->timeline()->count() }} obs.)</div>
                  </td>-->
                  <td class="text-center" style="width:120px;">
                    <span class="{{ $v->estado_pro()['class'] }}">{{ $v->estado_pro()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->licitacion()->buenapro_fecha, true) }}</div>
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


      <div class="col-lg-6">
        <div class="row">
          <div class="col-12">
            <div class="card widget-todo">
              <div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="card-title d-flex mb-25 mb-sm-0">
                  <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Tasks
                </h4>
                <ul class="list-inline d-flex mb-25 mb-sm-0">
                  <li class="d-flex align-items-center">
                    <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                    <div class="dropdown">
                      <div class="dropdown-toggle mr-1 cursor-pointer" role="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Task
                      </div>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Option 1</a>
                        <a class="dropdown-item" href="#">Option 2</a>
                        <a class="dropdown-item" href="#">Option 3</a>
                      </div>
                    </div>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class='bx bx-sort mr-50 font-medium-3'></i>
                    <div class="dropdown">
                      <div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Task</div>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <a class="dropdown-item" href="#">Option 1</a>
                        <a class="dropdown-item" href="#">Option 2</a>
                        <a class="dropdown-item" href="#">Option 3</a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="card-body px-0 py-1">
                <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                  <li class="widget-todo-item">
                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                      <div class="widget-todo-title-area d-flex align-items-center">
                        <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                        <div class="checkbox checkbox-shadow">
                          <input type="checkbox" class="checkbox__input" id="checkbox1">
                          <label for="checkbox1"></label>
                        </div>
                        <span class="widget-todo-title ml-50">Add SCSS and JS files if required</span>
                      </div>
                      <div class="widget-todo-item-action d-flex align-items-center">
                        <div class="badge badge-pill badge-light-success mr-1">frontend</div>
                        <div class="avatar bg-rgba-primary m-0 mr-50">
                          <div class="avatar-content">
                            <span class="font-size-base text-primary">RA</span>
                          </div>
                        </div>
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="widget-todo-item">
                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                      <div class="widget-todo-title-area d-flex align-items-center">
                        <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                        <div class="checkbox checkbox-shadow">
                          <input type="checkbox" class="checkbox__input" id="checkbox2">
                          <label for="checkbox2"></label>
                        </div>
                        <span class="widget-todo-title ml-50">Check your changes, before commiting</span>
                      </div>
                      <div class="widget-todo-item-action d-flex align-items-center">
                        <div class="badge badge-pill badge-light-danger mr-1">backend</div>
                        <div class="avatar m-0 mr-50">
                          <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                            height="32" width="32">
                        </div>
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="widget-todo-item completed">
                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                      <div class="widget-todo-title-area d-flex align-items-center">
                        <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                        <div class="checkbox checkbox-shadow">
                          <input type="checkbox" class="checkbox__input" id="checkbox3" checked>
                          <label for="checkbox3"></label>
                        </div>
                        <span class="widget-todo-title ml-50">Dribble, Behance, UpLabs & Pinterest Post</span>
                      </div>
                      <div class="widget-todo-item-action d-flex align-items-center">
                        <div class="badge badge-pill badge-light-primary mr-1">UI/UX</div>
                        <div class="avatar bg-rgba-primary m-0 mr-50">
                          <div class="avatar-content">
                            <span class="font-size-base text-primary">JP</span>
                          </div>
                        </div>
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="widget-todo-item">
                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                      <div class="widget-todo-title-area d-flex align-items-center">
                        <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                        <div class="checkbox checkbox-shadow">
                          <input type="checkbox" class="checkbox__input" id="checkbox4">
                          <label for="checkbox4"></label>
                        </div>
                        <span class="widget-todo-title ml-50">Fresh Design Web & Responsive Miracle</span>
                      </div>
                      <div class="widget-todo-item-action d-flex align-items-center">
                        <div class="badge badge-pill badge-light-info mr-1">Design</div>
                        <div class="avatar m-0 mr-50">
                          <img src="{{asset('images/profile/user-uploads/user-05.jpg')}}" alt="img placeholder"
                            height="32" width="32">
                        </div>
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="widget-todo-item">
                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                      <div class="widget-todo-title-area d-flex align-items-center">
                        <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                        <div class="checkbox checkbox-shadow">
                          <input type="checkbox" class="checkbox__input" id="checkbox5">
                          <label for="checkbox5"></label>
                        </div>
                        <span class="widget-todo-title ml-50">Add Calendar page, source, credit page in
                          documentation</span>
                      </div>
                      <div class="widget-todo-item-action d-flex align-items-center">
                        <div class="badge badge-pill badge-light-warning mr-1">Javascript</div>
                        <div class="avatar bg-rgba-primary m-0 mr-50">
                          <div class="avatar-content">
                            <span class="font-size-base text-primary">AK</span>
                          </div>
                        </div>
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="widget-todo-item">
                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                      <div class="widget-todo-title-area d-flex align-items-center">
                        <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                        <div class="checkbox checkbox-shadow">
                          <input type="checkbox" class="checkbox__input" id="checkbox6">
                          <label for="checkbox6"></label>
                        </div>
                        <span class="widget-todo-title ml-50">Add Angular Starter-kit</span>
                      </div>
                      <div class="widget-todo-item-action d-flex align-items-center">
                        <div class="badge badge-pill badge-light-primary mr-1">UI/UX</div>
                        <div class="avatar m-0 mr-50">
                          <img src="{{asset('images/profile/user-uploads/user-05.jpg')}}" alt="img placeholder"
                            height="32" width="32">
                        </div>
                        <div class="dropdown">
                          <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Daily Financials Card Starts -->
      <div class="col-lg-5">
        <div class="card ">
          <div class="card-header">
            <h4 class="card-title">
              Order Timeline
            </h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <ul class="widget-timeline mb-0">
                <li class="timeline-items timeline-icon-primary active">
                  <div class="timeline-time">September, 16</div>
                  <h6 class="timeline-title">1983, orders, $4220</h6>
                  <p class="timeline-text">2 hours ago</p>
                  <div class="timeline-content">
                    <img src="{{asset('images/icon/pdf.png')}}" alt="document" height="23" width="19"
                      class="mr-50">New Order.pdf
                  </div>
                </li>
                <li class="timeline-items timeline-icon-primary active">
                  <div class="timeline-time">September, 17</div>
                  <h6 class="timeline-title">12 Invoices have been paid</h6>
                  <p class="timeline-text">25 minutes ago</p>
                  <div class="timeline-content">
                    <img src="{{asset('images/icon/pdf.png')}}" alt="document" height="23" width="19"
                      class="mr-50">Invoices.pdf
                  </div>
                </li>
                <li class="timeline-items timeline-icon-primary active pb-0">
                  <div class="timeline-time">September, 18</div>
                  <h6 class="timeline-title">Order #37745 from September</h6>
                  <p class="timeline-text">4 minutes ago</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
