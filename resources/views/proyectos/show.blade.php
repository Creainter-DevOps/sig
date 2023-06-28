@extends('layouts.contentLayoutMaster')
@section('title','Users View')
@section('page-styles')
@parent
<link rel="stylesheet" type="text/css" href="{{asset('css/Bucket.css')}}">
@endsection
@section('content')
<div style="background: #fff;height: inherit;">
  <nav style="background: #596dff;color: #fff;">
    <div style="padding: 10px 20px;position:relative;height: 110px;">
      <div style="font-size: 15px;color: #ffffff;">{{ $proyecto->codigo }}</div>
      <div style="position: absolute;right: 30px;top: 15px;">
        <a href="javascript:wdir('{{ $proyecto->folder(true) }}');" style="color:#fff">/{{ $proyecto->folder(true) }}</a>
      </div>
      <div style="position: absolute;left: 20px;top: 30px;max-width: 930px;">
        <div style="text-overflow: ellipsis;overflow: hidden;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;color: #ffffff;font-size: 17px;background: #ffffff21;padding: 10px;border-radius: 5px;margin: 5px 0;height: 60px;">
        {{ $proyecto->rotulo }}
        </div>
        <div style="">
        {{ $proyecto->cliente()->empresa()->razon_social }}
        </div>
      </div>
    </div>
    <div>
     <ul class="nav nav-tabs justify-content-end" role="tablist" style="margin: 0;padding: 0 20px;">
              <li style="margin-right: 5px;">
                <a class="nav-link active" id="home-tab-end" data-toggle="tab" href="#home-align-end"
                  aria-controls="home-align-end" role="tab" aria-selected="true" style="padding: 5px 15px;">
                  Principal
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link" id="actividades-tab-end" data-toggle="tab" href="#actividades-align-end"
                  aria-controls="actividades-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Registro de Actividades
                </a>
              </li>
              @if(!empty($proyecto->licitacion_id))
              <li style="margin-right: 5px;">
                <a class="nav-link" id="licitacion-tab-end" data-toggle="tab" href="#licitacion-align-end"
                  aria-controls="licitacion-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Licitación
                </a>
              </li>
              @endif
              <li style="margin-right: 5px;">
                <a class="nav-link" id="cartas-tab-end" data-toggle="tab" href="#cartas-align-end"
                  aria-controls="cartas-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Cartas
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link" id="entregable-tab-end" data-toggle="tab" href="#entregable-align-end"
                  aria-controls="entregable-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Entregables
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link" id="pagos-tab-end" data-toggle="tab" href="#pagos-align-end"
                  aria-controls="pagos-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Pagos
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link" id="gastos-tab-end" data-toggle="tab" href="#gastos-align-end"
                  aria-controls="gastos-align-end" role="tab" aria-selected="false" style="padding: 5px 15px;">
                  Gastos
                </a>
              </li>
              <li style="margin-right: 5px;">
                <a class="nav-link" href="/proyectos/68/financiero" target="_blank" style="padding: 5px 15px;">
                  Contable
                </a>
              </li>
            </ul> 
    </div>
  </nav>
  <div style="padding:15px 20px;">

            <div class="tab-content">
              <div class="tab-pane active" id="home-align-end" aria-labelledby="home-tab-end" role="tabpanel">
                <div class="row">
                  <div class="col-6">
<div class="row">
    <div class="col-4">
      <div class="card text-center mb-1" style="background: #63c76b;">
        <div class="card-content">
          <div class="card-body p-1">
            <p class="mb-0 line-ellipsis" style="color:#fff;">Pagos</p>
            <h4 class="mb-0" style="color:#fff;">Pend. {{ Helper::money($proyecto->meta()->pago_pendiente, 1) }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card text-center mb-1" style="background: #63c76b;">
        <div class="card-content">
          <div class="card-body p-1">
            <p class="mb-0 line-ellipsis" style="color:#fff;">Orden</p>
            <h4 class="mb-0" style="color:#fff;">Pend. {{ Helper::money($proyecto->meta()->gasto_pendiente, 1) }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card text-center mb-1" style="background: #63c76b;">
        <div class="card-content">
          <div class="card-body p-1">
            <p class="mb-0 line-ellipsis" style="color:#fff;">Rendición</p>
            <h4 class="mb-0" style="color:#fff;">Pend. {{ Helper::money($proyecto->meta()->liquido_total, 1) }}</h4>
          </div>
        </div>
      </div>
    </div>
</div>
                  </div>
                  <div class="col-6">
                    @include('proyectos.table', compact('proyecto'))
                  </div>
              </div>
              </div>
              <div class="tab-pane" id="actividades-align-end" aria-labelledby="actividades-tab-end" role="tabpanel">
              @include('actividad.create', [
                    'into' => [
                        'proyecto_id' => $proyecto->id,
                        'oportunidad_id' => $proyecto->oportunidad()->id,
                        'licitacion_id' => $proyecto->oportunidad()->licitacion_id,
                    ],
                ])
              </div>
              @if(!empty($proyecto->licitacion_id))
              <div class="tab-pane" id="licitacion-align-end" aria-labelledby="licitacion-tab-end" role="tabpanel">
                <div class="row">
                  <div class="col-6">
                    @include('licitacion.table', ['licitacion' => $proyecto->oportunidad()->licitacion()])
                  </div>
                  <div class="col-6">
                    @include('licitacion.cronograma', ['licitacion' => $proyecto->oportunidad()->licitacion()])
                  </div>
                </div>
              </div>
              @endif
              <div class="tab-pane" id="cartas-align-end" aria-labelledby="cartas-tab-end" role="tabpanel">
                @include('proyectos.cartas')
              </div>
              <div class="tab-pane" id="entregable-align-end" aria-labelledby="entregable-tab-end" role="tabpanel">
                @include('proyectos.entregables')
              </div>
              <div class="tab-pane" id="pagos-align-end" aria-labelledby="pagos-tab-end" role="tabpanel">
                @include('proyectos.pagos')
              </div>
              <div class="tab-pane" id="gastos-align-end" aria-labelledby="gastos-tab-end" role="tabpanel">
              @include('proyectos.ordenes')
              </div>
            </div>
            </div>
  </div>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
<script src="{{asset('js/Bucket.js')}}"></script>
@endsection
