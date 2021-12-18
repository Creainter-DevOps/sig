<div class="card-body">
    <h3 class="card-title">Registro Rápido de Cliente</h3>
        <form action="/clientes" method="POST" class="form-horizontal">
           @csrf
            <div class="row">
              <div class="col-mb-6 col-12"  >
                <div class="form-label-group ">
                  <label>Empresa</label>
                    <input type="text" name="empresa_id" value="{{ old('empresa_id', @$cliente->empresa_id) }}" placeholder="Buscar Empresa"
                     required
                     @if(@$cliente)
                        data-value="{{ @$cliente->empresa()->razon_social }}"
                     @endif
                     class="form-control autocomplete" data-ajax="/empresas/autocomplete"
                   >
                    @if ($errors->has('empresa_id'))
                    <div class="invalid-feedback">{{ $errors->first('empresa_id') }}</div>
                    @endif
                </div>
              </div>
                  <div class="col-12">
                    <div class="form-label-group">
                      <input type="text" name="nomenclatura" class="form-control"  >
                      <label>Nomenclatura</label>
                    </div>
                  </div>
              </div>
              <div class="col-mb-6 col-12">
                <button class="btn  btn-primary">Guardar</button>
              </div>
            </div>
        </form>
</div>
