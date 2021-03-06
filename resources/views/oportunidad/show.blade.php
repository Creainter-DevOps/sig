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
            content: "???";
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
                        <span>Licitaci??n del SEACE</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
              @if($oportunidad->estado()['timeout'] && !empty($oportunidad->aprobado_el) && empty($oportunidad->archivado_el))
                <a data-confirm-input="??Por qu?? desea Archivarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/archivar"
                        class="btn btn-sm btn-danger mr-25">Archivar</a>
                @elseif (!empty($oportunidad->rechazado_el))
                    <div class="text-center">Rechazado el {{ Helper::fecha($oportunidad->rechazado_el, true) }}</div>

                @elseif(!empty($oportunidad->archivado_el))
                    <div class="text-center">Archivado el {{ Helper::fecha($oportunidad->archivado_el, true) }}</div>

                @elseif(empty($oportunidad->aprobado_el))
                    <a href="/oportunidades/{{ $oportunidad->id }}/aprobar"
                        class="btn btn-sm btn-success mr-25">Aprobar</a>
                    <a data-confirm-input="??Por qu?? desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25">Rechazar</a>
                @elseif(empty($oportunidad->revisado_el))
                    <a href="/oportunidades/{{ $oportunidad->id }}/revisar"
                        class="btn btn-sm btn-success mr-25">Revisar</a>
                    <a data-confirm-input="??Por qu?? desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25">Rechazar</a>
                @elseif($oportunidad->estado == 'PENDIENTE')
                    <a data-confirm-input="??Por qu?? desea Rechazarlo?"
                        href="/oportunidades/{{ $oportunidad->id }}/rechazar"
                        class="btn btn-sm btn-danger mr-25">Rechazar</a>
                @else
                    <a data-confirm-input="??Por qu?? desea Archivarlo?"
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
    position:relative;
    padding: 3px;
    font-size: 9px;
    box-shadow: none;
    border: 1px solid #4b87f5;
    background: #fff;
    color: #000;
    border-radius: 4px;
    min-width: 30px;
    width: 90px;
    display: inline-block;
    outline: none;
    text-align:center;
}
.editable_tag:after {
  position: absolute;
  content: atr(title);
  background: red;
  width: 100px;
  height:20px;
  color:#000;
}
.editable_tag:focus {
    background: #fff;
    color: #000;
    border: 1px solid #878787;
    width: 99%;
    outline: none;
    font-size: 11px;
    padding: 5px;
    margin: 4px 0;
    text-align:center;
}

.editable_tag::placeholder {
  color: #b3b3b3;
  opacity: 1;
  font-size:10px;
  background: #e1e0e0!important;
}

</style>
        <h5>Elaboraci??n de Propuestas</h5>
        <div class="row">
            @foreach ($oportunidad->empresas() as $e)
                <div class="col-2 col-sm-2">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title" style="font-size: 15px;">
                              {{ $e->razon_social }}<br />
                              @if(!empty($e->cotizacion))
                              <span class="small">{{ $e->cotizacion->nomenclatura() }}</span>
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
                  <a class="dropdown-item" href="javascript:void(0);" data-popup="/documentos/visor?path={{ $e->cotizacion->folder(true) }}&oid={{ $oportunidad->id }}&cid={{ $e->cotizacion->id }}">Mi Carpeta</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/registrar" target="_blank">Cotizaci??n por Items</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/exportar" target="_blank">Descargar PDF</a>
                  <a class="dropdown-item" href="/expediente/{{ $e->cotizacion->id }}/inicio" target="_blank">Abrir Expediente de Propuesta</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/enviar" data-confirm>Marcar como enviado</a>
                  <a class="dropdown-item" href="/cotizaciones/{{ $e->cotizacion->id }}/proyecto" data-confirm>Convertir a Proyecto</a>
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
                                @elseif(empty($e->cotizacion) && strtotime($oportunidad->fecha_participacion_hasta) > time())
                                    <div class="text-center">
                                        <a class="btn btn-sm btn-success"
                                            href="/oportunidades/{{ $oportunidad->id }}/interes/{{ $e->id }}">Inter??s</a>
                                    </div>
                                @elseif(empty($e->cotizacion) && strtotime($oportunidad->fecha_participacion_hasta) <= time())
                                    <div>Fuera de plazo</div>
                                @else
