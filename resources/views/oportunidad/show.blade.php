@extends('layouts.contentLayoutMaster')
@section('title', 'Detalle Oportunidad')

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
              @if($oportunidad->estado()['timeout'] && !empty($oportunidad->aprobado_el) && empty($oportunidad->archivado_el))
                <a data-confirm-input="¿Por qué desea Archivarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/archivar"
                        class="btn btn-sm btn-danger mr-25" data-button-dinamic>Archivar</a>
                @elseif (!empty($oportunidad->rechazado_el))
                    <div class="text-center">Rechazado el {{ Helper::fecha($oportunidad->rechazado_el, true) }}</div>

                @elseif(!empty($oportunidad->archivado_el))
                    <div class="text-center">Archivado el {{ Helper::fecha($oportunidad->archivado_el, true) }}</div>

                @elseif(empty($oportunidad->aprobado_el))
                    <a href="/oportunidades/{{ $oportunidad->id }}/aprobar"
                        class="btn btn-sm btn-success mr-25" data-button-dinamic>Aprobar</a>
                    <a data-confirm-input="¿Por qué desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25" data-button-dinamic>Rechazar</a>
                @elseif(empty($oportunidad->revisado_el))
                  @if(empty($oportunidad->es_favorito))
                    <a href="/oportunidades/{{ $oportunidad->id }}/favorito" data-confirm
                        class="btn btn-sm btn-warning mr-25" data-button-dinamic>Convertir a Favorito</a>
                        @endif
                    <a href="/oportunidades/{{ $oportunidad->id }}/revisar" data-confirm
                        class="btn btn-sm btn-success mr-25" data-button-dinamic>Revisar</a>
                    <a data-confirm-input="¿Por qué desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25" data-button-dinamic>Rechazar</a>
                @else
                  @if(empty($oportunidad->es_favorito))
                    <a href="/oportunidades/{{ $oportunidad->id }}/favorito" data-confirm
                        class="btn btn-sm btn-warning mr-25" data-button-dinamic>Convertir a Favorito</a>
                        @endif
                    <a data-confirm-input="¿Por qué desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25" data-button-dinamic>Rechazar</a>
                @endif
            </div>
        </div>
        @if(empty($oportunidad->empresa_id))
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="text-center">
                  Antes de continuar, le recomendamos vincular la oportunidad a una empresa. Este proceso no volverá a repetirse para el mismo correo remitente.<br /><br />
                  <b>OJO: No ingresar una empresa nuestra, debe ingresar la empresa que solicita la cotización!</b><br /><br />
                </div>
                <div style="max-width:400px;margin:0 auto;text-align:center;">
                  <input type="text" class="form-control autocomplete"
                   data-ajax="/empresas/autocomplete" name="empresa_id" autocomplete="nope"
                   data-editable="/oportunidades/{{ $oportunidad->id }}?_update=empresa_id" placeholder="Busque la Empresa"><br /><br />
                   <button class="btn btn-sm btn-primary">Relacionar a Empresa</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
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
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        @include('licitacion.relacionadas', [
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
                <div class="row">
                  <div class="col-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                @include('oportunidad.table', compact('oportunidad'))
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-6">
                @include('actividad.create', [
                    'into' => [
                        'licitacion_id' => $oportunidad->licitacion_id,
                        'oportunidad_id' => $oportunidad->id,
                    ],
                ])
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            @if (!empty($oportunidad->id))
                                <label>Apuntes</label>
                                <div data-ishtml data-editable="/oportunidades/{{ $oportunidad->id }}?_update=observacion">
                                @if(!empty($oportunidad->observacion))
                                    {!! $oportunidad->observacion !!}
                                @else
                                <table class="table table-sm table-bordered" style="width: 100%;"><tbody>
                                <tr>
                                  <td style="max-width:33%;width: 33%;min-width: 33%;height: 40px;"></td>
                                  <td style="max-width:33%;width: 33%;min-width: 33%;"></td>
                                  <td style="max-width:33%;width: 33%;min-width: 33%;"></td>
                                </tr></tbody></table>
                                @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($oportunidad->correo_id))
            <div class="col-12">
              <h5>Requerimientos por Correo</h5>
    <div class="card">
      <div class="card-body">
    <table class="table table-sm mb-0 table-bordered table-vcenter">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Desde</th>
          <th>Asunto</th>
          <th>Adjuntos</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
@foreach($oportunidad->correosRelacionados() as $r)
        <tr>
          <td>{{ Helper::fecha($r->fecha, true) }}</td>
          <td>{{ $r->correo_desde }}</td>
          <td>{{ $r->asunto }}</td>
          <td>{{ $r->adjuntos_cantidad }}</td>
          <td><a href="javascript:void(0)" data-popup="/correos/{{ $r->id }}/ver">Abrir</a></td>
        </tr>
@endforeach
      </tbody>
    </table>
      </div>
    </div>

            </div>
            @endif
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

<style>
.editable_tag {
  margin: 0 auto;
  display: block;
  text-align: center;
}
.nota_cotizacion {
  font-size: 11px;
  text-align: center;
  margin-top: 10px;
  background: #f2f4f4;
  padding: 4px;
  border-radius: 4px;
  border: 1px solid #e3e3e3;
  color: #606060;
}
</style>
<div class="card-header">
        <h5>Relación de Cotizaciones</h5>
        <div class="heading-elements">
        <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Nueva Cotización
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                  @foreach ($oportunidad->empresasMenu() as $e)
                    <a class="dropdown-item" href="/oportunidades/{{ $oportunidad->id }}/interes/{{ $e->id }}" data-button-dinamic>Interés con {{ $e->razon_social }}</a>
                  @endforeach
                </div>
              </div>
              </div>
              </div>
        <div class="row">
            @foreach ($oportunidad->cotizando() as $e)
                <div class="col-2 col-sm-2" style="min-width: 250px;">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title" style="font-size: 15px;">
                              {{ substr($e->razon_social,0,18) }}<br />
                              @if(!empty($e->cotizacion))
                              <span class="small">{{ Helper::fecha($e->cotizacion->interes_el) }} - {{ $e->cotizacion->interes_por }}</span>
                              @else
                              <span class="small">{{ $e->ruc }}</span>
                              @endif
                            </h6>
                            @if(!empty($e->cotizacion))
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>
                <i class="bx bx-dots-vertical-rounded" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/expediente"><i class="bx bx-blanket"></i>Expediente</a>
                  <a class="dropdown-item" href="javascript:void(0);" data-popup="/documentos/visor?path={{ $e->cotizacion->folder(true) }}&oid={{ $oportunidad->id }}&cid={{ $e->cotizacion->id }}">Mi Carpeta</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/">Colocar Precio</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/registrar" target="_blank">Cotización por Items</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/exportar#" target="_blank"><i class="bx bx-download"></i>Descargar PDF</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/registrarParticipacion" data-confirm data-button-dinamic>1. Registrar Participación</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/registrarPropuesta" data-confirm data-button-dinamic>2. Registrar Propuesta</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/proyecto" data-confirm data-button-dinamic>Convertir a Proyecto</a>
                </div>
              </li>
            </ul>
          </div>
                          @endif
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                {{ $e->descripcion }}
                                @if (empty($oportunidad->revisado_el) && false)
                                    <div>Debe marcar como <b>REVISADO</b></div>
                                @elseif(empty($e->cotizacion) && (strtotime($oportunidad->fecha_participacion_hasta) > time() || empty($oportunidad->licitacion_id)))
                                    <div class="text-center">
                                        <a class="btn btn-sm btn-success"
                                            href="/oportunidades/{{ $oportunidad->id }}/interes/{{ $e->id }}" data-confirm data-button-dinamic>Interés</a>
                                    </div>
                                @elseif(empty($e->cotizacion) && strtotime($oportunidad->fecha_participacion_hasta) <= time())
                                    <div><i>Fuera de plazo</i></div>
                                @else
@php
/*<div style="padding-bottom: 15px;">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=rotulo" placeholder="Rótulo" value="{{ $e->cotizacion->rotulo }}">
<input class="editable_tag" type="number" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=monto" placeholder="Monto" value="{{ $e->cotizacion->monto }}" min="0" max="999999999" step="0.01">
<input class="editable_tag" type="date" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=fecha" placeholder="Fecha" value="{{ $e->cotizacion->fecha }}">
<input class="editable_tag" type="date" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=validez" placeholder="Validez" value="{{ $e->cotizacion->validez }}">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=plazo_instalacion" placeholder="Instalación" value="{{ $e->cotizacion->plazo_instalacion }}">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=plazo_servicio" placeholder="Servicio" value="{{ $e->cotizacion->plazo_servicio }}">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=plazo_garantia" placeholder="Garantía" value="{{ $e->cotizacion->plazo_garantia }}">
</div>*/
@endphp

<div class="pb-0 d-flex align-items-center" title="Participación: por {{ $e->cotizacion->participacion_por }} el {{ Helper::fecha($e->cotizacion->participacion_el, true) }}">
  @if (empty($e->cotizacion->participacion_el))
    @if (!$e->cotizacion->estado_participacion()['timeout'])
      @if(!empty($e->cotizacion->seace_participacion_log))
      <i class="cursor-pointer bx bx-radio-circle-marked text-danger mr-25"></i>
      <small>Registro sin exito.</small>
      @else
      <i class="cursor-pointer bx bx-radio-circle-marked text-warning mr-25"></i>
      <small>Pendiente</small>
      @endif
    @else
    <i class="cursor-pointer bx bx-radio-circle-marked text-danger mr-25"></i>
    <small>{{ $e->cotizacion->estado_participacion()['message'] }}</small>
    @endif
  @else
    <i class="cursor-pointer bx bx-radio-circle-marked text-success mr-25"></i>
    <small>{{ $e->cotizacion->estado_participacion()['message'] }} ({{ $e->cotizacion->participacion_por }})</small>
  @endif
</div>
<div class="pb-1 d-flex align-items-center" title="Propuesta: por {{ $e->cotizacion->participacion_por }} el {{ Helper::fecha($e->cotizacion->participacion_el, true) }}">
  @if (empty($e->cotizacion->propuesta_el))
    @if (!$e->cotizacion->estado_propuesta()['timeout'])
      <i class="cursor-pointer bx bx-radio-circle-marked text-warning mr-25"></i>
      <small>Pendiente</small>
    @else
    <i class="cursor-pointer bx bx-radio-circle-marked text-danger mr-25"></i>
    <small>{{ $e->cotizacion->estado_propuesta()['message'] }}</small>
    @endif
  @else
    <i class="cursor-pointer bx bx-radio-circle-marked text-success mr-25"></i>
    <small>{{ $e->cotizacion->estado_propuesta()['message'] }} ({{ $e->cotizacion->propuesta_por }})</small>
  @endif
</div>
<div>
<input class="editable_tag" type="number" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=monto" placeholder="Monto" value="{{ $e->cotizacion->monto }}" min="0" max="999999999" step="0.01">
</div>
@if(!empty($e->cotizacion->elaborado_step))
<div class="nota_cotizacion">
  @if(!empty($e->cotizacion->finalizado_por))
  Elaborado por <b>{{ $e->cotizacion->finalizado_por }}</b><br />
  @if($e->cotizacion->revisado_status)
  <div style="color:green">Aprobado por <b>{{ $e->cotizacion->revisado_por }}</b></div>
  @else
  <div style="color:red">Observado por <b>{{ $e->cotizacion->revisado_por }}</b></div>
  @endif
  @else
  En desarrollo por <b>{{ $e->cotizacion->elaborado_por }}</b> en P#{{ $e->cotizacion->elaborado_step }}<br />
  @endif
</div>
@endif

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-6">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">
                        Oportunidades Similares
                    </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                      <div data-block-dinamic="/oportunidades/{{ $oportunidad->id }}/part/oportunidades_similares"></div>
                    </div>
                </div>
            </div>

            </div>
            <div class="col-6">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">
                        Licitaciones Similares
                    </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                      <div data-block-dinamic="/oportunidades/{{ $oportunidad->id }}/part/licitaciones_similares"></div>
                    </div>
                </div>
            </div>


            </div>
        </div>
        <div>







            
        </div>
    </section>
@endsection


@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/dragula.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/widgets.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Bucket.css') }}">
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
    <script src="{{ asset('js/Bucket.js') }}"></script>
@endsection

