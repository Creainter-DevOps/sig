@extends('layouts.contentLayoutMaster')
@section('title','Mis Gastos')
@section('vendor-styles')
@endsection
@section('page-styles')
@endsection
@php
 $did = uniqid();
@endphp
@section('content')
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <table id="{{ $did }}"></table>
        </div>
      </div>
    </div>
@endsection

@section('vendor-scripts')
@endsection
@section('page-scripts')
<script>
        var tablaPautas = new Tablefy({
            title: 'RELACIÓN DE MIS GASTOS',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/ordenes/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Código',
                width: 90,
                style: {'text-align':'center'},
              },
              {
                name: 'Vinculado',
                width: 80,
              },
              {
                name: 'Proyecto',
                width: 250,
              },
              {
                name: 'Fecha',
                width: 90,
              },
              {
                name: 'Número',
                width: 60,
              },
              {
                name: 'Descripción',
                width: 350,
              },
              {
                name: 'Monto',
                width: 100,
              },
              {
                name: 'Moneda',
                width: 70,
              },
              {
                name: 'Estado',
                width: 80,
              },
              {
                name: 'Deposito',
                width: 90,
              },
              {
                name: 'En Cuenta',
                width: 80,
              },
              {
                name: 'Detracción',
                width: 80,
              },
              {
                name: 'Penalidad',
                width: 80,
              },
              {
                name: 'Factura',
              }
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
        })
        .init(true)
        .appendExtra('<a href="javascript:void(0)" data-popup="/ordenes/crear" data-popup-end="t{{ $did }}.refresh();" class="btn">Nuevo</a>');
</script>
@endsection
