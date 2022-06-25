@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Categories')
{{-- page-styles --}}

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-knowledge-base.css')}}">
@endsection
@section('content')
<!-- Knowledge base categories Content start  -->
<section class="kb-categories">
  <div class="row">
    <!-- left side menubar section -->
    <div class="col-md-3">
      <div class="kb-sidebar">
        <i class="bx bx-x font-medium-5 d-md-none kb-close-icon cursor-pointer"></i>
        <h6 class="mb-2">Usuarios</h6>
        <form method="get" action ="/reportes/usuarios/descargar" id="formReporte" >
          <input hidden value="usuario" name="reporte" >
          <div class="form-group">
            <label for="inputAddress">Fecha Desde</label>
            <input type="date" name="fecha_desde" class="form-control" id="inputAddress" placeholder="1234 Main St">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Fecha Hasta</label>
            <input type="date" name="fecha_hasta" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" >
          </div>
          <div class="form-row">
           <!-- <div class="form-group col-md-6">
              <label for="inputCity">City</label>
              <input type="text" class="form-control" id="inputCity">
            </div>-->
            <div class="form-group col-md-4">
              <label for="inputState">State</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="inputState">Formato</label>
              <select id="inputState" class="form-control" name="formato">
                <option selected value="pdf">PDF</option>
                <option value="excel" >Excel</option>
              </select>
            </div>
            <!--<div class="form-group col-md-2">
              <label for="inputZip">Zip</label>
              <input type="text" class="form-control" id="inputZip">
            </div>-->
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>
          <button class="btn btn-primary" >Generar</button>
        </form>
      </div>
    </div>
    <!-- right side section -->
    <div class="col-md-9">
      <iframe style="width:100%; min-height: 85vh;" hidden id="reportPreview">
      </iframe> 
     </div>
    <div class="kb-overlay"></div>
  </div>
</section>
<!-- Knowledge base categories Content ends -->
@endsection

{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-knowledge-base.js')}}"></script>
<script>
  function reporte(e){
    e.preventDefault();
  }
  let formReporte = document.getElementById('formReporte');
  formReporte.addEventListener( 'submit',(e) => {

    e.preventDefault();
    var action = document.getElementById('formReporte').action;     
    console.log(action); 
    let formData = new FormData(formReporte);
    let parameters = '?';
    for(const pair of formData.entries()) {
      parameters +=`${pair[0]}=${pair[1]}&`;
    }
    console.log(parameters);
    reportPreview.src = action + parameters;   
    reportPreview.removeAttribute('hidden');

  })
  
</script>
@endsection
