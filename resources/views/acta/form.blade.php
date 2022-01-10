{!! csrf_field() !!}

<div class="form-body">
  <div class="row">
    <div class="col-md-12 col-12">
      <div class="form-label-group">
          @if (empty($acta->proyecto_id))
          <input type="text" data-ajax="/proyectos/autocomplete" class="form-control autocomplete" name="proyecto_id" placeholder="Proyecto">
          @else
            <input type="hidden" name="proyecto_id" value="{{ $acta->proyecto_id }}">
            {!! $acta->proyecto()->rotulo() !!}
          @endif
        <label for="">Proyecto</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="date" class="form-control" placeholder="Fecha" value="{{ old ( 'fecha', $acta->fecha ) }}" name="fecha">
         <label for="">Fecha</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select name="estado_id" data-value="{{ old('estado_id', @$acta->estado_id) }}" placeholder="Estado" required class="form-control">
          @foreach ($acta->fillEstados() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Estado</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="text" class="form-control" placeholder="Descripcion" value="{{ old ( 'rotulo', $acta->rotulo) }}" name="rotulo">
         <label for="">Asunto</label>
      </div>
    </div>
@if(!empty($acta->id))
    <div class="col-12">
      <div data-editable="/actas/{{ $acta->id }}?_update=contenido" data-ishtml="true">{!! $acta->contenido !!}</div>
    </div>
@endif
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
