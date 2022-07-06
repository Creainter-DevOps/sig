<form class="form" action="{{ route('documentos.store') }}" method="post" enctype="multipart/form-data" > 
@csrf
<div class="form-body" style="padding:10px;margin-top:15px;" >
<div class="row">
@if(!empty($expediente_id))
   <input type="hidden" name="expediente_id" value="{{ $expediente_id }}" >
   <input type="hidden" name="orden" value="{{ $orden ?? '' }}">
@endif

@if(!empty($cotizacion_id))
   <input type="hidden" name="orden" value="{{ $orden ?? '' }}"   >
   <input type="hidden" name="expediente" value="{{ $expediente->id ?? '' }}" >
   <input type="hidden" name="cotizacion_id" value="{{ $cotizacion_id }}">
@endif
@if(!empty($plantilla))
   <input type="hidden" name="generado_de_id" value="{{ $plantilla->id }}">
   <input type="hidden" name="tipo" value="{{ $plantilla->tipo }}">
  <div class="col-12">
  </div>
@else
   <div class="col-md-6 col-12">
     <div class="form-label-group">
       <input type="hidden">
        <select name="tipo" class="form-control" data-value="{{ old ( 'tipo', $documento->tipo ) }}" onchange="select_element(this)">
          <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
          <option value="VARIADO">VARIADO</option>
          <option value="CONTRATO" >CONTRATO</option>
          <option value="CERTIFICADO">CERTIFICADO</option>
          <option value="CONSTANCIA">CONSTANCIA DE TRABAJO</option>
          <option value="CV">CV</option>
          <option value="ANEXO">ANEXO</option>
          <option value="VISADO">VISADO</option>
          <option value="FIRMA">FIRMA</option>
        </select>
        <label for="tipo">Tipo</label>
      </div>
    </div>
@endif
    <div class="col-md-6 col-12" data-campo="contrato certificado constancia firma visado administrativo cv">
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
             data-ajax="/empresas/autocomplete" name="empresa_id" autocomplete="nope"
             @if (!empty($documento->empresa_id))
                 value="{{ $documento->empresa_id }}"
                 data-value="{{ $documento->empresa()->razon_social }}"
                 @endif
                 >
          <label for="empresa_id">Empresa</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato" >

      <div class="form-label-group"> 
          <input type="text" class="form-control autocomplete"
             data-ajax="/empresas/autocomplete" name="vinculo_empresa_id" autocomplete="nope"
             @if (!empty($documento->vinculo_empresa_id))
                 value="{{ $documento->vinculo_empresa_id }}"
                 data-value="{{ $documento->vinculo_empresa()->razon_social }}"
                 @endif
                 >

          <label for="vinculo_empresa_id">Empresa Vinculada</label>
      </div>
    </div>
@if(empty($plantilla))
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select name="es_plantilla" data-value="{{ old ( 'es_plantilla', $documento->es_plantilla ) }}" class="form-control">
          <option value="0">No</option>
          <option value="1">Si</option>
        </select>
        <label for="">¿Es Plantilla?</label>
      </div>
    </div>
@endif
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select name="es_ordenable" data-value="{{ old ( 'es_ordenable', $documento->es_ordenable ) }}" class="form-control">
          <option value="0">No</option>
          <option value="1">Si</option>
        </select>
        <label for="">¿Es Ordenable?</label>
      </div>
    </div>
    <div class="col-md-12 col-12">
      <div class="form-label-group">
          <input type="text" class="form-control" value="{{ old ( 'rotulo', $documento->rotulo ) }}" name="rotulo" required>
          <label for="">Rótulo</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="certificado constancia" >
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
             data-ajax="/personales/autocomplete" name="personal_id" autocomplete="nope"  >
             @if (!empty($contrato->personal_id))
                 value="{{ $contrato->personal_id }}"
                 data-value="{{ $contrato->personal()->nombres }}"
             @endif
          <label for="personal_id">Personal</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato certificado" >
      <div class="form-label-group">
          <input type="date" class="form-control" value="{{ old ( 'fecha_desde', $documento->fecha_desde ) }}" name="fecha_desde">
          <label for="">Fecha Desde</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato" >
      <div class="form-label-group">
          <input type="date" class="form-control" value="{{ old ( 'fecha_hasta', $documento->fecha_hasta ) }}" name="fecha_hasta">
          <label for="">Fecha Hasta</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato" >
      <div class="form-label-group" >
          <input type="numeric" class="form-control" value="{{ old ( 'monto', $documento->monto ) }}" name="monto" min="10" max="99999999" step="0.01">
          <label for="">Monto</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato" >
      <div class="form-label-group">
          <input type="text" class="form-control" value="{{ old ( 'monto_texto', $documento->monto_texto ) }}" name="monto_texto">
          <label for="">Monto Texto</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato administrativo" >
      <div class="form-label-group">
          <input type="date" class="form-control" value="{{ old ( 'fecha_firma', $documento->fecha_firma ) }}" name="fecha_firma">
          <label for="">Fecha Firma</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="contrato" > 
      <div class="form-label-group">
          <input type="date" class="form-control" value="{{ old ( 'fecha_acta', $documento->fecha_acta ) }}" name="fecha_acta">
          <label for="">Fecha Acta</label>
      </div>
    </div>
    <div class="col-md-6 col-12" data-campo="plazo">
      <div class="form-label-group">
          <input type="text" class="form-control" value="{{ old ( 'plazo_servicio', $documento->plazo_servicio ) }}" name="plazo_servicio">
          <label for="">Plazo</label>
      </div>
    </div>
@if(empty($plantilla))
    <div class="col-md-6 col-12">
      <div class="form-label-group">
          <input type="file" class="form-control" name="archivo"  accept=".doc,.docx,.pdf">
          <label for="">Archivo</label>
          @if(!empty($documento->id))
            <a href="/storage/{{ $documento->archivo }}?t={{ time() }}" target="_blank" download>Descargar Archivo</a>
          @endif
      </div>
    </div>
    @endif
    @if(empty($documento->es_reusable))
    <div class="col-12" style="padding: 10px 30px;font-size: 15px;">
      <input type="checkbox" name="es_reusable" class="switch-input" value="1" /> El documento generado o subido será reusable?
    </div>
    @endif
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar</button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar</button>
    </div>
  </div>
</div>
</div>
<script>
  
  function select_element(elem){
    let elements = document.querySelectorAll("[data-campo]")
    console.log(elem.value)
    let val = elem.value.toLowerCase()
    elements.forEach( (campo) => {
      console.log(campo);
      if ( campo.dataset.campo.indexOf(val) < 0 ){
        campo.style.display = 'none';
      } else {
        campo.style.display = 'block';
      } 
    })
  }
  select_element(document.querySelectorAll('[name=tipo]')[0]);

</script>
