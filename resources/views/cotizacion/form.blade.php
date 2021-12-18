@csrf
<div class="form-body">
  <div class="row">
  <div class="col-md-6 col-12">
    <div class="form-label-group container-autocomplete" >
      <input type="text" class="form-control autocomplete" name="oportunidad_id" value="{{ old('cotizacion_id', $cotizacion->oportunidad_id) }}" required
         data-ajax="/oportunidad/autocomplete?directas"
         data-register="{{  route('oportunidades.create')}}"
        @if( !empty($cotizacion->oportunidad_id ))
         data-value="{{ old ( 'oportunidad', null != $cotizacion->oportunidad() ?  $cotizacion->oportunidad()->rotulo() : '' ) }}"
        @endif
      >
      <label for="oportunidad_id">Oportunidad</label>
    </div>
  </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group ">
          <input type="text" class="form-control autocomplete" value="{{ $cotizacion->empresa_id }}"
          @if (!empty($cotizacion->empresa_id))
             data-value="{{ $cotizacion->empresa()->razon_social  }}" 
          @endif
             data-ajax="/empresas/autocomplete?propias" name="empresa_id">
          <label for="">Empresa</label>
      </div>
    </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="text" id="decripcion" class="form-control" name="descripcion" value ="{{ old ( 'descripcion',  $cotizacion->descripcion ) }}" placeholder="Descripcion" required >
      <label for="decripcion">Descripcion</label>
  </div>
  </div>

  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="text" id="plazo-instalacion" class="form-control" name="plazo_instalacion" value="{{ old ( 'plazo_instalacion', $cotizacion->plazo_instalacion ) }}" placeholder="Plazo Instalacion" required  >
      <label for="plazo-instalacion">Plazo Instalacion</label>
    </div>
  </div>

  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="text" class="form-control" name="plazo_servicio" value="{{ old ('plazo_servicio',  $cotizacion->plazo_servicio ) }}" placeholder="Plazo de Servicio"    >
      <label for="plazo-servicio">Plazo Servicio</label>
    </div>
  </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="text" class="form-control" name="plazo_garantia" value="{{ old ('plazo_garantia', $cotizacion->plazo_garantia )}}" placeholder="Plazo de Garantia" required   >
      <label for="plazo-garantia">Plazo de Garantia</label>
    </div>
  </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="number" id="monto-base" class="form-control" name="monto" value="{{ old ('monto', $cotizacion->monto )}}"  placeholder="Monto Base" >
      <label for="monto-neto">Monto Total</label>
    </div>
  </div>
  <div class="col-md-6  col-12">
    <input type="hidden" >
    <div class="form-label-group">
      <fieldset class="form-label-group position-relative has-icon-left">
        <input type="date" id="fecha" name="fecha" class="form-control pickadate" placeholder="Fecha" value="{{ old ( 'fecha', isset($cotizacion->fecha) ? Helper::fecha( $cotizacion->fecha): '' ) }}"  >
          <div class="form-control-position">
             <i class='bx bx-calendar'></i>
          </div>
        </fieldset>
       <label>Fecha</label>
    </div>
  </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
    <fieldset class="form-group position-relative has-icon-left">
        <input type="text" id="validez" name="validez" class="form-control pickadata" placeholder="Validez" value="{{ old('validez', isset($cotizacion->validez) ?  Helper::fecha($cotizacion->validez) : '' )  }}"  >
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
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
  </div>
</div>
</div>
</form>
