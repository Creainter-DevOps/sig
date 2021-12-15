@csrf
<div class="form-body">
  <div class="row">
    <input type="hidden" value="{{$oportunidad->id ?? 0 }}" name="id" id="cotizacion_id"></input>
    <div class="col-md-12  col-12">
      <div class="form-label-group">
          @if (empty($oportunidad->empresa_id))
          <input type="text" class="form-control autocomplete"
             data-ajax="/empresas/autocomplete" name="empresa_id" autocomplete="nope"   >
          <label for="cliente_id">Empresa</label>
          @else
          <input type="text" class="form-control autocomplete" value="{{ $oportunidad->empresa_id }}"
             data-value="{{ $oportunidad->empresa()->razon_social  }}"
             data-ajax="/empresas/autocomplete" name="empresa_id">
          <label for="cliente_id">Empresa</label>
          @endif
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
             data-ajax="/clientes/autocomplete" name="cliente_id" autocomplete="nope"  >
             @if (!empty($oportunidad->cliente_id))
                 value="{{ $oportunidad->cliente_id }}"
                 data-value="{{ $oportunidad->cliente()->empresa()->razon_social }}"
             @endif
          <label for="cliente_id">Cliente</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group container-autocomplete ">
          <input type="text" class="form-control autocomplete" name="contacto_id" 
              data-register="/contactos/fast" data-ajax="/contactos/autocomplete" autocomplete="nope"
              @if (!empty($oportunidad->contacto_id))
              value="{{ old('contacto_id', $oportunidad->contacto_id ) }}"
              data-value=" {{ old( 'contacto_id', $oportunidad->contacto()->nombres )}}"
              @endif
              name="contacto_id" >
         <label for="contacto_id">Contacto</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete"
           data-ajax="/cotizacion/autocomplete"
           name="cotizacion_id"
          @if (!empty($oportunidad->cotizacion_id))
           value="{{ old('cotizacion_id', $oportunidad->cotizacion_id ) }}"
            data-value="{{ old( 'cotizacion',$oportunidad->cotizacion()->rotulo() ) }}"
          @endif
 > 
         <label for="cotizacion_id">Cotizacion</label>
      </div>
    </div>
   <!--<div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select class="form-control" name="estado" >
          <option>Estado</option> 
          <option>Estado</option> 
          <option>Estado</option> 
        </select>
        <label>Estado</label>
      </div>
    </div>-->
   <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden" >
          <textarea class ="form-control" name="que_es"   ></textarea>
        <label>Descripcion</label>
      </div>
    </div>
  <!--<div class="col-md-6  col-12">
    <div class="form-label-group">
      <fieldset class="form-label-group position-relative has-icon-left">
        <input type="text" id="fecha" name="fecha_desde" class="form-control pickadate" placeholder="Fecha desde" 
            value="{{ old ('fecha_desde' , isset($oportunidad->fecha_desde) ? Helper::fecha( $oportunidad->fecha_desde ) : '' ) }}"  >
          <div class="form-control-position">
             <i class='bx bx-calendar'></i>
          </div>
        </fieldset>
       <label>Fecha Desde</label>
    </div>
  </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <fieldset class="form-group position-relative has-icon-left">
        <input type="text" id="validez" name="fecha_hasta" class="form-control pickadate" placeholder="Fecha Hasta" 
          value="{{ old('fecha_hasta', isset($oportunidad->fecha_hasta) ? Helper::fecha($oportunidad->fecha_hasta) : ''  )}}">
        <div class="form-control-position">
          <i class='bx bx-calendar'></i>
        </div>
      </fieldset>
    <label>Fecha Hasta</label>
    </div>
  </div>-->
 
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar</button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar</button>
  </div>
</div>
</div>
</form>
