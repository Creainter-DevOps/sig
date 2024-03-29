@extends('layouts.contentLayoutMaster')
@section('title','Users View')
@section('page-styles')
@parent
<link rel="stylesheet" type="text/css" href="{{asset('css/Bucket.css')}}">
@endsection
@section('content')
  <nav style="background: #596dff;color: #fff;">
    <div style="padding: 10px 20px;">
      <div style="font-size: 15px;color: #ffffff;">{{ $proyecto->codigo }}</div>
      <div style="width: 500px;text-overflow: ellipsis;overflow: hidden;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;color: #ffffff;font-size: 17px;">
        {{ $proyecto->rotulo }}
      </div>
    </div>
    <div>
     <ul class="nav nav-tabs justify-content-end" role="tablist" style="margin: 0;padding: 0 20px;">
              <li style="margin-right: 5px;">
                <a class="nav-link" id="home-tab-end" data-toggle="tab" href="#home-align-end"
                  aria-controls="home-align-end" role="tab" aria-selected="true" style="padding: 5px 15px;">
                  Home
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link active" id="service-tab-end" data-toggle="tab" href="#service-align-end"
                  aria-controls="service-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Service
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link" id="account-tab-end" data-toggle="tab" href="#account-align-end"
                  aria-controls="account-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Account
                </a>
              </li>
            </ul> 
    </div>
  </nav>
<!-- users view start -->
<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
    <div class="col-12 col-sm-12">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h5 class="media-heading">{{ $proyecto->rotulo }}</h5>
          <span>{{ $proyecto->codigo }}</span>
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
    <div class="col-12">
      <div style="text-align: center;background: #43e16c;margin-bottom: 5px;color: #ffff;">EL PROYECTO</div>
<div class="row">
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-0">
              <i class="bx bx-edit-alt font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">Estado</p>
            <h4 class="mb-0">{{ $proyecto->estadoArray()['name'] }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-0">
              <i class="bx bx-file font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">Entregables</p>
            <h2 class="mb-0">{{ $proyecto->meta()->entregables_efectuados }} / {{ $proyecto->meta()->entregables_totales }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-0">
              <i class="bx bx-purchase-tag font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">Duración</p>
            <h3 class="mb-0">{{ $proyecto->meta()->porcentaje_dias }}%</h3>
            <h6 class="mb-0">{{ $proyecto->meta()->duracion_avance }}/{{ $proyecto->meta()->duracion_dias }}</h6>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-0">
              <i class="bx bx-money font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">Pagos</p>
            <h3 class="mb-0">{{ $proyecto->meta()->porcentaje_monto }}%</h3>
            <h6 class="mb-0">Pend. {{ Helper::money($proyecto->meta()->pago_pendiente, 1) }}</h6>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-0">
              <i class="bx bx-shopping-bag font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">Orden</p>
            <h3 class="mb-0">{{ Helper::money($proyecto->meta()->gasto_efectuado, 1) }}</h3>
            <h6 class="mb-0">Pend. {{ Helper::money($proyecto->meta()->gasto_pendiente, 1) }}</h6>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-0">
              <i class="bx bx-money font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">Rendición</p>
            <h3 class="mb-0">{{ Helper::money($proyecto->meta()->liquido_efectuado) }}</h3>
            <h6 class="mb-0">Pend. {{ Helper::money($proyecto->meta()->liquido_total, 1) }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>


      <div class="row">
      <div class="col-6 col-md-6">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @include('proyectos.table', compact('proyecto'))
          </div>
        </div>
      </div>
    </div>
    @if(!empty($proyecto->oportunidad()->licitacion_id))
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('licitacion.table', ['licitacion' => $proyecto->oportunidad()->licitacion()])
          </div>
        </div>
      </div>
    @endif
    <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            @include('proyectos.entregables')
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="col-12">
    <div class="row">
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
            @include('proyectos.ordenes')
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
    <div class="col-12">
      @include('actividad.create', [
                    'into' => [
                        'proyecto_id' => $proyecto->id,
                        'oportunidad_id' => $proyecto->oportunidad()->id,
                        'licitacion_id' => $proyecto->oportunidad()->licitacion_id,
                    ],
                ])
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
<script src="{{asset('js/Bucket.js')}}"></script>
@endsection
