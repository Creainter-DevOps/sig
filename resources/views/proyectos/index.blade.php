@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Proyectos')
{{-- vendor style --}}
@section('vendor-styles')
@endsection
{{-- page style --}}
@section('page-styles')
@endsection
@php
 $did = uniqid();
@endphp
@section('content')
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <table id="{{ $did }}"></table>
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
<script>
        var tablaPautas = Tablefy({
            title: 'RELACIÓN DE PROYECTOS',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/proyectos/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Código',
                width: 100,
                style: {'text-align':'center'},
              },
              {
                name: 'Tipo',
                width: 80,
              },
              {
                name: 'Proveedor',
                width: 150,
              },
              {
                name: 'Cliente',
                width: 250,
              },
              {
                name: 'Rótulo',
                width: 300,
              },
              {
                name: 'Monto',
                width: 100,
              },
              {
                name: 'Buena Pro',
                width: 100,
              },
              {
                name: 'Consentimiento',
                width: 100,
              },
              {
                name: 'Firmado',
                width: 100,
              },
              {
                name: 'Término',
                width: 100,
              },
              {
                name: 'Contrato',
                width: 100,
              },
              {
                name: 'Pagos',
              },
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
        })
        .init(true)
</script>
@endsection
