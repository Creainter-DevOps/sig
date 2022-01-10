<h5 class="card-title">Reunión</h5>
@csrf
<div class="form-body">
  <div class="row">
    <div class="col-md-6  col-12">
      <div class="form-label-group">
        <input type="hidden" >
        <select class="form-control" name="importancia" data-value="{{ old('importancia', $actividad->importancia ?? '') }}"  >
          @foreach( $actividad::fillImportancia() as $k => $v )
            <option value="{{ $k }}" >{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Importancia(*) </label>
      </div>
    </div>
    <div class="col-md-6  col-12">
        <div class="form-label-group">
        <input type="hidden">
          <select class="form-control" name="estado" data-value="{{ $actividad->estado }}">
            <option value="3">Terminado</option>
            <option value="2">En Proceso</option>
            <option value="1" selected>Programar</option>
          </select>
          <label for="">Estado (*) </label>
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
    <div class="col-md-12 col-12">
      <div class="form-label-group">
         <textarea type="text" class="form-control" placeholder="Descripcion(*)" required name="texto">{{ old ( 'texto', $actividad->texto ?? '' ) }}</textarea>
         <label for="">Descripcion(*)</label>
      </div>
    </div>
@if(!empty($actividad->id))
    <div class="col-12">
      <div data-editable="/actividades/{{ $actividad->id }}?_update=contenido" data-ishtml="true">{!! $actividad->contenido !!}</div>
    </div>
@endif
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
