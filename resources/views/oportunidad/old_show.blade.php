@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Users View')
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css') }}">
@endsection
@section('content')
<!-- users view start -->
<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
    <div class="col-12 col-sm-9">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h4>{{$oportunidad->rotulo }}</h4>
          @if (isset( $oportunidad->nombre) && isset( $oportunidad->que_es) )
            <h6 class="media-heading">{{ $oportunidad->codigo }}</h6>
          @else
          <h6 class="media-heading"> {{ isset( $oportunidad->codigo) ? $oportunidad->codigo : $oportunidad->que_es }}</h6>
          <span>{{ $oportunidad->nomenclatura }}</span>
          @endif
        </div>
      </div>
    </div>
    <!--<div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Profile</a>
      <a href="{{asset('page-users-edit')}}" class="btn btn-sm btn-primary">Edit</a>
    </div>-->
  </div>
  <div class="row">
@if(!empty($oportunidad) && !empty($oportunidad->cliente_id))
    <div class="col-12">
      <div style="text-align: center;background: #6ea1ff;margin-bottom: 5px;color: #ffff;">EL CLIENTE</div>
      <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('clientes.table', ['cliente' => $oportunidad->cliente()])
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('clientes.contactos', ['cliente' => $oportunidad->cliente()])
          </div>
        </div>
      </div>
      </div>
    </div>
@endif
    <div class="col-12">
      <div style="text-align: center;background: #ffb16e;margin-bottom: 5px;color: #ffff;">LA OPORTUNIDAD</div>
      <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('empresas.table', ['empresa' => $oportunidad->empresa()])
          </div>
        </div>
      </div>
    @if (!empty($oportunidad->cliente_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('clientes.table', ['cliente' => $oportunidad->cliente()])
          </div>
        </div>
      </div>
      @endif
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('oportunidad.table', compact('oportunidad'))
          </div>
        </div>
      </div>
    @if (!empty($oportunidad->licitacion_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('licitacion.table', ['licitacion' => $oportunidad->licitacion()])
          </div>
        </div>
      </div>
    @endif
    @if (!empty($oportunidad->contacto_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('contactos.table', ['contacto' => $oportunidad->contacto()] )
          </div>
        </div>
      </div>
    @endif
    <div  class="col-6 col-sm-6">
        <div class="card">
          <div class="card-body">
             @include('oportunidad.cotizaciones', [ 'oportunidad' => $oportunidad])
          </div>
        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
    <table class="table table-sm mb-0 table-bordered table-vcenter">
      <thead>
        <tr>
          <td>Fecha</td>
          <td>Desde</td>
          <td>Asunto</td>
        </tr>
      </thead>
      <tbody>
@foreach(App\Correo::relacionados($oportunidad->correo_id) as $r)
        <tr>
          <td>{{ $r->fecha }}</td>
          <td>{{ $r->correo_desde }}</td>
          <td>{{ $r->asunto }}</td>
        </tr>
@endforeach
      </tbody>
    </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    @include('actividad.create', ['into' => ['oportunidad_id' => $oportunidad->id]])
  </div>
</div>
  <!-- users view card data ends -->

@endsection
@section('modals')
  @include('oportunidad.modalCotizacionDetalle')
@endsection
@section('vendor-scripts')
  <script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/app-invoice.js') }}"></script>
  <script src="{{ asset('js/scripts/cotizacion/detalle.js') }}"></script>
@endsection
@section ('page-scripts')
@endsection
