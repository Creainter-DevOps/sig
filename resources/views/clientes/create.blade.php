@extends('layouts.contentLayoutMaster')
@section('title', 'Nuevo Cliente') 
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="card">
    <div class="card-header block-header-default">
        <h3 class="block-title">Nuevo cliente</h3>
    </div>
    <div class="card-content">
       <div class="card-body">
        <form action="/clientes" method="POST" class="form-horizontal">
            @include('clientes.form')
        </form>
      </div>  
    </div>
</div>
@endsection
