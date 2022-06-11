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
    <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Profile</a>
      <a href="{{asset('page-users-edit')}}" class="btn btn-sm btn-primary">Edit</a>
    </div>
  </div>
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        @include('proveedores.table')
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-content">
      <div  class="card-header">
        <h4 class="card-title">Productos</h4>
      </div>
      <div class="card-body">
        @include('proveedores.productostable', [ 'pproductos' => $proveedor->productos() ])
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
