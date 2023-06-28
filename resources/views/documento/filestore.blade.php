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
<link rel="stylesheet" type="text/css" href="{{ asset('css/Bucket.css') }}">
@endsection

@section('content')
<section id="table-success">
  <div class="card">
    <div class="card-body">

    <div id="Bucket" data-bucket="1" data-path="/" data-upload="true"></div>

    </div>
  </div>
</section>
  <script src="{{asset('js/Bucket.js')}}"></script>
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
    (new Bucketjs).capture(document.getElementById('Bucket'));
  </script>
@endsection
