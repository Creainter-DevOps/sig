@extends('layouts.contentLayoutMaster')
{-- page title --}}
@section('title', 'Clientes')
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<!-- users view start -->
<section class="users-view">
  <!-- users view media object start -->
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        @include('productos.table')
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        @include('empresas.table', [ 'empresa' => $producto->empresa() ])
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
