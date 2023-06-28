@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Oportunidades')
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
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="heading-elements heading-upper">
            <a href="javascript:void(0)" data-popup="/oportunidades/crear" data-popup-end="t{{ $did }}.refresh();" class="btn btn-success">Nuevo</a>
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
            title: 'RELACIÓN DE OPORTUNIDADES',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/oportunidades/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Código',
                width: 120,
                style: {'text-align':'center'},
              },
              {
                name: 'Fecha',
                width: 100,
              },
              {
                name: 'Cliente',
                width: 200,
              },
              {
                name: 'Descripción',
                width: 400,
              },
              {
                name: 'Base',
                width: 100,
              },
              {
                name: 'Monto',
                width: 150,
              },
              {
                name: 'Aprobado',
                width: 80,
              },
              {
                name: 'Estado',
                width: 100,
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
        }).init(true);
</script>
@endsection
