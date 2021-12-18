<div class="card-body">
  <h5 class="card-title">Nueva Cotización</h5>
<form action="{{ route('cotizaciones.store') }}" class="form" method="post">
@csrf
<div class="form-body">
  <div class="row">
  <div class="col-md-6 col-12">
@if(!empty($cotizacion->oportunidad_id))
  <input type="hidden" name="oportunidad_id" value="{{ $cotizacion->oportunidad_id }}">
  <div>{{ $cotizacion->oportunidad()->rotulo() }}</div><br /><br />
@else
    <div class="form-label-group container-autocomplete" >
      <input type="text" class="form-control autocomplete" name="oportunidad_id" value="{{ old('cotizacion_id', $cotizacion->oportunidad_id) }}" required
         data-ajax="/oportunidad/autocomplete?directas"
         data-register="{{  route('oportunidades.create')}}"
        @if( !empty($cotizacion->oportunidad_id ))
         data-value="{{ old ( 'oportunidad', null != $cotizacion->oportunidad() ?  $cotizacion->oportunidad()->rotulo() : '' ) }}"
        @endif
      >
      <label for="oportunidad_id">Oportunidad</label>
    </div>
@endif
  </div>
    <div class="col-md-6  col-12">
      <div class="form-label-group ">
          <input type="text" class="form-control autocomplete" value="{{ $cotizacion->empresa_id }}"
          @if (!empty($cotizacion->empresa_id))
             data-value="{{ $cotizacion->empresa()->razon_social  }}" 
          @endif
             data-ajax="/empresas/autocomplete?propias" name="empresa_id">
          <label for="">Empresa</label>
      </div>
 <div class="form-label-group">
      <fieldset class="form-label-group position-relative has-icon-left">
        <input type="date" name="fecha" class="form-control pickadate" placeholder="Fecha" value="{{ old ( 'fecha', isset($cotizacion->fecha) ? Helper::fecha( $cotizacion->fecha): '' ) }}"  >
          <div class="form-control-position">
             <i class='bx bx-calendar'></i>
          </div>
        </fieldset>
       <label>Fecha</label>
    </div>
    </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="text" id="decripcion" class="form-control" name="descripcion" value ="{{ old ( 'descripcion',  $cotizacion->descripcion ) }}" placeholder="Descripcion" required >
      <label for="decripcion">Descripcion</label>
  </div>
  </div>
  <div class="col-md-6 col-12">
    <div class="form-label-group">
      <input type="number" class="form-control" name="monto" value="{{ old ('monto', $cotizacion->monto )}}"  placeholder="Monto" >
      <label for="monto-neto">Monto</label>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
    <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Limpiar </button>
  </div>
</div>
</div>
</form>
</div>
