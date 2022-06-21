{!! csrf_field() !!}
<div class="form-body">
  <div class="row">
    <div class="col-mb-6 col-12"  >
      <div class="form-label-group container-autocomplete ">
        <label>Empresa</label>
          <input type="text" name="empresa_id" value="{{ old('empresa_id', @$cliente->empresa_id) }}"  class="form-control autocomplete"
           placeholder="Buscar Empresa" required data-ajax="/empresas/autocomplete" data-register="/empresas/crear" 
           @if(@$cliente)
              data-value="{{ @$cliente->empresa()->razon_social }}"
           @endif
         >
          @if ($errors->has('empresa_id'))
          <div class="invalid-feedback">{{ $errors->first('empresa_id') }}</div>
          @endif
      </div>
    </div>
      <div class="col-12">
        <div class="form-label-group">
          <input type="text" name="nomenclatura" placeholder="Nomenclatura" class="form-control" >
          <label>Nomenclatura</label>
        </div>
      </div>
    </div>
    <div class="col-mb-6 col-12">
      <button class="btn  btn-primary">Guardar</button>
    </div>
  </div>
</div>
