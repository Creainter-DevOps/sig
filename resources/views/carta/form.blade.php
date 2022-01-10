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
         <input type="date" class="form-control" placeholder="Fecha" value="{{ old ( 'fecha', $carta->fecha ) }}" name="fecha">
         <label for="">Fecha</label>
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
         <input type="text" class="form-control" placeholder="Asunto" value="{{ old ( 'rotulo', $carta->rotulo) }}" name="rotulo">
         <label for="">Asunto</label>
      </div>
    </div>
    <div class="col-12">
      <div style="text-align: center;font-size: 11px;border-bottom: 1px solid #b0bccb;margin-bottom: 20px;color: #475f7b;">Opcional</div>
    </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="entregable_id" data-ajax="/entregables/autocomplete?proyecto_id={{$carta->proyecto_id}}"
                value="{{ old('entregable_id', $carta->entregable_id ?? '' ) }}"
                @if (!empty($carta->entregable_id))
                  data-value="{{ $carta->entregable()->rotulo() }}"
                @endif
                name="entregable_id">
           <label for="entregable">Entregable</label>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="pago_id" data-ajax="/pagos/autocomplete?proyecto_id={{$carta->proyecto_id}}"
                value="{{ old('pago_id', $carta->pago_id ?? '' ) }}"
                @if (!empty($carta->pago_id))
                  data-value="{{ $carta->pago()->rotulo() }}"
                @endif
                name="pago_id">
           <label for="pago">Pago</label>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-label-group container-autocomplete ">
            <input type="text" class="form-control autocomplete" name="acta_id" data-ajax="/actas/autocomplete"
                value="{{ old('acta_id', $carta->acta_id ?? '' ) }}"
                @if (!empty($carta->acta_id))
                  data-value="{{ $carta->acta()->rotulo() }}"
                @endif
                name="acta_id">
           <label for="acta">Acta</label>
        </div>
      </div>
@if(!empty($carta->id))
    <div class="col-12">
      <div data-editable="/cartas/{{ $carta->id }}?_update=contenido" data-ishtml="true">{!! $carta->contenido !!}</div>
    </div>
@endif
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
