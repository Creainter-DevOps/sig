@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Cotizaciones')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/themes/layout.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/themes/layout.css') }}">
@endsection

@section('content')
<!-- table Transactions start -->
</section>
<!-- table Transactions end -->
<!-- table success start -->
<section id="table-success">
  <div class="card">
    <!-- datatable start -->
    <div class="card">
    <div class="card-header">
      <!-- head -->
      <!-- Single Date Picker and button -->
      <div class="heading-elements" style="display:flex;justify-content:space-between; align-items:center;position:initial;" >
        <ul class="list-inline mb-0">
          <li class="ml-2"><a class="btn btn-primary" href="/cotizaciones/crear"><i class="bx bx-plus mr-1"></i> Nueva </a></li>
        </ul>
      </div>
    </div>
    <div class="table-responsive">
      <table id="table-extended-success" class="table mb-0">
        <thead>
          <tr>
            <th style="width:65%">Cliente</th>
            <th>M.Total</th>
            <th>M.Fecha</th>
            <th>Valiadez</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach ( $listado as $cotizacion ) 
          <tr data-cliente="{{ $cotizacion->cliente()->empresa()->razon_social }}"  data-monto="{{$cotizacion->monto_total }}" >
            <td class="pr-0" style="width:65%"  > {{ $cotizacion->cliente()->empresa()->razon_social }} </td>
            <td class="text-success" align ="left" >{{ $cotizacion->monto_total }}</td>
            <td class="">{{ Helper::fecha( $cotizacion->fecha ) }}</td>
            <td class="">{{ Helper::fecha( $cotizacion->validez ) }}</td>
            <td>
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-2 dropdown-toggle nav-hide-arrow cursor-pointer"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="/cotizaciones/{{ $cotizacion->id }} "><i class="bx bx-show-alt mr-1"></i> Ver más</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $cotizacion->id }}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <!-- <a class="dropdown-item" onclick="eliminar(event)" href="/cotizaciones/{{ $cotizacion->id }}/eliminar"><i class="bx bx-trash mr-1"></i> Eliminar</a>-->
                </div>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- datatable ends -->
  </div>
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
<script src="{{asset('js/scripts/helpers/basic.crud.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
  <script src="{{asset('js/scripts/cotizacion/index.js')}}"></script>
@endsection
