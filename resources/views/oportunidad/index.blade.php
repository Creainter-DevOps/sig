@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Oportunidades')
{{-- vendor style --}}
@section('vendor-styles')
@endsection
{{-- page style --}}
@section('page-styles')
@endsection

@section('content')
    <div class="row">
        <div class="offset-12 col-md-3" style="margin-bottom: 10px;">
          <!--<a class="btn btn-primary" href="/cotizaciones/crear" style="" target="_blank"> + Nueva Cotización </a>-->
          <a class="btn btn-primary" href="/oportunidades/crear" style="" target="_blank"> + Oportunidad </a>
        </div>
    </div>
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <!--<div class="card-header">
        <h4 class="card-title">Oportunidades</h4>
      </div>-->
      <div class="card-content">
        <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
<!--          <th style="width:150px;">Código</th> -->
          <th>Cliente</th>
          <th>Rótulo</th>
          <th>Solicitado</th>
          <th>Respondido</th>
          <th>Costos</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach ($listado as $oportunidad)
        <tr>
          <td style="width: 200px;">
          {{ $oportunidad->institucion() }}
          </td>
          @if($oportunidad->automatica)
          <td><i class="ficon bx bx-cloud" style="color:#00c506;"></i> {{ $oportunidad->rotulo() }}</td>
          @else
          <td>{{ $oportunidad->rotulo() }}</td>
          @endif
          <td style="width:100px;" title="{{ Helper::fecha($oportunidad->fecha_participacion, true) }}">{{ Helper::tiempo_transcurrido($oportunidad->fecha_participacion) }}</td>
          <td style="width:100px;" title="{{ Helper::fecha($oportunidad->fecha_propuesta, true) }}">{{ Helper::tiempo_transcurrido($oportunidad->fecha_propuesta) }}</td>
          <td style="width:100px;">{{ Helper::money($oportunidad->precios()->promedio, $oportunidad->precios()->moneda_id) }}</td>
          <td class="text-center py-1">
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                </span>
                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(19px, -7px, 0px);">
                  <a class="dropdown-item" href="/oportunidades/{{ $oportunidad->id }}/"><i class="bx bx-show-alt mr-1"></i> Ver mas</a>
                  <a class="dropdown-item" href="/oportunidades/{{ $oportunidad->id }}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="/oportunidades/{{ $oportunidad->id }}" href="#" > <i class="bx bx-trash mr-1"></i> Eliminar</a> 
                </div>
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
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
@endsection
{{-- page scripts --}}
@section('page-scripts')
@endsection
