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
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;text-align:right;">
          <a class="btn btn-default" href="/oportunidades/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
              Nuevo
          </a>
        </div>
    </div>
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Oportunidades</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm mb-0" style="width:100%">
      <thead>
        <tr>
          <th style="width:150px;">Código</th>
          <th>Cliente</th>
          <th>Rótulo</th>
          <th>Fecha Inicio</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach ($listado as $oportunidad)
        <tr>
          <td><div>{{ $oportunidad->codigo }}</div></td>
          <td>{{ (!empty($oportunidad->cliente()) ? $oportunidad->cliente()->empresa()->rotulo() : '') }}</td>
          <td>{{ $oportunidad->rotulo() }}</td>
          <td>{{ Helper::fecha($oportunidad->created_on) }}</td>
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
