@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Contactos')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
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
                <a class="btn btn-default" href="/personales/crear" style="color: #fff; background-color: #007bff; border-color: #007bff;">
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
            <th>Doc. Tipo</th>
            <th>Doc. Numero</th>
            <th>Nombres</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach ( $listado as $personal)
          <tr>
            <td class="pr-0">{{ $personal->documento_tipo }}</td>
            <td class="pr-0">{{ $personal->documento_numero }}</td>
            <td class="pr-0">{{ $personal->nombres }}</td>
            <td>
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-2 dropdown-toggle nav-hide-arrow cursor-pointer"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route( 'personales.show', [ 'personal' => $personal->id ] ) }}"><i class="bx bx-show-alt mr-1"></i> Ver más</a>
                  <a class="dropdown-item" href="{{ route( 'personales.edit', [ 'personal' => $personal->id ] ) }}"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="{{ route('personales.destroy', [ 'personal' => $personal->id ])}}" href="#" ><i class="bx bx-trash mr-1"></i> Eliminar</a>
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
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/basic.crud.js')}}"></script>

@endsection
{{-- page scripts --}}
@section('page-scripts')
  <script src="{{asset('js/scripts/cotizacion/index.js')}}"></script>
@endsection
