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
          <select class="form-control" name="realizado" data-value="{{ $actividad->realizado ? '1' : '0' }}">
            <option value="1">SI</option>
            <option value="0" selected>NO</option>
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
      <div class="form-label-group">
          <fieldset class="form-label-group position-relative has-icon-left">
            <input type="time" name="hora" class="form-control pickadate"
               placeholder="Hora" value="{{ old ( 'hora', $actividad->hora ?? '' ) }}" >
              <div class="form-control-position">
                 <i class='bx bx-calendar'></i>
              </div>
            </fieldset>
           <label>Hora </label>
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
        <div class="form-label-group container-autocomplete">
            <input type="text" class="form-control autocomplete" name="callerid_id" data-ajax="/callerids/autocomplete"
                value="{{ old('callerid_id', $actividad->callerid_id ?? '' ) }}"
                @if (!empty($actividad->callerid_id))
                  data-value="{{ old( 'callerid_id', $actividad->callerid()->rotulo() )}}"
                @endif
                name="callerid_id">
           <label for="callerid_id">callerid</label>
        </div>
      </div>
    <div class="col-md-12 col-12">
      <div class="form-label-group">
         <textarea type="text" class="form-control" placeholder="Descripcion(*)" required name="texto">{{ old ( 'texto', $actividad->texto ?? '' ) }}</textarea>
         <label for="">Descripcion(*)</label>
      </div>
      <div style="text-align: center;font-size: 11px;border-bottom: 1px solid #b0bccb;margin-bottom: 20px;color: #475f7b;">Opcional</div>
    </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="entregable_id" data-ajax="/entregables/autocomplete?proyecto_id={{$actividad->proyecto_id}}"
                value="{{ old('entregable_id', $actividad->entregable_id ?? '' ) }}"
                @if (!empty($actividad->entregable_id))
                  data-value="{{ $actividad->entregable()->rotulo() }}"
                @endif
                name="entregable_id">
           <label for="entregable">Entregable</label>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="pago_id" data-ajax="/pagos/autocomplete?proyecto_id={{$actividad->proyecto_id}}"
                value="{{ old('pago_id', $actividad->pago_id ?? '' ) }}"
                @if (!empty($actividad->pago_id))
                  data-value="{{ $actividad->pago()->rotulo() }}"
                @endif
                name="pago_id">
           <label for="pago">Pago</label>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="carta_id" data-ajax="/cartas/autocomplete"
                value="{{ old('carta_id', $actividad->carta_id ?? '' ) }}"
                @if (!empty($actividad->carta_id))
                  data-value="{{ $actividad->carta()->rotulo() }}"
                @endif
                name="carta_id">
           <label for="carta">Carta</label>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="acta_id" data-ajax="/actas/autocomplete"
                value="{{ old('acta_id', $actividad->acta_id ?? '' ) }}"
                @if (!empty($actividad->acta_id))
                  data-value="{{ $actividad->acta()->rotulo() }}"
                @endif
                name="acta_id">
           <label for="acta">Acta</label>
        </div>
      </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
