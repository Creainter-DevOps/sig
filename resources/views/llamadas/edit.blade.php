@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice List')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
@endsection

@section('content')
<div class="row" id="basic-table">
  <div class="col-12">
<div class="card">
        <div class="card-header">
          <h4 class="card-title">Formulario</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form form-horizontal"   action=" {{ route('proyectos.update', ['proyecto' => $proyecto->id ]) }}" method="POST" id="form-data" >
               {!! method_field('PUT') !!}
              <div class="form-body">
              
                  @include('proyectos.formulario')
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
  <div>
</div>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{asset('js/scripts/typeahead.js')}}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/cotizacion/save.js')}}"></script>
@endsection
