{!! csrf_field() !!}
<div class="form-body">
  <div class="row">
    <div class="col-mb-6 col-12"  >
      <div class="form-label-group container-autocomplete ">
        <label>Empresa</label>
          <input type="text" name="empresa_id" value="{{ old('empresa_id', @$producto->empresa_id ?? '' ) }}"  class="form-control autocomplete"
           placeholder="Empresa Proveedora" required data-ajax="/empresas/autocomplete?propias=true" data-register="/empresas/crear" 
           @if( !empty( @$producto->empresa_id ) )
              data-value="{{ @$producto->empresa()->razon_social }}"
           @endif
         >
          @if ($errors->has('empresa_id'))
          <div class="invalid-feedback">{{ $errors->first('empresa_id') }}</div>
          @endif
      </div>
    </div>
      <div class="col-12">
        <div class="form-label-group">
          <input type="text" name="nombre" placeholder="Nombre" class="form-control" value=" {{ old('nombre', @$producto->nombre) }}"  >
          <label>Nombre</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-label-group">
          <textarea name="descripcion"  placeholder="descripcion" class="form-control"value="{{ old('descripcion', @$producto->descripcion ) }}"   ></textarea>  
          <label>Descripcion</label>
        </div>
      </div>
      <div class="col-12 row">
      <div class="col-3">
        <div class="form-label-group">
          <input type="hidden"/>
          <select class="form-control"name="tipo" data-value="{{ old('tipo', @$producto->tipo ?? '' ) }}"  >
            @foreach( $producto->fillTipo() as $key =>  $value )
              <option value="{{ $key }}">{{ $value }}</option>
            @endforeach 
          </select>
          <label>Tipo</label>
        </div>
      </div>
      <div class="col-3">
        <div class="form-label-group">
          <input type="hidden"/>
          <select  class="form-control"name="unidad" data-value="{{ old('unidad', @$producto->unidad  ) }}"  >
            @foreach( $producto->fillUnidad() as $key =>  $value )
              <option value="{{ $key }}">{{ $value }}</option>
            @endforeach 
          </select>
          <label>Unidad</label>
        </div>
      </div>
        <div class="col-3">
          <div class="form-label-group">
            <input type="number" name="precio_unidad" placeholder="Precio"   class="form-control" value="{{ old('precio', @$producto->precio_unidad )  }}"   >
            <label>Precio</label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-label-group">
            <input type="hidden"/>
              <select class="form-control" name="moneda_id" data-value="{{ old('moneda_id', @$producto->moneda_id ) }}"  >
               @foreach( $producto->fillMoneda() as $key =>  $value )
                  <option value="{{ $key }}"  >{{ $value }}</option>
               @endforeach
              </select>
            <label>Moneda</label>
          </div>
        </div>
      </div>
      <div class="col-12 row">
        <div class="col-6">
          <div class="form-label-group">
            <input type="text" name="marca" placeholder="Marca"   class="form-control" value="{{ old('marca', @$producto->marca )}}"   >
            <label>Marca</label>
          </div>
        </div>
       
       <div class="col-6">
          <div class="form-label-group">
            <input type="text" name="modelo" placeholder="Modelo"   class="form-control" value="{{ old('modelo', @$producto->modelo )}}"   >
            <label>Modelo</label>
          </div>
        </div>
      </div>  
      <div class="col-12">
        <div class="form-label-group">
          <textarea name="parametros" placeholder="Parametros" class="form-control">{{ old('parametros', @$producto->parametros ) }} </textarea>
          <label>Parametros</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-label-group">
          <textarea name="formula" placeholder="Formula" class="form-control">{{ old('formula', @$producto->formula) }} </textarea>
          <label>Formula</label>
        </div>
      </div>
    </div>
    <div class="col-mb-6 col-12 d-flex flex-row-reverse">
      <button class="btn  btn-primary">Guardar</button>
    </div>
  </div>
</div>
