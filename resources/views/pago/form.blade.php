{!! csrf_field() !!}

<div class="form-body">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="form-label-group">
          @if (empty($pago->proyecto_id))
          <input type="text" data-ajax="/proyectos/autocomplete" class="form-control autocomplete" name="proyecto_id" placeholder="Proyecto">
          @else
            <input type="hidden" name="proyecto_id" value="{{ $pago->proyecto_id }}">
            {!! $pago->proyecto()->rotulo() !!}
          @endif
        <label for="">Proyecto</label>
      </div>
    </div>
@if(request()->ajax() && !empty($pago->proyecto_id) && empty($pago->id))
    <div class="col-md-6  col-12">
      <div class="block_space" style="margin-top: -50px;margin-bottom: 20px;">
        <h6>Secuencia</h6>
        <div class="form-label-group">
          <input type="number" class="form-control" placeholder="Cantidad" name="auto_cantidad" min="2" max="48" step="1">
          <label for="">Cantidad</label>
        </div>
        <div class="form-label-group">
          <input type="number" class="form-control" placeholder="Días de Intervalo" name="auto_dias" min="7" max="120" step="1">
          <label for="">Intervalo de Tiempo</label>
        </div>
        <div style="padding: 0 10px;text-align: center;">
          <input type="checkbox" name="auto_pago" value="1">
          <label>Vinculado a Entregable</label>
        </div>
      </div>
    </div>
@endif
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <select name="estado_id" data-value="{{ old('estado_id', @$pago->estado_id) }}" placeholder="Estado" required class="form-control">
          @foreach ($pago->fillEstados() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Estado</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="date" class="form-control" name="fecha" value="{{  old ( 'fecha', $pago->fecha ) }}"  placeholder="Fecha" />
        <label for="fecha">Fecha</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" class="form-control" name="monto" value="{{ old ('monto', $pago->monto )  }}" placeholder="Monto" min="1" max="10000000" step="0.01" required>
        <label for="plazo-servicio">Monto</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <select name="moneda_id" data-value="{{ old('moneda_id', @$pago->moneda_id) }}" required class="form-control">
          @foreach (App\Pago::selectMonedas() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label>Moneda</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="text" class="form-control" placeholder="Descripción" value="{{ old ( 'descripcion', $pago->descripcion ) }}" name="descripcion">
         <label for="">Descripción</label>
      </div>
    </div>
@if(!empty($pago->id))
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" class="form-control" name="monto_detraccion" value="{{ old ('monto_detraccion', $pago->monto_detraccion )  }}" placeholder="Monto Detraccion" min="0" max="100000" step="0.01" required>
        <label for="plazo-servicio">Monto Detracción</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" class="form-control" name="monto_penalidad" value="{{ old ('monto_penalidad', $pago->monto_penalidad )  }}" placeholder="Monto Penalidad" min="0" max="100000" step="0.01" required>
        <label for="plazo-servicio">Monto Penalidad</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" class="form-control" name="monto_depositado" value="{{ old ('monto_depositado', $pago->monto_depositado )  }}" placeholder="Monto Depositado" min="0" max="100000" step="0.01" required>
        <label for="plazo-servicio">Monto Depositado</label>
      </div>
    </div>
@endif
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
