@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Actividades')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/themes/layout.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/themes/layout.css') }}">
@endsection

@section('content')
<!-- table Transactions start -->
<div class="row">
        <div class="offset-12 col-md-1" style="margin-bottom: 10px;text-align:right;">
                <a class="btn btn-default" href="/actividades/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
                    Nuevo
                </a>
        </div>
  </div>
<!-- table Transactions end -->

<!-- table success start -->
<section id="table-success">
  <div class="card">
    <!-- datatable start -->
    <div class="card-body" >
    <div class="table-responsive table-sm ">
      <table id="table-extended-success" class="table mb-0">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Creado por</th>
            <th>Asignado A</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach ( $listado as $actividad ) 
          <tr>
            <td class="">{{ strtoupper( $actividad->tipo() ) }}</td>
            <td class="">{{ strtoupper( $actividad->evento ) }}</td>
            <td class="pr-0">{{ substr( $actividad->texto ,0 , 40 ) }}</td>
            <td class="text-success" align ="left" >{{ $actividad->creado() }}</td>
            <td class="text-uppercase" align ="left" >{{ $actividad->usuario_id }}</td>
            <td>
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-2 dropdown-toggle nav-hide-arrow cursor-pointer"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route( 'actividades.show', [ 'actividad' => $actividad->id ] ) }}"><i class="bx bx-show-alt mr-1"></i> Ver más</a>
                  <a class="dropdown-item" href="{{ route( 'actividades.edit', [ 'actividad' => $actividad->id ] ) }}"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="{{ route('actividades.destroy', [ 'actividad' => $actividad->id ])}}" href="#" >
                    <i class="bx bx-trash mr-1"></i> Eliminar</a>
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
    <!-- datatable ends -->
  </div>
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
@endsection
