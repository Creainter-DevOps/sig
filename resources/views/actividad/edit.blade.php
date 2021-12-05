@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Editar Actividad' )
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- page style --}}
@section('page-styles')
@endsection
@section('content')
<div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-header">
          </div> 
          <div class="card-body">
            <form class="form" action="{{ route('actividad.update', [ 'contacto' => $contacto->id ])}}" method="post" id="form-data" >
            @method('PUT')  
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
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/contacto/save.js')}}"></script>
@endsection
