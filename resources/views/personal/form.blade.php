@csrf
<div class="form-body">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
             data-ajax="/empresas/autocomplete" name="empresa_id" autocomplete="nope"  >
             @if (!empty($personal->empresa_id))
                 value="{{ $personal->empresa_id }}"
                 data-value="{{ $personal->empresa()->razon_social }}"
             @endif
          <label for="empresa_id">Empresa</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group"?>
          <input type="text" class="form-control" value="{{ old ( 'documento_tipo', $personal->documento_tipo) }}" name="documento_tipo" required>
          <label for="">Documento Tipo</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group"?>
          <input type="text" class="form-control" value="{{ old ( 'documento_numero', $personal->documento_numero ) }}" name="documento_numero" required>
          <label for="">Documento</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group"?>
          <input type="text" class="form-control" value="{{ old ( 'nombres', $personal->nombres ) }}" name="nombres" required>
          <label for="">Nombres</label>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar</button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar</button>
    </div>
  </div>
</div>
