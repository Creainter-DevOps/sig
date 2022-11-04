@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Contactos')
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
@endsection

@section('content')
<section id="table-success">
  <div class="card">
    <div class="card-body" >
    <div class="table-responsive table-sm ">
      <table id="table-extended-success" class="table mb-0">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Dirección</th>
            <th>Desde</th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>Hasta</th>
            <th>Caller</th>
            <th>Caller</th>
            <td>Audio</th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach (App\Voip::llamadas() as $n) 
          <tr>
            <td>{{ Helper::fecha($n->created_on, true) }}</td>
            <td>{{ $n->direccion }}</td>
            <td>{{ $n->desde_numero }}</td>
            <td>
              @if(!empty($n->desde_contacto_id))
              <input type="text" data-editable="/contactos/{{ $n->desde_contacto_id }}?_update=nombres" value="{{ $n->desde }}">
              @endif
            </td>
            <td>{{ $n->hasta_numero }}</td>
            <td>
              @if(!empty($n->hasta_contacto_id))
              <input type="text" data-editable="/contactos/{{ $n->hasta_contacto_id }}?_update=nombres" value="{{ $n->hasta }}">
              @endif
            </td>
            <td>{{ $n->caller_numero }}</td>
            <td>
              @if(!empty($n->caller_contacto_id))
              <input type="text" data-editable="/contactos/{{ $n->caller_contacto_id }}?_update=nombres" value="{{ $n->caller }}">
              @endif
            </td>
            <td>
              @if(Auth::user()->id == 12)
              <div data-block-dinamic="/callcenter/llamadas/render_audios?aid={{ $n->asterisk_id }}"></div>
              @endif
            </div>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    </div>
    </div>
  </div>
</section>
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
@endsection
