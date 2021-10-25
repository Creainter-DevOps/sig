@extends('layouts.backend')

@section('content')

<div class="content">
    <div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;text-align:right;">
                <a class="btn btn-default" href="/empresas/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
                    Nuevo
                </a>
        </div>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Clientes Registrados</h3>
        </div>
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                        <th>RUC</th>
                        <th>Razon social</th>
                        <th>Seudonimo</th>
                        <th>Telefono</th>
                        <th>Web</th>
                        <th width="5%">Opciones</th>
                    </thead>
                    <tbody>
                        @foreach ($listado as $empresa)
                            <tr>
                                <td>{{ $empresa->ruc }}</td>
                                <td>{{ $empresa->razon_social }}</td>
                                <td>{{ $empresa->seudonimo }}</td>
                                <td>{{ $empresa->telefono }}</td>
                                <td>{{ $empresa->web }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-secondary js-tooltip-enabled" href="/empresas/{{ $empresa->id }}/editar">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-sm btn-secondary js-tooltip-enabled" href="/empresas/{{ $empresa->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $listado->links() }}
                <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div>
            </div>
        </div>
    </div>
</div>
@endsection
