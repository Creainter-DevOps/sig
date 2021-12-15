
@extends('layouts.contentLayoutMaster')

@section('title', 'Detalle contacto' )

@section('content') 
<div class="col-12">
  <div class="card">
    <div class="card-content">
      <div class="card-header">
      </div>
      <div class="card-body">
        @include('empresas.table')
      </div>
    </div>
  </div>
</div>

@endsection
