@extends('layouts.contentLayoutMaster')
@section('title', 'Editar cotizacion' )
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">

@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/themes/layout.css')}}" >
@endsection

@section('content')
<div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-header">
          </div>
          <div class="card-body">
            <form action="{{ route('cotizaciones.update', ['cotizacion' => $cotizacion->id ]) }}" class="form" method="put" id="form-data" >
                @method('PUT')
               @include('cotizacion.form')              
            </form>
          </div>
        </div>
      </div>
    </div>  
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/cotizacion/save.js')}}"></script>
@endsection
