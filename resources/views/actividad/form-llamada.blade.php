<h5 class="card-title">Llamada</h5>
@csrf
<div class="form-body">
  <div class="row">
    <div class="col-md-6  col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select class="form-control" name="direccion" data-value="{{ old('direccion', $actividad->direccion ?? '')}}"  >
          @foreach($actividad::fillDireccion() as $k => $v)
            <option value="{{ $k }}" >{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Dirección</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
        <div class="form-label-group">
        <input type="hidden">
          <select class="form-control" name="realizado">
            <option value="SI">SI</option>
            <option value="NO" selected>NO</option>
          </select>
          <label for="">¿Realizado? (*) </label>
        </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group">
          <fieldset class="form-label-group position-relative has-icon-left">
            <input type="date" name="fecha" class="form-control pickadate"
               placeholder="Fecha" value="{{ old ( 'fecha', $actividad->fecha ?? '' ) }}" >
              <div class="form-control-position">
                 <i class='bx bx-calendar'></i>
              </div>
            </fieldset>
           <label>Fecha (*) </label>
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
    <div class="col-md-6  col-12">
      <div class="form-label-group">
        <input type="hidden" >
        <select class="form-control" name="importancia" data-value="{ old('importancia', $actividad->importancia ?? '' )}"  >
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
    <div class="col-md-12 col-12">
      <div class="form-label-group">
         <textarea type="text" class="form-control" placeholder="Descripcion(*)" required name="texto">{{ old ( 'texto', $actividad->texto ?? '' ) }}</textarea>
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
