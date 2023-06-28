@extends('layouts.contentLayoutMaster')
@section('title','Mis Licitaciones')
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
            title: 'MIS LICITACIONES',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/licitaciones/propias/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Nomenclatura',
                width: 180,
                style: {'text-align':'center'},
              },
              {
                name: 'Entidad',
                width: 200,
              },
              {
                name: 'Tipo',
                width: 80,
              },
              {
                name: 'Descripción',
                width: 500,
              },
              {
                name: 'V.R.',
                width: 80,
              },
              {
                name: 'Participación',
                width: 150,
              },
              {
                name: 'Propuesta',
                width: 150,
              },
              {
                name: 'Propuesta',
                width: 90,
              },
              {
                name: 'Buena Pro',
              },
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
            onMap: function(v) {
                return {
                  codigo: '<span style="border-bottom: 5px solid ' + v.color + ';">' + v.nomenclatura + '</span>',
                  cliente: v.cliente,
                  tipo: v.tipo_objeto,
                  rotulo: '<a href="/oportunidades/' + v.id + '">' + v.rotulo + '</a>',
                  monto: v.monto,
                  participa: status_badge(v.inx_estado_participacion),
                  propuesta: status_badge(v.inx_estado_propuesta),
                  monto2: v.monto_propio,
                  ss: v.ganadores,
                };
            },
        });
        tablaPautas.init(true);
</script>
@endsection
