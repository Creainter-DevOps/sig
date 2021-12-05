@csrf
<div class="form-body">
  <div class="row">
  <div class="col-md-6  col-12">
      <div class="form-label-group">
          @if (empty($actividad->empresa_id))
          <input type="text" class="form-control autocomplete"
             data-ajax="/empresas/autocomplete" name="empresa_id">
          <label for="">Empresa</label>
          @else
          <input type="text" class="form-control autocomplete" value="{{ $actividad->empresa_id }}"
             data-value="{{ $actividad->empresa()->razon_social  }}"
             data-ajax="/empresas/autocomplete" name="empresa_id">
          <label for="">Empresa</label>
          @endif
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          @if (empty($actividad->cliente_id))
          <input type="text" class="form-control autocomplete"
             data-ajax="/clientes/autocomplete" name="cliente_id">
          <label for="cliente_id">Cliente</label>
          @else
          <input type="text" class="form-control autocomplete" value="{{ $actividad->cliente_id }}"
             data-value="{{ $actividad->cliente()->empresa()->razon_social  ?? ''  }}"
             data-ajax="/clientes/autocomplete" name="cliente_id">
          <label for="cliente_id">Cliente</label>
          @endif
      </div>
    </div>
     <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete" >
          <input type="text" class="form-control autocomplete" name="oportunidad_id" 
             id="oportunidad_id" value="{{ old('cotizacion_id', $actividad->oportunidad_id ?? '' ) }}"
             data-ajax="/oportunidad/autocomplete"
            @if( !empty($actividad->oportunidad_id ))
             data-value="{{ old ( 'oportunidad', $actividad->oportunidad()->rotulo() ) }}"
            @endif
          >
          <label for="oportunidad_id"> Oportunidad </label>
        </div>
      </div>
      <div class="col-md-6  col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="contacto_id" data-register="/contactos/fast" data-ajax="/contactos/autocomplete"
                value="{{ old('contacto_id', $actividad->contacto_id ?? '' ) }}"
                @if (!empty($actividad->contacto_id))
                data-value=" {{ old( 'contacto_id', $actividad->contacto()->nombres )}}"
                @endif
                name="contacto_id">
           <label for="contacto_id">Contacto</label>
        </div>
      </div>
      <div class="col-md-12 col-12">
        <div class="form-label-group">
            @if (empty($actividad->proyecto_id) )
            <input type="text" class="form-control autocomplete"
               data-ajax="/proyectos/autocomplete" name="proyecto_id">
            <label for="">Proyecto</label>
            @else
            <input type="text" class="form-control autocomplete" value="{{ $actividad->cliente_id }}"
               data-value="{{ $actividad->proyecto()->nombre }}"
               data-ajax="/proyectos/autocomplete" name="proyecto_id">
            <label for="">Proyecto</label>
            @endif
        </div>
      </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="text" class="form-control" placeholder="Nombre(*)" value="{{ old ( 'nombres', $actividad->evento ??''  ) }}"  id="nombres" name="evento" required>
          <label for="">Nombre(*) </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
            <input type="text" class="form-control  autocomplete" placeholder="Asignado(*)" data-ajax="/usuarios/autocomplete"
             value="{{ old ( 'asignado_id', $actividad->asignado_id  ?? '' ) }}"  id="orden"
             name="asignado_id" required data-value="{{ isset($actividad->asignado_id) ? $actividad->usuario() : '' }}" >
          <label for="">Asignado (*) </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="number" class="form-control" placeholder="Orden(*)" value="{{ old ( 'orden', $actividad->orden  ?? '' ) }}"  id="orden" name="evento" required>
          <label for="">Orden (*)</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <input type="hidden">
      <div class="form-label-group">
          <fieldset class="form-label-group position-relative has-icon-left">
            <input type="text" id="fecha_limite" name="fecha_limite" class="form-control pickadate" 
                   placeholder="Fecha Limite" value="{{ old ( 'fecha_limite', isset($activiad) ? Helper::fecha( $actividad->fecha_limite ) : '' ) }}" >
              <div class="form-control-position">
                 <i class='bx bx-calendar'></i>
              </div>
            </fieldset>
           <label>Fecha Limite (*) </label>
        </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
         <textarea   type="text" class="form-control" placeholder="Descripcion(*)" required name="texto">{{ old ( 'texto', $actividad->texto ?? '' ) }}</textarea>
         <label for="">Descripcion(*)</label>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
