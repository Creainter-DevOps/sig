@extends('layouts.contentLayoutMaster')

@section('content')
<div class="content">
    <h2 class="content-heading">Nuevo Cliente</h2>
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
            <form action="/clientes" method="POST" class="form-horizontal">
                @include('empresas.form')
    <div class="col-12">
        <div class="form-group">
            <label>Breve Descripción</label>
            <textarea name="descripcion" placeholder="Descripción" class="form-control">{{ old('descripcion', @$cliente->descripcion) }}</textarea>
            @if ($errors->has('descripcion'))
            <div class="invalid-feedback">{{ $errors->first('descripcion') }}</div>
            @endif
        </div>
    </div>

            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Representantes</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                        <th>Tipo Doc.</th>
                        <th># Doc.</th>
                        <th>Nombres</th>
                        <th>Cargo</th>
                        <th>Género</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th width="5%">Opciones</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="form-group" style="margin-left:20px;">0 Representante(s)</div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Productos</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                        <th>Cod. Producto</th>
                        <th>Nombre</th>
                        <th>Familia</th>
                        <th>Estado</th>
                        <th width="5%">Opciones</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="form-group" style="margin-left:20px;">0 Producto(s)</div>
            </div>

        </div>
    </div>
</div>
<!-- TODO: Current Tasks -->
@endsection
