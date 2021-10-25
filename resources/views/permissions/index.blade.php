@extends('layouts.contentLayoutMaster')

@section('content')
<style>
    .bloque ul {
        margin: 0;
        list-style: none;
        padding: 0;
    }

    .bloque li {
        display: inline-block;
    }

    .bloque {
        max-height: 300px;
        overflow: auto;
    }
</style>
<div class="content">
    <div class="row">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Usuarios</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive" style="max-height: 600px;overflow: auto;">
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <th>Usuario</th>
                                <th>Nombres</th>
                                <th width="5%">Opciones</th>
                            </thead>
                            @foreach ($usuarios as $usuario)
                            <tbody data-id="{{ $usuario->id }}" data-url="/permissions/usuario/{{ $usuario->id }}/permisos">
                                <tr>
                                    <td>{{ $usuario->usuario }}</td>
                                    <td>{{ $usuario->id }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-secondary js-tooltip-enabled btnDetails" href="javascript:void(0)" style="margin-right:5px;">
                                                <i class="fa fa-list"></i>
                                            </a>
                                            <!-- <a class="btn btn-sm btn-secondary js-tooltip-enabled" data-popup-cache="false" data-popup="permissions/usuario/{{ $usuario->id }}/edit">
                                                <i class="fa fa-pencil"></i>
                                            </a> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bloque" style="display:none;">
                                    <td colspan="3">{{ $usuario->usuario }}</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="text-align:right;">
                <a class="btn btn-default" data-popup="/permissions/grupo" style="color: #fff; background-color: #007bff; border-color: #007bff;margin-bottom:10px;">
                    Nuevo Grupo
                </a>
            </div>
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grupos</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th width="5%">Opciones</th>
                            </thead>
                            @foreach ($grupos as $grupo)
                            <tbody data-id="{{ $grupo->id }}" data-url="/permissions/grupo/{{ $grupo->id }}/permisos">
                                <tr>
                                    <td>{{ $grupo->nombre }}</td>
                                    <td>{{ $grupo->descripcion }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-secondary js-tooltip-enabled btnDetails" href="javascript:void(0)" style="margin-right:5px;">
                                                <i class="fa fa-list"></i>
                                            </a>
                                            <a class="btn btn-sm btn-secondary js-tooltip-enabled" data-popup-cache="false" data-popup="permissions/grupo/{{ $grupo->id }}/edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bloque" style="display:none;">
                                    <td colspan="3">{{ $grupo->nombre }}</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div style="text-align:right;">
                <a class="btn btn-default" data-popup="/permissions/controlador" style="color: #fff; background-color: #007bff; border-color: #007bff;margin-bottom:10px;">
                    Nuevo Modulo
                </a>
            </div>
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Modulos</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <th>Rótulo</th>
                                <th>Link</th>
                                <th>Permisos</th>
                                <th width="5%">Opciones</th>
                            </thead>
                            <tbody>
                                @foreach ($modulos as $modulo)
                                <tr>
                                    <td>{{ ($modulo->es_hijo ? " └ " : "") . $modulo->rotulo }}</td>
                                    <td>{{ $modulo->link }}</td>
                                    <td>{{ $modulo->permisos }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-secondary js-tooltip-enabled" data-popup-cache="false" data-popup="permissions/controlador/{{ $modulo->id }}/edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script>
    $(".btnDetails").on('click', function() {
        console.log('CLICK', 'btnDetails');
        var box = $(this);
        var parent = box.closest('tbody');
        var id = parent.attr('data-id');
        var url = parent.attr('data-url');
        var body = parent.find('.bloque');
        box.closest('table').find('.bloque').hide();
        Fetchx({
            url: url,
            success: function(data) {
                body.find('td').html(data);
                body.show();
            }
        });
    });
    $(document).on('submit', '.bloque form', function(e) {
        e.preventDefault();
        var form = $(this);
        var bloque = form.closest('.bloque');
        Fetchx({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(data) {
                bloque.hide();
            }
        });
    });
</script>
@endsection

