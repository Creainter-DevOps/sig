{!! csrf_field() !!}

<div class="form-group row">
    <div class="col-md-2">RUC <span class="required"></span></div>
    <div class="col-md-10">
        <input type="number"
        min="0"
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
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">Razón social <span class="required"></span></div>
    <div class="col-md-10">
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
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">Seudonimo <span class="required"></span></div>
    <div class="col-md-10">
        <input type="text"
         name="seudonimo"
         id="seudonimo"
         value="{{ old('seudonimo', @$empresa->seudonimo) }}"
         placeholder="Seudonimo"
         required
         class="form-control">
        @if ($errors->has('seudonimo'))
        <div class="invalid-feedback">{{ $errors->first('seudonimo') }}</div>
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
      <button type="submit" class="btn btn-default" style="color: #fff; background-color: #ccc;">
          Cancelar
      </button>
    </div>
  </div>
</div>
