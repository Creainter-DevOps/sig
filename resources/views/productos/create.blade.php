@extends('layouts.contentLayoutMaster')
@section('title', 'Nuevo Producto') 
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="card">
    <!--<div class="card-header block-header-default">
        <h3 class="block-title">Nuevo producto</h3>
    </div>-->
    <div class="card-content">
       <div class="card-body">
        <form action="/productos" method="POST" class="form-horizontal form-data" id="form-data" >
            @include('productos.form')
        </form>
      </div>  
    </div>
</div>
@endsection
@section('page-scripts')
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
@endsection
