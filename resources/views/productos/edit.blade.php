@extends('layouts.contentLayoutMaster')
@section('title', 'Editar Cliente') 
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="card">
    <!--<div class="card-header block-header-default">
        <h3 class="block-title">Editar producto</h3>
    </div>-->
    <div class="card-content">
       <div class="card-body">
        <form action="{{ route('productos.update', ['producto' => $producto->id ])}}" method="post" class="form-horizontal form-data" id="form-data" >
            {{ method_field('PUT') }}
            @include('productos.form')
        </form>
      </div>  
    </div>
</div>
@endsection
@section('page-scripts')
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
@endsection
