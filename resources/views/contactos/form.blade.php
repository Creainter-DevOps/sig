@csrf
<div class="form-body">
  <div class="row">
    <input type="hidden" value="{{$contacto->id ?? 0 }}" name="id" id="id" data-contacto="{{ $contacto->id ?? 0 }}" 
></input>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
          @if (!empty($contacto->cliente_id ))
          <input type="text" id="cliente_id" data-ajax="/clientes/autocomplete"
          value="{{ old ('cliente', $contacto->cliente_id) }}" class="form-control autocomplete" name="cliente_id"
          data-value="{{ old( 'cliente',$contacto->cliente()->empresa()->razon_social ) }}"  placeholder="Empresa">
          @else
             <input type="text" id="cliente_id" autofocus data-ajax="/clientes/autocomplete"  class="form-control autocomplete" name="cliente_id"
            placeholder="Empresa">
          @endif
        <label for="">Empresa</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group"?>
          <input type="text" class="form-control" placeholder="Nombres(*)" value="{{ old ( 'nombres', $contacto->nombres ) }}"  id="nombres" name="nombres" required>
          <label for="">Nombres</label>
      </div>
    </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group" >
         <input type="text" class="form-control" placeholder="Apellidos(*) " value="{{ old ( 'apellidos', $contacto->apellidos ) }}"  id="apellidos" name="apellidos"> 
         <label for=""> Apellidos</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group" id="container-select-oportunidad">
        <input type="mail" class="form-control" id="oportunidad_id" name="correo"  value="{{ old( 'correo', $contacto->correo ) }}"   placeholder="Correo(*)">
        <label for=""> Correo(*) </label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="text" id="celular" class="form-control" name="celular" value="{{ old ('celular', $contacto->celular )  }}" placeholder="Celular" required   >
        <label for="plazo-servicio">Celular</label>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" id="dni" class="form-control" name="dni" value="{{  old ( 'dni', $contacto->dni ) }}"  placeholder="DNI"  >
        <label for="dni">DNI</label>
      </div>
    </div>

    <div class="col-md-6 col-12">
      <div class="form-label-group">
        <input type="number" id="area" class="form-control" name="area" value="{{ old ( 'area', $contacto->dni ) }}"  placeholder="Area">
        <label for="dni">Area</label>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
      <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
    </div>
  </div>
</div>
</form>
