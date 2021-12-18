@csrf
<div class="form-body">
  <div class="row">
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
             data-ajax="/clientes/autocomplete" name="cliente_id" autocomplete="nope"  
             @if (!empty($oportunidad->cliente_id))
                 value="{{ $oportunidad->cliente_id }}"
                 data-value="{{ $oportunidad->cliente()->empresa()->razon_social }}"
              @endif
                 >
          <label for="cliente_id">Cliente</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group container-autocomplete ">
          <input type="text" class="form-control autocomplete" name="contacto_id" 
              data-register="/contactos/fast" data-ajax="/contactos/autocomplete" autocomplete="nope"
              @if (!empty($oportunidad->contacto_id))
              value="{{ old('contacto_id', $oportunidad->contacto_id ) }}"
              data-value=" {{ old( 'contacto_id', $oportunidad->contacto()->nombres )}}"
              @endif
              name="contacto_id" >
         <label for="contacto_id">Contacto</label>
      </div>
    </div>
   <div class="col-md-6 col-12">
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
