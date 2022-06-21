@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Clientes')
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<!-- users view start -->
<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
    <div class="col-12 col-sm-7">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h4 class="media-heading">{{ $empresa->razon_social }}</h4>
          <span>RUC:</span>
          <span>{{ $empresa->ruc }}</span>
        </div>
      </div>
    </div>
    <!--<div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Profile</a>
      <a href="{{asset('page-users-edit')}}" class="btn btn-sm btn-primary">Edit</a>
    </div>-->
  </div>
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        @include('clientes.table')
      </div>
    </div>
  </div>
  <div class="row">
      <div class="col-xl-7 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">OSCE</h4>
          </div>
          <div class="table-responsive">
            <table id="table-marketing-campaigns" class="table mb-0">
              <thead>
                <tr>
                  <th>Servicio</th>
                  <th>Margen</th>
                  <th>Estado</th>
                  <th class="text-center">Accion</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cliente->oportunidades() as $v)
                <tr>
                  <td class="py-1">
                    {!! $v->rotulo() !!}
                  </td>
                  <td class="py-1" style="width: 150px;">
                    <i class="bx bx-trending-up text-success align-middle mr-50"></i><span>{{ $v->margen() }}</span>
                  </td>
                  <td class="py-1 text-center">
                    <span class="{{ $v->estado()['class'] }}">{{ $v->estado()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->licitacion()->fecha_participacion_hasta, true) }}</div>
                  </td>
                  <td class="text-center py-1">
                    <a href="/oportunidad/{{ $v->id }}/detalles" class="invoice-action-view mr-1">
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
      <div class="col-sm-12 col-md-5">
        @include('clientes.timeline')
      </div>
  </div>
  <!-- users view card details ends -->
</section>
<!-- users view ends -->
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