<div style="padding-bottom: 15px;">                                
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=rotulo" placeholder="R??tulo" value="{{ $e->cotizacion->rotulo }}">
<input class="editable_tag" type="number" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=monto" placeholder="Monto" value="{{ $e->cotizacion->monto }}" min="0" max="999999999" step="0.01">
<input class="editable_tag" type="date" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=fecha" placeholder="Fecha" value="{{ $e->cotizacion->fecha }}">
<input class="editable_tag" type="date" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=validez" placeholder="Validez" value="{{ $e->cotizacion->validez }}">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=plazo_instalacion" placeholder="Instalaci??n" value="{{ $e->cotizacion->plazo_instalacion }}">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=plazo_servicio" placeholder="Servicio" value="{{ $e->cotizacion->plazo_servicio }}">
<input class="editable_tag" type="text" data-editable="/cotizaciones/{{ $e->cotizacion->id }}?_update=plazo_garantia" placeholder="Garant??a" value="{{ $e->cotizacion->plazo_garantia }}">
</div>
                                    <div class="wrapper">
                                        <ul class="StepProgress">
                                            <li class="StepProgress-item is-done">
                                                <strong>Participaci??n</strong>
                                                    <div class="text-center mb-1">
                                                        <span
                                                            class="{{ $e->cotizacion->estado_participacion()['class'] }}">{{ $e->cotizacion->estado_participacion()['message'] }}</span>
                                                            @if (empty($e->cotizacion->participacion_el))
                                                              @if (!$e->cotizacion->estado()['timeout'])
                                                                <div style="text-align: center;margin-top: 5px;font-size:10px;">
                                                                @if(!empty($e->cotizacion->seace_participacion_log))
                                                                  Se ha intentado realizar el registro autom??tico sin ??xito. Debe hacerlo manualmente en el SEACE y posteriormente hacer click abajo.<br/>
                                                                @endif
                                                                <a href="/cotizaciones/{{ $e->cotizacion->id }}/registrarParticipacion">Registrar Participaci??n</a>
                                                                </div>
                                                              @endif
                                                            @else
                                                              <div style="text-align: center;margin-top: 5px;font-size:10px;">
                                                                Registrado por {{ $e->cotizacion->participacion_por }} el {{ Helper::fecha($e->cotizacion->participacion_el, true) }}
                                                              </div>
                                                            @endif

                                                    </div>
                                            </li>
                                            <li class="StepProgress-item is-done">
                                                <strong>Propuesta</strong>
                                                <div class="text-center mb-1">
                                                @if (!empty($e->cotizacion))
                                                        <span
                                                            class="{{ $e->cotizacion->estado_propuesta()['class'] }}">{{ $e->cotizacion->estado_propuesta()['message'] }}</span>
                                                @endif
                                                @if (!$e->cotizacion->estado()['timeout'])
                                                    <div style="text-align: center;margin-top: 5px;font-size:10px;">
                                                      Puede hacer uso de nuestra Mesa de trabajo para desarrollar sus expediente como su propuesta comercia, debe hacer click abajo.<br/>
                                                      <a href="/expediente/{{ $e->cotizacion->id }}/inicio">Elaborar Expediente</a>
                                                      @if(!empty($e->cotizacion->elaborado_por))
                                                        <div>
                                                        por {{ $e->cotizacion->elaborado_por }}
                                                        </div>
                                                      @endif
                                                    </div>
                                                @else
                                                  <div style="text-align: center;margin-top: 5px;font-size:10px;">
                                                      El plazo ha vencido, si ha enviado manualmente al seace haga click abajo.<br/>
                                                      <a href="/cotizaciones/{{ $e->cotizacion->id }}/enviar" data-confirm>S?? he enviado</a>
                                                @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            @if(!empty($e->cotizacion))
                            <div style="position: absolute;bottom: 3px;right: 10px;font-size: 11px;">Registrado por {{ $e->cotizacion->interes_por }}</div>
                            @endif
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
                        <table class="table mb-0 table-sm" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <td>Servicio</th>
                                    <td>Monto</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($oportunidad->similares() as $s)
                                    <tr>
                                        <td>
                                            <div style="font-weight: bold;font-size: 9px;">
                                                {{ $s->entidad }} - {{ $s->anho }}</div>
                                            <div style="">{{ strtoupper($s->rotulo) }}</div>
                                        </td>
                                            <td colspan="1" style="width:80px;font-size:11px;text-align:right;">
                                                123</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

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
                        <table class="table mb-0 table-sm" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <td>Servicio</th>
                                    <td>Min</th>
                                    <td>Prom.</td>
                                    <th>Max.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($oportunidad->licitaciones_similares() as $s)
                                    <tr>
                                        <td>
                                            <div style="font-weight: bold;font-size: 9px;">{{ $s->licitaciones }} x
                                                {{ $s->entidad }} - {{ $s->anho }}</div>
                                            <div style="">{{ $s->rotulo }}</div>
                                            <div>
                                                @foreach (explode(',', $s->ids) as $l)
                                                    <a href="/licitaciones/{{ $l }}/detalles"
                                                        style="margin-right:5px;">{{ $l }}</a>
                                                @endforeach
                                            </div>
                                        </td>
                                        @if ($s->minimo == $s->maximo)
                                            <td colspan="3" style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->minimo) }}</td>
                                        @else
                                            <td style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->minimo) }}</td>
                                            <td style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->promedio) }}</td>
                                            <td style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->maximo) }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

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

