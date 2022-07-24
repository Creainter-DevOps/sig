@csrf
<div class="form-body">
  <div class="row">
  <div class="col-md-12 col-12">
    <div class="form-label-group container-autocomplete" >
      <input type="text" class="form-control autocomplete" name="oportunidad_id" value="{{ old('cotizacion_id', $cotizacion->oportunidad_id) }}" required
         data-ajax="/oportunidades/autocomplete?directas"
         data-register="/oportunidades/crear"
        @if( !empty($cotizacion->oportunidad_id ))
         data-value="{{ old ( 'oportunidad', null != $cotizacion->oportunidad() ?  $cotizacion->oportunidad()->rotulo() : '' ) }}"
        @endif
      >
      <label for="oportunidad_id">Oportunidad</label>
    </div>
  </div>
    <div class="col-md-12  col-12">
      <div class="form-label-group ">
          <input type="text" class="form-control autocomplete" value="{{ $cotizacion->empresa_id }}" required
          @if (!empty($cotizacion->empresa_id))
             data-value="{{ $cotizacion->empresa()->razon_social }}" 
          @endif
             data-ajax="/empresas/autocomplete?propias"
             name="empresa_id">
          <label for="">Cotizar Con:</label>
      </div>
    </div>
  <div class="col-md-12 col-12">
  <div class="row">
  <div class="col-4">
    <div class="form-label-group">
      <input type="text" id="plazo-instalacion" class="form-control" name="plazo_instalacion" value="{{ old ( 'plazo_instalacion', $cotizacion->plazo_instalacion ) }}" placeholder="Plazo Instalacion">
      <label for="plazo-instalacion">Plazo Instalacion</label>
    </div>
  </div>

  <div class="col-4">
    <div class="form-label-group">
      <input type="text" class="form-control" name="plazo_servicio" value="{{ old ('plazo_servicio',  $cotizacion->plazo_servicio ) }}" placeholder="Plazo de Servicio">
      <label for="plazo-servicio">Plazo Servicio</label>
    </div>
  </div>
  <div class="col-4">
    <div class="form-label-group">
      <input type="text" class="form-control" name="plazo_garantia" value="{{ old ('plazo_garantia', $cotizacion->plazo_garantia )}}" placeholder="Plazo de Garantia">
      <label for="plazo-garantia">Plazo de Garantia</label>
    </div>
  </div>
  </div>
  </div>
  <div class="col-md-12 col-12">
  <div class="row">
  <div class="col-6">
    <div class="form-label-group">
      <input type="number" class="form-control" name="monto" value="{{ old ('monto', $cotizacion->monto )}}"  placeholder="Monto Total" min="0" max="99999999" step="0.01">
      <label for="monto-neto">Monto Total</label>
    </div>
  </div>
  <div class="col-6">
    <div class="form-label-group">
    <select name="moneda_id" data-value="{{ $cotizacion->moneda_id }}" class="form-control">
      @foreach (App\Pago::selectMonedas() as $k => $v)
      <option value="{{ $k }}">{{ $v }}</option>
      @endforeach
    </select>
      <label for="monto-neto">Moneda</label>
    </div>
  </div>
  </div>
  </div>
  <div class="col-6">
    <input type="hidden" >
    <div class="form-label-group">
    <input type="hidden">
      <fieldset class="form-label-group position-relative has-icon-left">
        <input type="date" id="fecha" name="fecha" class="form-control pickadate" placeholder="Fecha" value="{{ old ( 'fecha', $cotizacion->fecha ) }}"  >
          <div class="form-control-position">
             <i class='bx bx-calendar'></i>
          </div>
        </fieldset>
       <label>Fecha</label>
    </div>
  </div>
  <div class="col-6">
    <div class="form-label-group">
    <input type="hidden">
    <fieldset class="form-group position-relative has-icon-left">
        <input type="date" id="validez" name="validez" class="form-control pickadata" placeholder="Validez" value="{{ old('validez', $cotizacion->validez) }}"  >
            <div class="form-control-position">
             <i class='bx bx-calendar'></i>
          </div>
    </fieldset>
    <label>Validez</label>
    </div>
  </div>
 <div class="col-md-6 col-12">
    <div class="form-label-group">
        <textarea type="text"  name="observacion" class="form-control"  placeholder="Observaciones" rows="5" >{{ old('observacion', $cotizacion->observacion) }}</textarea>
       <label>Observaciones</label>
    </div>
  </div>
 <div class="col-md-6 col-12">
    <div class="form-label-group">
        <textarea type="text"  name="terminos" class="form-control"  placeholder="Terminos" rows="5" >{{ old('terminos', $cotizacion->terminos) }}</textarea>
       <label>Terminos y Condiciones</label>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
  </div>
</div>
</div>
</form>
