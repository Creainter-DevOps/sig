@extends('layouts.contentLayoutMaster')
@section('title', 'Nuevo Cliente') 
@section('content')
@section('custom-styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-invoice.css') }}">
@endsection
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="card">
    <div class="card-header block-header-default">
        <h3 class="block-title">Nuevo proveedor</h3>
    </div>
    <div class="card-content">
       <div class="card-body">
        <form action="/proveedores" method="POST" class="form-horizontal form-data" id="form-data" >
            @include('proveedores.form')
        </form>
      </div>  
    </div>
</div>
@endsection
@section('page-scripts')
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
  <script src="https://sig.creainter.com.pe/js/scripts/pages/app-invoice.js"></script>  
@endsection
