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
          <table id="{{ $did }}"></table>
        </div>
      </div>
    </div>
@endsection

@section('vendor-scripts')
@endsection
@section('page-scripts')
<script>
        window.t{{ $did }} = new Tablefy({
            title: 'RELACIÓN DE BUENAS PRO',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/licitaciones/buenapro/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Nomenclatura',
                width: 200,
                style: {'text-align':'center'},
              },
              {
                name: 'Entidad',
                width: 250,
              },
              {
                name: 'Descripción',
                width: 600,
              },
              {
                name: 'V.R.',
                width: 80,
              },
              {
                name: 'Estado',
                width: 70,
              },
              {
                name: 'Adjudicado',
                width: 90,
              },
              {
                name: 'Propuesta',
                width: 90,
              },
              {
                name: 'Observaciones',
              },
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
        })
        .init(true);
</script>
@endsection
