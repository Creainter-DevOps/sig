@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title',  'Nueva Actividad' )
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection
{{-- page style --}}
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
            <form class="form" action="{{ route('actividades.store')}}" method="post" id="form-data" >
              @include('actividad.form')
            </form>
          </div>
        </div>
      </div>
    </div>  
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/actividad/index.js')}}"></script>
@endsection
