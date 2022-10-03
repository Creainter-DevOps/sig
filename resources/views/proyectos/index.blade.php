@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Proyectos')
{{-- vendor style --}}
@section('vendor-styles')
@endsection
{{-- page style --}}
@section('page-styles')
@endsection

@section('content')
    <!--<div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;text-align:right;">
          <a class="btn btn-default" href="/proyectos/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
              Nuevo
          </a>
        </div>
    </div>-->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <!--<div class="card-header">
        <h4 class="card-title">Proyectos</h4>
      </div>-->
      <div class="card-content">
        <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th style="width:200px;">Código</th>
          <th>Empresa</th>
          <th>Cliente</th>
          <th>Rótulo</th>
          <th>Estado</th>
          <th>Fecha Inicio</th>
          <th>Fecha Límite</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach ($listado as $proyecto)
        <tr>
          <td>{{ $proyecto->cotizacion_id }}</td>
          <td style="text-align:center;"><a href="/proyectos/{{ $proyecto->id }}/"><div style="color:#fff;padding:2px;background-color:#b3b3b3;background:{{ $proyecto->color }}">{{ $proyecto->codigo }}</div></a></td>
          <td>{{ isset($proyecto->empresa_id) ?   $proyecto->empresa()->rotulo() : ''  }}</td>
          <td>{{ $proyecto->oportunidad()->institucion() }}</td>
          <td>{{ $proyecto->rotulo }}</td>
          <td><div style="background-color:{{ $proyecto->estadoArray()['color'] }};font-size: 11px;padding: 2px;border-radius: 3px;color: #fff;text-align: center;">{{ $proyecto->estadoArray()['name'] }}</div></td>
          <td>{{ Helper::fecha($proyecto->fecha_desde) }}</td>
          <td>{{ Helper::fecha($proyecto->fecha_hasta) }}</td>
          <td class="text-center py-1">
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                </span>
                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(19px, -7px, 0px);">
                  <a class="dropdown-item" href="/proyectos/{{ $proyecto->id }}/"><i class="bx bx-show-alt mr-1"></i> Ver mas</a>
                  <a class="dropdown-item" href="/proyectos/{{ $proyecto->id }}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="/proyectos/{{ $proyecto->id }}" href="#" > <i class="bx bx-trash mr-1"></i> Eliminar</a> 
                </div>
              </div>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
      </div>
      </div>
      <div class="card-footer"> 
        {{ $listado->links() }}
      </div>   
      <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div>
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
