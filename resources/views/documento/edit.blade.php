@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Editar documento' )
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            <form class="form" action="{{ route('documentos.update', [ 'documento' => $documento->id ])}}" method="post"  enctype="multipart/form-data" >
            @method('PUT')  
            @include('documento.form')
            </form>
          </div>
        </div>
      </div>
    </div>  
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/documento/save.js')}}"></script>
@endsection
