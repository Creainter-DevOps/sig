@extends('layouts.contentLayoutMaster')
@section('title', 'Detalle Oportunidad')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/dragula.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/widgets.css') }}">
@endsection

@section('vendor-scripts')
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/dragula.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/scripts/pages/page-users.js') }}"></script>
    <script src="{{ asset('js/scripts/cards/widgets.js') }}"></script>
@endsection

@section('content')

    <style>
        .certificado_button {}

        .certificado_button:hover+.certificado_body {
            display: block;
        }

        .certificado_body {
            position: fixed;
            width: 800px;
            height: 600px;
            background: white;
            z-index: 9999999999999;
            top: 29px;
            left: 50%;
            margin-left: -400px;
            padding: 10px 20px;
            border: 1px solid #727272;
            display: none;
        }

        .wrapper {
            max-width: 330px;
            font-family: 'Helvetica';
            font-size: 14px;
        }

        .StepProgress {
            position: relative;
            padding-left: 45px;
            list-style: none;
        }

        .StepProgress::before {
            display: inline-block;
            content: '';
            position: absolute;
            top: 0;
            left: 15px;
            width: 10px;
            height: 100%;
            border-left: 2px solid #CCC;
        }

        .StepProgress-item {
            position: relative;
            counter-increment: list;
        }

        .StepProgress-item:not(:last-child) {
            padding-bottom: 20px;
        }

        .StepProgress-item::before {
            display: inline-block;
            content: '';
            position: absolute;
            left: -30px;
            height: 100%;
            width: 10px;
        }

        .StepProgress-item::after {
            content: '';
            display: inline-block;
            position: absolute;
            top: 0;
            left: -37px;
            width: 12px;
            height: 12px;
            border: 2px solid #CCC;
            border-radius: 50%;
            background-color: #FFF;
        }

        .StepProgress-item.is-done::before {
            border-left: 2px solid green;
        }

        .StepProgress-item.is-done::after {
            content: "✔";
            font-size: 10px;
            color: #FFF;
            text-align: center;
            border: 2px solid green;
            background-color: green;
        }

        .StepProgress-item.current::before {
            border-left: 2px solid green;
        }

        .StepProgress-item.current::after {
            content: counter(list);
            padding-top: 1px;
            width: 19px;
            height: 18px;
            top: -4px;
            left: -40px;
            font-size: 14px;
            text-align: center;
            color: green;
            border: 2px solid green;
            background-color: white;
        }

        .StepProgress strong {
            display: block;
        }
    </style>
    <section class="users-view">
        <div class="row">
            <div class="col-12 col-sm-7">
                <div class="media mb-2">
                    <a class="mr-1" href="#">
                        <img src="{{ asset('images/portrait/small/avatar-s-26.jpg') }}" alt="users view avatar"
                            class="users-avatar-shadow rounded-circle" height="64" width="64" />
                    </a>
                    <div class="media-body pt-25">
                        <h4 class="media-heading">Oportunidad de Negocio</h4>
                        <span>Licitación del SEACE</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
                @if (!empty($oportunidad->rechazado_el))
                    <div class="text-center">Rechazado el {{ Helper::fecha($oportunidad->rechazado_el, true) }}</div>
                @elseif(!empty($oportunidad->archivado_el))
                    <div class="text-center">Archivado el {{ Helper::fecha($oportunidad->archivado_el, true) }}</div>
                @elseif(empty($oportunidad->aprobado_el))
                    <a href="/oportunidades/{{ $oportunidad->id }}/aprobar"
                        class="btn btn-sm btn-success mr-25">Aprobar</a>
                    <a data-confirm-input="¿Por qué desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25">Rechazar</a>
                @elseif(empty($oportunidad->revisado_el))
                    <a href="/oportunidades/{{ $oportunidad->id }}/revisar"
                        class="btn btn-sm btn-success mr-25">Revisar</a>
                    <a data-confirm-input="¿Por qué desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25">Rechazar</a>
                @elseif($oportunidad->estado == 'PENDIENTE')
                    <a data-confirm-input="¿Por qué desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25">Rechazar</a>
                @else
                    <a data-confirm-input="¿Por qué desea Archivarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/archivar"
                        class="btn btn-sm btn-danger mr-25">Archivar</a>
                @endif
            </div>
        </div>
        <div class="row">
            @if (!empty($oportunidad->cliente_id))
                <div class="col-12">
                    <div style="text-align: center;background: #6ea1ff;margin-bottom: 5px;color: #ffff;">EL CLIENTE</div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    @include('clientes.table', ['cliente' => $oportunidad->cliente()])
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    @include('clientes.contactos', ['cliente' => $oportunidad->cliente()])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($oportunidad->licitacion_id))
                <div class="col-12">
                    <div style="text-align: center;background: #ffb16e;margin-bottom: 5px;color: #ffff;">
                        LA OPORTUNIDAD
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        @include('licitacion.table', [
                                            'licitacion' => $oportunidad->licitacion(),
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        @include('licitacion.cronograma', [
                                            'licitacion' => $oportunidad->licitacion(),
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12">
                @if (!empty($oportunidad))
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                @include('oportunidad.table', compact('oportunidad'))
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    @if (!empty($oportunidad))
                                        <tr>
                                            <td>Monto Base:</td>
                                            <td style="display:flex;">
                                                <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=monto_base"
                                                    data-name="monto_base">{{ Helper::money($oportunidad->monto_base) }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Instalación:</td>
                                            <td class="d-flex align-items-end">
                                                <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=instalacion_dias"
                                                    data-name="instalacion_dias">
                                                    {{ $oportunidad->instalacion_dias ?? 0 }}</div><label>días</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Servicio:</td>
                                            <td class="d-flex align-items-end ">
                                                <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=duracion_dias"
                                                    data-name="duracion_dias">{{ $oportunidad->duracion_dias ?? 0 }}
                                                </div> <label>días</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Garantía:</td>
                                            <td class="d-flex align-items-end">
                                                <div data-editable="/oportunidades/{{ $oportunidad->id }}?_update=garantia_dias"
                                                    data-name="garantia_dias">{{ $oportunidad->garantia_dias ?? 0 }}
                                                </div> <label>días</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Estado</td>
                                            <td>
                                                <h3>{{ $oportunidad->render_estado() }}</h3>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            @if (!empty($oportunidad->id))
                                <label>Apuntes</label>
                                <div data-ishtml
                                    data-editable="/oportunidades/{{ $oportunidad->id }}?_update=observacion">
                                    {!! $oportunidad->observacion !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                @if (!empty($oportunidad) && !empty($oportunidad->proyecto()))
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div
                                    style="background: #b0ffc5;color: #159905;text-align: center;padding: 10px;margin-bottom: 10px;">
                                    Ya es un proyecto!</div>
                                @include('proyectos.table', ['proyecto' => $oportunidad->proyecto()])
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>


        @if (!empty($oportunidad))
            <h5>Cotizaciones</h5>
            <div class="row">
                @if (!empty($oportunidad))
                    <div class="col-12">
                        @include('actividad.create', [
                            'into' => [
                                'licitacion_id' => $oportunidad->licitacion_id,
                                'oportunidad_id' => $oportunidad->id,
                            ],
                        ])
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
