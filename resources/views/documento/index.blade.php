@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Documentos')
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
  <div class="offset-12 col-md-1" style="margin-bottom: 10px;">
    <a class="btn btn-primary" href="/documentos/crear" >
        Nuevo
    </a>
  </div>
</div>
<!-- table Transactions end -->

<!-- table success start -->
<section id="table-success">
  <div class="card">
    <div class="card-body">

    <div id="Bucket" data-path="/"></div>


    <div class="table-responsive table-sm ">
      <table id="table-extended-success" class="table mb-0">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Rotulo</th>
            <th>Archivo</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach ( $listado as $documento)
          <tr>
            <td class="pr-0">{{ $documento->tipo }}</td>
            <td class="pr-0">{{ $documento->rotulo }}</td>
            <td class="pr-0">{{ $documento->archivo }}</td>
            <td>
              <div class="dropdown">
                <span class="bx bx-dots-vertical-rounded font-medium-2 dropdown-toggle nav-hide-arrow cursor-pointer"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route( 'documentos.edit', [ 'documento' => $documento->id ] ) }}"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                  <a class="dropdown-item" data-confirm-remove="{{ route('documentos.destroy', [ 'documento' => $documento->id ])}}" href="#" ><i class="bx bx-trash mr-1"></i> Eliminar</a>
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
  <script src="{{asset('js/Bucket.js')}}"></script>
  <script>
    Bucketjs.capture(document.getElementById('Bucket'));
  </script>
@endsection
