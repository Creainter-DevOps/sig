@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Productos')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/themes/layout.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/themes/layout.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;">
          <a class="btn btn-primary" href="/productos/crear"> + Nuevo</a>
        </div>
    </div>
<div  class="row" id="basic-table">
    <!-- datatable start -->
    <div class="col-12">
    <div class="card">
    <div class="card-body" >
    <div class="table-responsive">
      <table class="table table-sm" id="table-extended-success" class="table mb-0">
        <thead>
          <tr>
            <th>Nombres</th>
            <th>Descripcion</th>
            <th>Precio U.</th>
            <th>Unidad</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach ( $listado as $producto ) 
          <tr>
            <td class="pr-0">{{ $producto->nombre }}</td>
            <td class="text-success" align ="left" >{{ $producto->descripcion }}</td>
            <td class="text-success" align ="left" >{{ Helper::money( $producto->precio_unidad,$producto->moneda_id ) }}</td>
            <td class="text-success" align ="left" >{{ $producto->unidad }}</td>
            <td class="text-success" align ="left" >{{ $producto->modelo }}</td>
            <td class="text-success" align ="left" >{{ $producto->marca }}</td>
            <td>
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-2 dropdown-toggle nav-hide-arrow cursor-pointer"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route( 'productos.show', [ 'producto' => $producto->id ] ) }}"><i class="bx bx-show-alt mr-1"></i> Ver m??s</a>
                  <a class="dropdown-item" href="{{ route( 'productos.edit', [ 'producto' => $producto->id ] ) }}"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="productos/{{ $producto->id }}"><i class="bx bx-trash mr-1"></i> Eliminar</a>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    </div>

      <div class="card-footer" >
       {{ $listado->links() }}
       </div>
       <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div>
      </div>
    </div>
    <!-- datatable ends -->
  </div>
  </div>
</div>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
<script src="{{asset('js/scripts/helpers/basic.crud.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
  <script src="{{asset('js/scripts/cotizacion/index.js')}}"></script>
@endsection
