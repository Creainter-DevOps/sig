{!! csrf_field() !!}

<div class="form-body">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="form-label-group">
          @if (empty($gasto->proyecto_id))
          <input type="text" data-ajax="/proyectos/autocomplete" class="form-control autocomplete" name="proyecto_id" placeholder="Proyecto">
          @else
            <input type="hidden" name="proyecto_id" value="{{ $gasto->proyecto_id }}">
            {!! $gasto->proyecto()->rotulo() !!}
          @endif
        <label for="">Proyecto</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <select name="estado_id" data-value="{{ old('estado_id', @$gasto->estado_id) }}" placeholder="Estado" required class="form-control">
          @foreach ($gasto->fillEstados() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Estado</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="date" class="form-control" name="fecha" value="{{  old ( 'fecha', $gasto->fecha ) }}"  placeholder="Fecha" />
        <label for="fecha">Fecha</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <select name="moneda_id" data-value="{{ old('moneda_id', @$gasto->moneda_id) }}" required class="form-control">
          @foreach (App\Gasto::selectMonedas() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label>Moneda</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <select name="tipo" data-value="{{ old('tipo', @$gasto->tipo) }}" required class="form-control">
          @foreach (App\Gasto::selectTipos() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label>Tipo</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="text" class="form-control" placeholder="Descripción" value="{{ old ( 'descripcion', $gasto->descripcion ) }}" name="descripcion">
         <label for="">Descripción</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" class="form-control" name="monto" value="{{ old ('monto', $gasto->monto )  }}" placeholder="Monto" min="1" max="100000" step="0.01" required>
        <label for="plazo-servicio">Monto</label>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
