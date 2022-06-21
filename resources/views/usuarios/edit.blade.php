@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Editar cliente')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection

@section('content')
<div class="row" id="basic-table">
  <div class="col-12">
<div class="card">
        <div class="card-header">
          <h4 class="card-title">Editar Cliente</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form form-horizontal form-data" action="/clientes/{{ $cliente->id }}" method="POST">
              <div class="form-body">
                {!! method_field('PUT') !!}
                  @include('clientes.form')
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
  <div>
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
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
@endsection
