@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Perfiles')
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
            title: 'RELACIÓN DE PERFILES',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/usuarios/perfiles/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Empresa',
                width: 200,
              },
              {
                name: 'Credencial',
                width: 200,
                style: {'text-align':'center'},
              },
              {
                name: 'Correo',
                width: 200,
              },
              {
                name: 'Habilitado',
                width: 120,
              },
              {
                name: 'Usuarios',
                width: 100,
                style: {'text-align':'center'},
              },
              {
                name: 'Linea',
                width: 100,
              },
              {
                name: 'Anexo',
                width: 80,
              },
              {
                name: 'Celular',
                width: 100,
              },
              {
                name: 'Cargo',
                width: 150,
              },
              {
                name: 'Firma',
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
