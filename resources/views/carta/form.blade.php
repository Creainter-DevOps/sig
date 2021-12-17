{!! csrf_field() !!}

<div class="form-body">
  <div class="row">
    <div class="col-md-12 col-12">
      <div class="form-label-group">
          @if (empty($carta->proyecto_id))
          <input type="text" data-ajax="/proyectos/autocomplete" class="form-control autocomplete" name="proyecto_id" placeholder="Proyecto">
          @else
            <input type="hidden" name="proyecto_id" value="{{ $carta->proyecto_id }}">
            {!! $carta->proyecto()->rotulo() !!}
          @endif
        <label for="">Proyecto</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="text" class="form-control" placeholder="Dirección" value="{{ old ( 'direccion', $carta->direccion ) }}" name="direccion">
         <label for="">Direccion</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="hidden">
        <select name="estado_id" data-value="{{ old('estado_id', @$carta->estado_id) }}" placeholder="Estado" required class="form-control">
          @foreach ($carta->fillEstados() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Estado</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="text" class="form-control" placeholder="Descripcion" value="{{ old ( 'texto', $carta->texto) }}" name="texto">
         <label for="">Descripcion</label>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
