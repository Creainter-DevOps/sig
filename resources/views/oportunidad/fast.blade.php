<div class="card-body">
<h5 class="card-title">Nueva oportunidad</h5>
<form action="{{ route('oportunidades.store') }}" >
@csrf
<div class="form-body">
  <div class="row">
    <div class="col-md-12 col-12">
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
             data-ajax="/empresas/autocomplete" name="empresa_id" autocomplete="nope"  >
             @if (!empty($oportunidad->empresa_id))
                 value="{{ $oportunidad->empresa_id }}"
                 data-value="{{ $oportunidad->empresa()->razon_social }}"
             @endif
          <label for="empresa_id">Empresa</label>
      </div>
    </div>
    <div class="col-12">
      <div class="form-label-group container-autocomplete">
          <input type="text" class="form-control autocomplete" name="contacto_id" 
               data-ajax="/contactos/autocomplete" autocomplete="nope"
              data-register="/contactos/crear"
              @if (!empty($oportunidad->contacto_id))
              value="{{ old('contacto_id', $oportunidad->contacto_id ) }}"
              data-value=" {{ old( 'contacto_id', $oportunidad->contacto()->nombres )}}"
              @endif
              name="contacto_id" >
         <label for="contacto_id">Contacto</label>
      </div>
    </div>
   <div class="col-md-12 col-12">
      <div class="form-label-group">
        <input type="hidden" >
          <textarea class ="form-control" name="rotulo">{{ @$oportunidad->rotulo }}</textarea>
        <label>Rótulo</label>
      </div>
    </div>
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar</button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar</button>
  </div>
</div>
</div>
</form>
</div>
