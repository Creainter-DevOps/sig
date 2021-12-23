@csrf
<div class="form-body">
  <div class="row">
    <div class="col-6">
      @if(empty($proyecto->cotizacion_id))
      <div class="form-label-group">
          <input type="text" class="form-control autocomplete" value="{{ $proyecto->cotizacion_id }}"
             @if(!empty($proyecto->cotizacion_id))
                data-value="{{ $proyecto->cotizacion()->codigo()  }}"
              @endif
             data-ajax="/cotizaciones/autocomplete" name="cotizacion_id">
          <label for="cliente_id">Cotización</label>
      </div>
      @else
        {{ $proyecto->cotizacion()->codigo()  }}
      @endif
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="text" id="decripcion" class="form-control" name="rotulo"  value ="{{ old ( 'rotulo',  $proyecto->rotulo )}}" placeholder="Rótulo" required>
        <label for="decripcion">Rótulo</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="text" id="decripcion" class="form-control" name="nomenclatura" value ="{{old('nomenclatura', $proyecto->nomenclatura)}}" placeholder="Nomenclatura">
        <label for="Nomenclatura">Nomenclatura </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group container-autocomplete ">
          <input type="text" class="form-control autocomplete" name="contacto_id" data-register="/contactos/fast" data-ajax="/contactos/autocomplete" 
              @if (!empty($proyecto->contacto_id))
              value="{{ old('contacto_id', $proyecto->contacto_id ) }}"
              data-value=" {{ old( 'contacto_id', $proyecto->contacto()->nombres )}}"
              @endif
              name="contacto_id" >
         <label for="contacto_id">Contacto</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select class="form-control" name="tipo" >
           <option value="licitacion" {{ $proyecto->tipo == 'licitacion' ? 'selected': '' }} >Licitacion</option> 
           <option value="orden_compra" {{ $proyecto->tipo == 'orden_compra' ? 'selected': '' }} >Orden de compra</option> 
           <option value="orden_servicio" {{ $proyecto->tipo == 'orden_servicio' ? 'selected': '' }} >Orden de servicio</option> 
           <option value="otro"  {{ $proyecto->tipo == 'otro' ? 'selected' : '' }} >Otro</option> 
         </select>
        <label for="decripcion">Tipo</label>
      </div>
    </div>
   <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select class="form-control" name="estado" >
           <option value="precontrato" {{ $proyecto->estado == 'precontrato' ? 'selected': '' }} >Pre-Contrato</option>
           <option value="contrato" {{ $proyecto->estado  == 'contrato' ? 'selected': '' }} >Contrato</option>
           <option value="acta" {{ $proyecto->estado == 'acta' ? 'selected': '' }} >Acta</option>
           <option value="inicio_servicio" {{ $proyecto->estado == 'inicio_servicio' ? 'selected': '' }} >Inicio de servicio </option>
           <option value="fin_servicio" {{ $proyecto->estado == 'fin_servicio' ? 'selected': '' }} >Fin de servicio</option>
           <option value="cancelado" {{ $proyecto->estado == 'cancelado' ? 'selected': '' }} >Cancelado</option>
           <option value="concluido" {{ $proyecto->estado == 'concluido' ? 'selected': '' }} >Concluido</option>
         </select>
        <label>Estado</label>
      </div>
    </div>
  <div class="col-md-6  col-12">
    <div class="form-label-group">
      <fieldset class="form-label-group position-relative has-icon-left">
        <input type="text" id="fecha" name="fecha_desde" class="form-control pickadate" placeholder="Fecha desde" 
            value="{{ old ('fecha_desde' , isset($proyecto->fecha_desde) ? Helper::fecha( $proyecto->fecha_desde ) : '' ) }}"  >
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
          value="{{ old('fecha_hasta', isset($proyecto->fecha_hasta) ? Helper::fecha($proyecto->fecha_hasta) : ''  )}}">
        <div class="form-control-position">
          <i class='bx bx-calendar'></i>
        </div>
      </fieldset>
    <label>Fecha Hasta</label>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar</button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar</button>
  </div>
</div>
</div>
</form>
