<div class="card-body">
  <h5 class="card-title">Nueva empresa </h5>
<form class="form" action="{{ route('empresas.store') }}" method="post">
  @csrf
  <div class="form-body">
    <div class="row">
      <div class="col-12 col-md-12">
        <div class="form-label-group">
          <input type="number" min="0"
            max="99999999999"
           name="ruc"
           id="ruc"
           value="{{ old('ruc', @$empresa->ruc) }}"
           placeholder="RUC"
           required
           class="form-control">
          @if ($errors->has('ruc'))
          <div class="invalid-feedback">{{ $errors->first('ruc') }}</div>
          @endif
          <label>RUC</label> 
         </div>
      </div>

      <div class="col-12 col-md-12">
          <div class="form-label-group">
              <input type="text"
               name="razon_social"
               id="razon_social"
               value="{{ old('razon_social', @$empresa->razon_social) }}"
               placeholder="Razón social"
               required
               class="form-control">
              @if ($errors->has('razon_social'))
              <div class="invalid-feedback">{{ $errors->first('razon_social') }}</div>
              @endif
              <label> Razon Social</label>
          </div>
      </div>
      <div class="col-12  col-md-12">
          <div class="form-label-group">
              <input type="text"
               name="seudonimo"
               id="seudonimo"
               value="{{ old('seudonimo', @$empresa->seudonimo) }}"
               placeholder="Seudonimo"
               class="form-control">
              @if ($errors->has('seudonimo'))
              <div class="invalid-feedback">{{ $errors->first('seudonimo') }}</div>
              @endif
              <label> Seudonimo </label>
          </div>
      </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
            <button type="reset" class="btn btn-light-danger  mr-1 mb-1" data-dismiss="modal"   >Cancelar</button>
          </div>
    </div>
  </div>
</form>
</div>
</div>
