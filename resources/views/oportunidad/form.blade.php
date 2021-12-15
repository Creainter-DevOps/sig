{!! csrf_field() !!}

<div class="form-group row">
    <div class="col-md-2">Empresa <span class="required"></span></div>
    <div class="col-md-10">
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
         data-register="/empresas/crear">
        @if ($errors->has('empresa_id'))
        <div class="invalid-feedback">{{ $errors->first('empresa_id') }}</div>
        @endif
    </div>
</div>

<div style="width:500px;margin:0 auto;">
  <div class="form-group row">
    <div class="col-6" style="text-align:center;">
      <button type="submit" class="btn btn-default" style="color: #fff; background-color: #007bff; border-color: #007bff;">
          Guardar
      </button>
    </div>
    <div class="col-6" style="text-align:center;">
      <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #fff; background-color: #ccc;">
          Cancelar
      </button>
    </div>
  </div>
</div>
