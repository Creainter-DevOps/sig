@extends('layouts.backend')

@section('content')

<div class="content">
    <h2 class="content-heading">Editar</h2>
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Datos Personales</h3>
        </div>
        <div class="block-content">
            <form action="/empresas/{{ $empresa->id }}" method="POST" class="form-horizontal">
                {!! method_field('PUT') !!}
                @include('empresas.form')
            </form>
        </div>
    </div>
</div>
<!-- TODO: Current Tasks -->
@endsection
