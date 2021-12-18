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
      <div class="form-label-group container-autocomplete">
          @if (empty($actividad->cliente_id))
          <input type="text" class="form-control autocomplete"
             data-ajax="/clientes/autocomplete" name="cliente_id"
              data-register="/clientes/crear"
              >
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
                  data-value="{{ old( 'contacto_id', $actividad->contacto()->nombres )}}"
                @endif
                name="contacto_id">
           <label for="contacto_id">Contacto</label>
        </div>
      </div>
      <div class="col-md-12 col-12">
        <div class="form-label-group">
            <input type="text" class="form-control autocomplete" value="{{ $actividad->cliente_id }}"
               data-ajax="/proyectos/autocomplete" 
               @if (!empty( $actividad->proyecto_id) )  
                data-value="{{ $actividad->proyecto()->nombre }}"
               @endif
               name="proyecto_id">
            <label for="">Proyecto</label>
        </div>
      </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="text" class="form-control autocomplete" value="{{ $actividad->bloque_id }}"
           data-ajax="/bloques/autocomplete" 
           @if (!empty( $actividad->proyecto_id) )  
            data-value="{{ $actividad->bloque()->nombre }}"
           @endif
           name="bloque_id">
        <label for="">Bloque</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="text" class="form-control autocomplete" value="{{ $actividad->entregable_id }}"
           data-ajax="/entregables/autocomplete" 
           @if (!empty( $actividad->entregable_id) )  
            data-value="{{ $actividad->entregable()->nombre }}"
           @endif
           name="entregable_id">
        <label for="">Entregable</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
        <input type="hidden" >
        <select class="form-control" name="tipo" data-value="{ old('tipo', $actividad->tipo ?? '' )} "  >
          @foreach( $actividad::fillTipo() as $k => $v )
            <option value="{{ $k }}" >{{ $v }}</option>
          @endforeach
        </select>    
        <label for="">Tipo(*) </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
        <input type="hidden" >
        <select class="form-control" name="importancia" data-value="{ old('importancia', $actividad->importancia ?? '' )} "  >
          @foreach( $actividad::fillImportancia() as $k => $v )
            <option value="{{ $k }}" >{{ $v }}</option>
          @endforeach
        </select>    
        <label for="">Importancia(*) </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
            <input type="text" class="form-control  autocomplete" placeholder="Asignado(*)" data-ajax="/usuarios/autocomplete"
             value="{{ old ( 'asignado_id', $actividad->asignado_id  ?? '' ) }}"  id="orden"
             name="asignado_id" required data-value="{!!  isset($actividad->asignado_id) ? $actividad->usuario() : '' !!}" >
          <label for="">Asignado (*) </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="number" class="form-control" placeholder="Orden(*)" value="{{ old ( 'orden', $actividad->orden  ?? '' ) }}"  id="orden" name="orden" required >
          <label for="">Orden (*)</label>
      </div>
    </div>
    <!--<div class="col-md-6  col-12">
      <div class="form-label-group">
        <select class="form-control text-white " name="color" >
          <option value="primary" class="bg-primary" selected  >Primary</option>
          <option value="danger" class="bg-danger">Danger</option>
          <option value="success" class="bg-success">Success</option>
          <option value="info" class="bg-info">Info</option>
          <option value="warning" class="bg-warning">Warning</option>
          <option value="secondary" class="bg-secondary">Secondary</option>
        </select>
          <label for="">Color (*)</label>
      </div>
    </div>-->
    <div class="col-md-6  col-12">
      <input type="hidden">
      <div class="form-label-group">
          <fieldset class="form-label-group position-relative has-icon-left">
            <input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control pickadate" 
               placeholder="Fecha inicio" value="{{ old ( 'fecha_comienzo', isset($activiad) ? Helper::fecha( $actividad->fecha_comienzo ) : '' ) }}" >
              <div class="form-control-position">
                 <i class='bx bx-calendar'></i>
              </div>
            </fieldset>
           <label>Fecha inicio (*) </label>
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
           <label>Fecha limite  (*) </label>
        </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <input type="text" class="form-control" placeholder="Nombre(*)" value="{{ old ( 'nombres', $actividad->evento ??''  ) }}"  id="nombres" name="evento" required>
          <label for="">Nombre(*) </label>
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
