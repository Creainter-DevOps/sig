@extends('layouts.contentLayoutMaster')
@section('title','Empresas')
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
          <div class="heading-elements heading-upper">
            <a href="javascript:void(0)" data-popup="/empresas/crear" data-popup-end="t{{ $did }}.refresh();" class="btn btn-success">Nuevo</a>
          </div>
          <table id="{{ $did }}"></table>
        </div>
      </div>
    </div>
@endsection

@section('vendor-scripts')
@endsection
@section('page-scripts')
<script>
        var t{{ $did }} = new Tablefy({
            title: 'RELACIÓN DE EMPRESAS',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/empresas/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'RUC',
                width: 120,
                style: {'text-align':'center'},
              },
              {
                name: 'SIAF',
                width: 100,
              },
              {
                name: 'Razón Social',
                width: 350,
              },
              {
                name: 'Dirección',
                width: 350,
              },
              {
                name: 'Tipo',
                width: 100,
              },
              {
                name: 'Es Cliente',
                width: 200,
              },
              {
                name: 'Oportunidades',
                width: 150,
              },
              {
                name: 'Proyectos',
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
                  ruc: v.ruc,
                  codigo_siaf: v.codigo_siaf,
                  social: v.razon_social,
                  direccion: v.direccion,
                  tipo: v.privada ? 'Privada' : 'Público',
                  cliente: v.cliente_id ? 'Si' : '',
                  oportunidades: v.monto_oportunidades,
                  proyectos: v.monto_proyectos
                };
            },
        }).init(true);
</script>
@endsection
