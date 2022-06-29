@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Categories')
{{-- page-styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
@endsection
@section('custom-css')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-knowledge-base.css')}}">
@endsection
@section('content')
<!-- Knowledge base categories Content start  -->
<section class="kb-categories">
  <div class="row">
    <!-- left side menubar section -->
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Licitaciones: Aprobadas - desarprobadas</h4>
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
              <div id="analytics-bar-chart"></div>
            </div>
          </div>
        </div>

<!--      <div class="kb-sidebar">
        <i class="bx bx-x font-medium-5 d-md-none kb-close-icon cursor-pointer"></i>
        <h6 class="mb-2">Usuarios</h6>
        <form method="get" action ="/reportes/usuarios/descargar" id="formReporte" >
          <input hidden value="usuario" name="reporte" >
          <div class="form-group">
            <label for="inputAddress">Fecha Desde</label>
            <input type="date" name="fecha_desde" class="form-control" id="inputAddress" placeholder="1234 Main St">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Fecha Hasta</label>
            <input type="date" name="fecha_hasta" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" >
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputState">State</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="inputState">Formato</label>
              <select id="inputState" class="form-control" name="formato">
                <option selected value="pdf">PDF</option>
                <option value="excel" >Excel</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>
          <button class="btn btn-primary" >Generar</button>
        </form>
      </div>-->
    <!-- right side section -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <div id ="donut-chart"></div>
        </div>
      </div>
    <div>
  </div>
</section>
<!-- Knowledge base categories Content ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-knowledge-base.js')}}"></script>
<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>
<script>

  document.addEventListener('swiped-left', function(e) {
      console.log(e.target); // the element that was swiped
      alert("left");
  });

  document.addEventListener('swiped-right', function(e) {
      console.log(e.target); // the element that was swiped
      alert("right");
  });

 var $primary = '#5A8DEE';
  var $success = '#39DA8A';
  var $danger = '#FF5B5C';
  var $warning = '#FDAC41';
  var $info = '#00CFDD';
  var $label_color = '#475f7b';
  var $primary_light = '#E2ECFF';
  var $danger_light = '#ffeed9';
  var $gray_light = '#828D99';
  var $sub_label_color = "#596778";
  var $radial_bg = "#e7edf3";

 var analyticsBarChartOptions = {
    chart: {
      height: 260,
      type: 'bar',
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '20%',
        endingShape: 'rounded'
      },
    },
    legend: {
      horizontalAlign: 'right',
      offsetY: -10,
      markers: {
        radius: 50,
        height: 8,
        width: 8
      }
    },
    dataLabels: {
      enabled:false
    },
    colors: [$primary, $danger_light],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'light',
        type: "vertical",
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 50, 100]
      },
    },
    /*series: [{
     name: '2019',
      data: [80, 95, 150, 210, 140, 230, 300, 280, 130]
    }, {
      name: '2018',
      data: [50, 70, 130, 180, 90, 180, 270, 220, 110]
    }],*/
    series:   {!! $data_chart !!},
    xaxis: {
      categories: {!!  $data_categorias  !!} ,
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      labels: {
        style: {
          colors: $gray_light
        }
      }
    },
    yaxis: {
      min: 0,
      max: 50,
      tickAmount: 3,
      labels: {
        style: {
          color: $gray_light
        }
      }
    },
    legend: {
      show: true
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return " " + val + " Licitaciones"
        }
      }
    }
  }

   var analyticsBarChart = new ApexCharts(
    document.querySelector("#analytics-bar-chart"),
    analyticsBarChartOptions
  );

  analyticsBarChart.render();

   // Donut Chart
  // ---------------------
  var donutChartOption = {
    chart: {
      width: 400,
      type: 'donut',
    },
    dataLabels: {
      enabled: false
    },
    //series: [80, 30, 60],
   // labels: ["Social", "Email", "Search"],
   {!!substr(   substr( $data_pie ,1), 0, -1 ) !!},
    stroke: {
      width: 0,
      lineCap: 'round',
    },
    colors: [$primary, $info, $warning,$success,$danger, $primary_light,$danger_light ],
    plotOptions: {
      pie: {
        donut: {
          size: '90%',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '15px',
              colors: $sub_label_color,
              offsetY: 40,
              fontFamily: 'IBM Plex Sans',
            },
            value: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Rubik',
              color: $label_color,
              offsetY: -40,
              formatter: function (val) {
                return val
              }
            }, total: {
              show: true,
              label: 'Actividades',
              color: $gray_light,
              formatter: function (w) {
                return w.globals.seriesTotals.reduce(function (a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    legend: {
      show: false
    }
  }

  var donutChart = new ApexCharts(
    document.querySelector("#donut-chart"),
    donutChartOption
  );

  donutChart.render();


  /*function reporte(e){
    e.preventDefault();
  }
  let formReporte = document.getElementById('formReporte');
  formReporte.addEventListener( 'submit',(e) => {

    e.preventDefault();
    var action = document.getElementById('formReporte').action;     
    console.log(action); 
    let formData = new FormData(formReporte);
    let parameters = '?';
    for(const pair of formData.entries()) {
      parameters +=`${pair[0]}=${pair[1]}&`;
    }
    console.log(parameters);
    reportPreview.src = action + parameters;   
    reportPreview.removeAttribute('hidden');

  })*/
  
</script>
@endsection
