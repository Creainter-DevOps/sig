@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Detalle Cotizacion')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}"> 
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<style>
tr.block_header {
  cursor: pointer;
}
tr.block_details {
  display:none;
}
tr.block_details > td {
  padding: 5px;
}
tr.block_details > td > div {
  background: #f2f4f4;
  border-radius: 2px;
  padding: 5px;
  margin: 5px 10px;
  color: #000;
}
.btns_actions {
  color: #fff;
  text-align: right;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-7">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="https://sig.creainter.com.pe/images/portrait/small/avatar-s-26.jpg" alt="users view avatar" class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h4 class="media-heading">{{ $cotizacion->descripcion}}  </h4>
          <span>{{ $cotizacion->codigo }} </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Profile</a>
      <a href="https://sig.creainter.com.pe/page-users-edit" class="btn btn-sm btn-primary">Edit</a>
    </div>
  </div>
<div class="row">
<div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          @include('clientes.table', ['cliente' => $cotizacion->oportunidad()->cliente() ])
        </div>
      </div>
   </div>
</div>
<div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          @include('oportunidad.table', ['oportunidad' => $cotizacion->oportunidad()])
        </div>
      </div>
   </div>
</div>
<div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          @include('cotizacion.table', compact('cotizacion'))
        </div>
      </div>
   </div>
</div>
<div class="col-md-12">
@if(!empty($cotizacion->cliente_id )) 
@endif
</div>
<div class="col-6 col-sm-6">
    <!-- Timeline Widget Starts -->
    @include('cotizacion.timeline') 
</div>
</div>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
