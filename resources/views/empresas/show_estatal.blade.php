@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Users View')
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
          <h4 class="media-heading"><span>{{ $empresa->razon_social }}</span></h4>
          <span>RUC:</span>
          <span class="users-view-id">{{ $empresa->ruc }}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Profile</a>
      <a href="{{asset('page-users-edit')}}" class="btn btn-sm btn-primary">Edit</a>
    </div>
  </div>
  <!-- users view media object ends -->
  <div class="card">
    <div class="card-content">
      <div class="card-body">


  <div class="table-responsive">
    <table class="table table-dark mb-0" style="width:100%">
      <thead>
        <tr>
          <th style="width:250px;">Nomenclatura</th>
          <th>Objeto</th>
          <th>Rótulo</th>
          <th>Participación</th>
        </tr>
      </thead>
      @foreach ($licitaciones_activas as $licitacion)
      <tbody class="block" data-licitacion-id="{{ $licitacion->id }}" data-licitacion-id="{{ $licitacion->id }}">
        <tr class="block_header">
          <td>
            <a href="/licitaciones/{{ $licitacion->id }}"><div style="color:#fff;">{{ $licitacion->nomenclatura }}</div></a>
          </td>
          <td><b>{{ $licitacion->tipo_objeto }}</b><br/>{{ $licitacion->rotulo }}</td>
          <td>{{ Helper::fecha($licitacion->fecha_participacion_hasta) }}<br /><span class="{{ $licitacion->estado()['class'] }}">{{ $licitacion->estado()['message'] }}</span></td>
          <td style="vertical-align: top;">
            <a href="/licitaciones/{{ $licitacion->id }}/aprobar" class="btn btn-sm btn-success shadow mr-1 mb-1" data-button-dinamic>Aprobar</a>
            <a data-confirm-input="¿Por qué desea Rechazarlo?" href="/licitaciones/{{ $licitacion->id }}/rechazar" class="btn btn-sm btn-danger glow mr-1 mb-1" data-button-dinamic>Rechazar</a>
          </td>
        </tr>
        </tbody>
        @endforeach
    </table>
  </div>




      </div>
    </div>
  </div>
  <!-- users view card details ends -->

</section>
<!-- users view ends -->
@endsection
{{-- page scripts --}}
@section('page-scripts')
@endsection
