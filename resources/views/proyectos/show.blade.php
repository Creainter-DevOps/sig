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
          <h4 class="media-heading">{{ $proyecto->nombre }}</h4>
          <span>{{ $proyecto->nomenclatura }}</span>
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
    @if (!empty($proyecto->cliente_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('clientes.table')
          </div>
        </div>
      </div>
      @endif
      @if(!empty($proyecto->oportunidad()->licitacion_id))
    <div class="col-6 col-md-6">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @include('licitacion.table', ['licitacion' => $proyecto->oportunidad()->licitacion()])
          </div>
        </div>
      </div>
    </div>
    @endif
    @if (!empty($proyecto->cotizacion_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('oportunidad.table', ['oportunidad' => $proyecto->oportunidad()])
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('cotizacion.table', ['cotizacion' => $proyecto->cotizacion()])
          </div>
        </div>
      </div>
    @endif
    <div class="col-6 col-md-6">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @include('proyectos.table', compact('proyecto'))
          </div>
        </div>
      </div>
    </div>
    @if (!empty($proyecto->contacto_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('contactos.table')
          </div>
        </div>
      </div>
      @endif
    <div class="col-12">
    <div class="row">
    <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('proyectos.entregables')
          </div>
        </div>
      </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('proyectos.pagos')
          </div>
        </div>
      </div>
    <div class="col-6">
        <div class="card">
          <div class="card-body">
            @include('proyectos.cartas')
          </div>
        </div>
      </div>
    <div class="col-6">
        <div class="card">
          <div class="card-body">
            @include('proyectos.actas')
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-sm-6">
      @include('proyectos.timeline')
    </div>
    </div>
    </div>
  </div>
  <!-- users view card data ends -->

  <!-- users view card details start -->
<!--<div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="col-12">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>Username:</td>
                <td class="users-view-username">dean3004</td>
              </tr>
              <tr>
                <td>Name:</td>
                <td class="users-view-name">Dean Stanley</td>
              </tr>
              <tr>
                <td>E-mail:</td>
                <td class="users-view-email">deanstanley@gmail.com</td>
              </tr>
              <tr>
                <td>Comapny:</td>
                <td>XYZ Corp. Ltd.</td>
              </tr>

            </tbody>
          </table>
          <h5 class="mb-1"><i class="bx bx-link"></i> Social Links</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>Twitter:</td>
                <td><a href="#">https://www.twitter.com/</a></td>
              </tr>
              <tr>
                <td>Facebook:</td>
                <td><a href="#">https://www.facebook.com/</a></td>
              </tr>
              <tr>
                <td>Instagram:</td>
                <td><a href="#">https://www.instagram.com/</a></td>
              </tr>
            </tbody>
          </table>
          <h5 class="mb-1"><i class="bx bx-info-circle"></i> Personal Info</h5>
          <table class="table table-borderless mb-0">
            <tbody>
              <tr>
                <td>Birthday:</td>
                <td>03/04/1990</td>
              </tr>
              <tr>
                <td>Country:</td>
                <td>USA</td>
              </tr>
              <tr>
                <td>Languages:</td>
                <td>English</td>
              </tr>
              <tr>
                <td>Contact:</td>
                <td>+(305) 254 24668</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>-->
<!-- users view ends -->
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
