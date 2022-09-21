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
  <div class="row">
    <div class="col-6 col-sm-6">
      <div class="card">
        <div class="card-content">
          <div class="card-body">

  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Ruc</th>
          <th>Empresa</th>
          <th>Licitaciones</th>
          <th style="width:140px;">Monto</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($rivales as $e)
        <tr>
          <td><a href="/empresas/{{ $e->id }}">{{ $e->ruc }}</a></td>
          <td>{{ $e->razon_social }}</td>
          <td>{{ $e->cantidad }}</td>
          <td>{{ Helper::money($e->monto_adjudicado, 1) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>




        </div>
      </div>
    </div>
  </div>
    <div class="col-6 col-sm-6">
      <div class="card">
        <div class="card-content">
          <div class="card-body">

  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Licitacion</th>
          <th style="width:140px;">V.R.</th>
          <th style="width:140px;">Adjudicado</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($ganadas as $e)
        <tr>
          <td>{{ Helper::fecha($e->fecha) }}</td>
          <td>
            <a href="/licitaciones/{{ $e->id }}">{{ $e->nomenclatura }}</a>
            <div style="font-size:10px">{{ $e->etiquetas }}</div>
          </td>
          <td style="text-align:right;">{{ Helper::money($e->valor_referencial, 1) }}</td>
          <td style="text-align:right;">{{ Helper::money($e->monto_adjudicado, 1) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>




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
