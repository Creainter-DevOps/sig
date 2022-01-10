@csrf
<div class="form-body">
  <div class="row">
    
    <div class="col-md-6">
      <div class="form-label-group">  
     <input  class="form-control autocomplete" 
               @if (!empty($caller->empresa_id))
                  data-value=" {{ old( 'empresa_id', $caller->empresa()->rotulo() )}}"
                  value=" {{ $caller->empresa_id }}"
               @endif
               data-ajax="/empresas/autocomplete?propias"
                name="empresa_id"  >
          <label for="cliente_id">Empresa</label>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-label-group">  
           <input  class="form-control"  value="{{ old('uri', $caller->uri ) }}" data-value=" {{ old( 'uri', $caller->uri )}}" name="uri">
          <label for="cliente_id">Uri</label>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-label-group">  
          <input class="form-control"     value="{{ old('number', $caller->number ) }}"
               data-value=" {{ old( 'number', $caller->number )}}" name="number">
          <label for="cliente_id">Number</label>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-label-group">  
          <input class="form-control"  value="{{ old('rotulo', $caller->rotulo ) }}"
               data-value=" {{ old( 'rotulo', $caller->rotulo )}}" name="rotulo" >
          <label for="cliente_id">Rotulo</label>
      </div>
    </div>
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar</button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar</button>
  </div>
</div>
</div>
</form>
