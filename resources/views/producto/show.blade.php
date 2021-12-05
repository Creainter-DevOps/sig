@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', $operacion ?? 'Nuevo contacto' )
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}"> 
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<style>
tr.block_header {
  cursor: pointer;
}
tr.block_details {
  display:none;
}
tr.block_details > td {
  padding: 5px;
}
tr.block_details > td > div {
  background: #f2f4f4;
  border-radius: 2px;
  padding: 5px;
  margin: 5px 10px;
  color: #000;
}
.btns_actions {
  color: #fff;
  text-align: right;
}
</style>
<link rel="stylesheet" type="text/css" href="{{asset('css/themes/layout.css')}}" >
@endsection

@section('content')
<div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-header">
          </div> 
          <div class="card-body">
              <div class="form-body">
                <div class="row">
                  <input type="hidden" value="{{$contacto->id ?? 0 }}" name="id" id="contacton_id" data-contacto="{{ $contacto->id ?? 0 }}" ></input>
                  <div class="col-md-6 col-12">
                    <div class="form-label-group"?>
                        <input type="text" class="form-control" placeholder="Nombres(*)" value="{{ $contacto->nombres ?? '' }}"  id="nombres" name="nombres" disabled>
                        <label for="">Nombres</label>
                    </div>
                  </div>
                  <div class="col-md-6  col-12">
                    <div class="form-label-group" >
                       <input type="text" class="form-control" placeholder="Apellidos(*) " value="{{ $contacto->apellidos ?? '' }}"  id="apellidos" name="apellidos" disabled> 
                       <label for=""> Apellidos</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-label-group" id="container-select-oportunidad">
                      <input type="mail" class="form-control" id="oportunidad_id" name="correo"  value="{{ $contacto->correo ?? '' }}"   placeholder="Correo(*)" disabled>
                      <label for=""> Correo(*) </label>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-label-group">
                      <input type="text" id="celular" class="form-control" name="celular" value="{{ $contacto->celular ?? '' }}" placeholder="Celular" disabled   >
                      <label for="plazo-servicio">Celular</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-label-group">
                      <input type="text" id="cliente_id" class="form-control " name="cliente_id" 
                        value="{{ $contacto->cliente_id ?? '' }}"  placeholder="Empresa" value=" {{ $contacto->cliente_id ?? '' }}">
                      <label for="monto-neto">Empresa</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-label-group">
                      <input type="number" id="dni" class="form-control" name="dni"  value="{{  $contacto->dni ?? '' }}" disabled  placeholder="DNI">
                      <label for="dni">DNI</label>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
                    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>  
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}} "></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}} "></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/contacto/save.js')}}"></script>
@endsection
