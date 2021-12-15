@extends('layouts.contentLayoutMaster')
@section('title', 'Nueva Oportunidad')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection
@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-content">
      <div class="card-header">
        <h5 class="card-title"> Nueva Oportunidad </h5>
      </div>
      <div class="card-body">
          <form action="{{ route('oportunidades.store') }}" autocomplete="nope" method="POST" class="form-horizontal" id="form-data" >
              @include('oportunidad.formulario')
          </form>
      </div>
    </div>
  </div>
</div>
<!-- TODO: Current Tasks -->
@endsection
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/cotizacion/save.js')}}"></script>
@endsection



