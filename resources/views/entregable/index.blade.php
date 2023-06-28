@extends('layouts.contentLayoutMaster')
@section('title','Entregables')
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
            title: 'RELACIÓN DE MIS ENTREGABLES',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/entregables/tablefy',
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
                name: 'Proyecto',
                width: 350,
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
                width: 150,
              },
              {
                name: 'Monto',
                width: 80,
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
                name: 'Propuesta Hasta',
                width: 120,
              },
              {
                name: 'Propuesta',
              },
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
            onComplete: function(object) {
            },
            onProcessRequest: function(x) {
              x.result.items = x.result.items.map((v) => {
                return {
                  codigo: status_wdir('ENTT-' + v.proyecto_id + '-' + v.id, v.folder),
                  proyecto: v.proyecto,
                  fecha: status_date_vencimiento(v.fecha, v.estado),
                  numero: v.numero,
                  descripcion: v.descripcion,
                  monto: v.monto,
                  moneda: v.moneda,
                  estado: v.estado,
                  vence: status_date_vencimiento(v.fecha_propuesta_hasta, v.fecha_propuesta),
                  ss: status_date(v.fecha_propuesta),
                };
              });
              return x;
            },
        });
        tablaPautas.init(true);
</script>
@endsection
