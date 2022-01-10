@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Dashboard Ecommerce')
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
    <div class="row">
      <div class="col-6">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Reporte01</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
              <thead>
                <tr>
                  <th>Año</th>
                  <th>Cuentas Cobradas</th>
                  <th>Cuentas Pendientes</th>
                  <th>Cuentas por Cobrar</th>
                </tr>
              </thead>
              <tbody>
@foreach(App\Contable::cobros_por_anho() as $n)
                <tr>
                  <td class="py-1">{{ $n->anho }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_cobradas) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_pendientes) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_cobrar) }}</td>
                </tr>
@endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">PAGO POR EMPRESAS</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
              <thead>
                <tr>
                  <th>Empresa</th>
                  <th>Cuentas Cobradas</th>
                  <th>Cuentas Pendientes</th>
                  <th>Cuentas por Cobrar</th>
                </tr>
              </thead>
              <tbody>
@foreach(App\Contable::pago_por_empresas() as $n)
                <tr>
                  <td class="py-1">{{ $n->nomenclatura }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_cobradas) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_pendientes) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_cobrar) }}</td>
                </tr>
@endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Cuentas por cobrar POR AÑO</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
              <thead>
                <tr>
                  <th>Año</th>
                  <th>Empresa</th>
                  <th>Cuentas Cobradas</th>
                  <th>Cuentas Pendientes</th>
                  <th>Cuentas por Cobrar</th>
                </tr>
              </thead>
              <tbody>
@foreach(App\Contable::cobro_por_empresas_anho() as $n)
                <tr>
                  <td class="py-1">{{ $n->anho }}</td>
                  <td class="py-1">{{ $n->nomenclatura }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_cobradas) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_pendientes) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_cobrar) }}</td>
                </tr>
@endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">PAGO POR MESES</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
              <thead>
                <tr>
                  <th>Año</th>
                  <th>Mes</th>
                  <th>Cuentas Cobradas</th>
                  <th>Cuentas Pendientes</th>
                  <th>Cuentas por Cobrar</th>
                </tr>
              </thead>
              <tbody>
@foreach(App\Contable::pago_por_meses() as $n)
                <tr>
                  <td class="py-1">{{ $n->anho }}</td>
                  <td class="py-1">{{ $n->mes }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_cobradas) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_pendientes) }}</td>
                  <td class="py-1">{{ Helper::money($n->cuentas_por_cobrar) }}</td>
                </tr>
@endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">PROXIMOS PAGOS</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
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


    </div>
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script>
@endsection

