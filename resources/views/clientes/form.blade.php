{!! csrf_field() !!}
<div class="form-body">
  <div class="row">
    <div class="col-mb-6 col-12"  >
      <div class="form-label-group container-autocomplete ">
        <label>Empresa</label>
          <input type="text"
           name="empresa_id"
           value="{{ old('empresa_id', @$cliente->empresa_id) }}"
           placeholder="Buscar Empresa"
           required
           @if(@$cliente)
              data-value="{{ @$cliente->empresa()->razon_social }}"
           @endif
           class="form-control autocomplete"
           data-ajax="/empresas/autocomplete"
           data-register="/empresas/fast" 
         >
          @if ($errors->has('empresa_id'))
          <div class="invalid-feedback">{{ $errors->first('empresa_id') }}</div>
          @endif
      </div>
    </div>
    <div class="col-mb-6 col-12" >
      <div class="form-label-group">
         <textarea class="form-control" placeholder="nomenclatura" name="nomenclatura" ></textarea>
         <label>Descripcion</label>
      </div>
    </div>
    <div class="col-mb-6 col-12">
      <button class="btn  btn-primary">Guardar</button>
    </div>
  </div>
</div>
