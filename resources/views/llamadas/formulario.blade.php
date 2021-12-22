@csrf
<div class="form-body">
  <div class="row">
    
    <div class="col-md-6">
      <div class="form-label-group">  
               value="{{ old('empresa_id', $proyecto->empresa_id ) }}"
               data-value=" {{ old( 'empresa_id', $proyecto->empresa_id )}}"
          <label for="cliente_id">Empresa</label>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-label-group">  
               value="{{ old('uri', $proyecto->uri ) }}"
               data-value=" {{ old( 'uri', $proyecto->uri )}}"
          <label for="cliente_id">Uri</label>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-label-group">  
               value="{{ old('number', $proyecto->number ) }}"
               data-value=" {{ old( 'number', $proyecto->number )}}"
          <label for="cliente_id">Number</label>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-label-group">  
               value="{{ old('rotulo', $proyecto->rotulo ) }}"
               data-value=" {{ old( 'rotulo', $proyecto->rotulo )}}"
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
