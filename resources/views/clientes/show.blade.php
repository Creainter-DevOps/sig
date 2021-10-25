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
          <h4 class="media-heading">{{ $cliente->nombre }}</h4>
          <span>ID:</span>
          <span>{{ $cliente->id }}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Profile</a>
      <a href="{{asset('page-users-edit')}}" class="btn btn-sm btn-primary">Edit</a>
    </div>
  </div>
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-4">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width:200px;">Registrado:</td>
                  <td>{{ Helper::fecha($cliente->created_on, true)}}</td>
                </tr>
                <tr>
                  <td>Ultima Comunicación:</td>
                  <td class="users-view-latest-activity">{{ Helper::fecha($cliente->ultima_comunicacion()) }}</td>
                </tr>
                <tr>
                  <td>RUC:</td>
                  <td class="users-view-role">Staff</td>
                </tr>
                <tr>
                  <td>Dirección:</td>
                  <td class="users-view-role">Staff</td>
                </tr>
                <tr>
                  <td>Correo:</td>
                  <td class="users-view-verified">Yes</td>
                </tr>
                <tr>
                  <td>Telefono:</td>
                  <td class="users-view-role">Staff</td>
                </tr>
                <tr>
                  <td>Vinculación Actual:</td>
                  <td><span class="badge badge-light-success">Active</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 col-md-8">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>Module Permission</th>
                    <th>Read</th>
                    <th>Write</th>
                    <th>Create</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Users</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                  </tr>
                  <tr>
                    <td>Articles</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>Yes</td>
                  </tr>
                  <tr>
                    <td>Staff</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>No</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- users view card data ends -->
  <!-- users view card details start -->
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="row bg-primary bg-lighten-5 rounded mb-2 mx-25 text-center text-lg-left">
          <div class="col-12 col-sm-3 p-2 text-center">
            <h6 class="text-primary mb-0">OSCE: <span class="font-large-1 align-middle">2</span></h6>
          </div>
          <div class="col-12 col-sm-3 p-2 text-center">
            <h6 class="text-primary mb-0">CARTAS: <span class="font-large-1 align-middle">0</span></h6>
          </div>
          <div class="col-12 col-sm-3 p-2 text-center">
            <h6 class="text-primary mb-0">COTIZACIONES: <span class="font-large-1 align-middle">0</span></h6>
          </div>
          <div class="col-12 col-sm-3 p-2 text-center">
            <h6 class="text-primary mb-0">PROYECTOS: <span class="font-large-1 align-middle">0</span></h6>
          </div>
        </div>
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
  <div class="row">
      <div class="col-xl-7 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">OSCE</h4>
          </div>
          <div class="table-responsive">
            <!-- table start -->
            <table id="table-marketing-campaigns" class="table mb-0">
              <thead>
                <tr>
                  <th>Servicio</th>
                  <th>Margen</th>
                  <th>Estado</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
@foreach($cliente->oportunidades() as $v)
                <tr>
                  <td class="py-1">
                    {{ $v->oportunidad()->rotulo }}
                  </td>
                  <td class="py-1" style="width: 150px;">
                    <i class="bx bx-trending-up text-success align-middle mr-50"></i><span>{{ $v->margen() }}</span>
                  </td>
                  <td class="py-1 text-center">
                    <span class="{{ $v->estado()['class'] }}">{{ $v->estado()['message'] }}</span>
                    <div style="font-size:11px;">{{ Helper::fecha($v->oportunidad()->fecha_participacion_hasta, true) }}</div>
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
  </div>
  <!-- users view card details ends -->

</section>
<!-- users view ends -->
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
