{!! csrf_field() !!}

<div class="form-body">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="form-label-group">
          @if (empty($entregable->proyecto_id))
          <input type="text" data-ajax="/proyectos/autocomplete" class="form-control autocomplete" name="proyecto_id" placeholder="Proyecto">
          @else
            <input type="hidden" name="proyecto_id" value="{{ $entregable->proyecto_id }}">
            {!! $entregable->proyecto()->rotulo() !!}
          @endif
        <label for="">Proyecto</label>
      </div>
    </div>
@if(request()->ajax() && !empty($entregable->proyecto_id) && empty($entregable->id))
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
          <label>Vinculado a Pago</label>
        </div>
      </div>
    </div>
@endif
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <select name="estado_id" data-value="{{ old('estado_id', @$entregable->estado_id) }}" placeholder="Estado" required class="form-control">
          @foreach ($entregable->fillEstados() as $k => $v)
          <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
        <label for="">Estado</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="date" class="form-control" name="fecha" value="{{  old ( 'fecha', $entregable->fecha ) }}"  placeholder="Fecha" />
        <label for="fecha">Fecha</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <textarea class="form-control" placeholder="Descripción" name="descripcion">{{ old ( 'descripcion', $entregable->descripcion ) }}</textarea>
         <label for="">Descripción</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="text" data-ajax="/pagos/autocomplete?proyecto_id={{ @$entregable->proyecto_id }}" class="form-control autocomplete" name="pago_id" placeholder="Pago"
value="{{ old('pago_id', @$entregable->pago_id)}}"
@if(!empty($entregable->pago_id))
data-value="{{ $entregable->pago()->rotulo()}}"
@endif
>
        <label for="">Pago</label>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
