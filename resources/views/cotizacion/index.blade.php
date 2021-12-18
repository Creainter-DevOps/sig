@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice List')
{{-- vendor style --}}
@section('vendor-styles')
@endsection
{{-- page style --}}
@section('page-styles')
@endsection

@section('content')
  <div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;text-align:right;">
                <a class="btn btn-default" href="/cotizaciones/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
                    Nuevo
                </a>
        </div>
  </div>
  <div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Cotizaciones</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">
          <table class="table table-sm mb-0"  style="width:100%">
            <thead>
              <tr>
                  <th>Código</th>
                  <th>Cliente</th>
                  <th>Oportunidad</th>
                  <th>M.Total</th>
                  <th>M.Fecha</th>
                  <th>Validez</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-body" >
                @foreach ( $listado as $cotizacion )
                <tr>
                  <td>{{ $cotizacion->numero }}</td>
                  <td class="pr-0"> {{ null !==  $cotizacion->oportunidad()->cliente() ? $cotizacion->oportunidad()->cliente()->rotulo() : ''  }} </td>
                  <td class="pr-0"> {{ !empty($cotizacion->oportunidad()) ? $cotizacion->oportunidad()->rotulo() : '' }} </td>
                  <td class="text-success" align="left" >{{ $cotizacion->monto() }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->fecha ) }}</td>
                  <td class="">{{ Helper::fecha( $cotizacion->validez ) }}</td>
                  <td>
                    <div class="dropdown">
                      <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/cotizaciones/{{$cotizacion->id}}"><i class="bx bx-show-alt mr-1"></i> Ver más</a>
                        <a class="dropdown-item" href="/cotizaciones/{{$cotizacion->id}}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                        <a class="dropdown-item" data-confirm-remove="{{ route('cotizaciones.destroy', ['cotizacion' => $cotizacion->id ]) }}" href="#" >
                         <i class="bx bx-trash mr-1"></i> Eliminar</a>
                      </div>
                    </div>
                  </td>
              </tr> 
              @endforeach 
              </tbody>
              </table>
         {{-- <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div> --}}
           </div>
          </div>
          <div class="card-footer">
            {{ $listado->links() }}  
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
