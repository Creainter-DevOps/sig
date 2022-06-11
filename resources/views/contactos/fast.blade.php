<div class="card-body">
  <h5 class="card-title">Nuevo contacto </h5>
  <form class="form" action="{{ route('contactos.store') }}" method="post" >
      @csrf
      <div class="form-body">
        <div class="row">
          <div class="col-md-12 col-12">
@if(!empty($contacto->cliente_id))
        {{ $contacto->cliente()->empresa()->razon_social }}
@else
      <div class="form-label-group">
          <input type="text" id="empresa_id" data-ajax="/empresas/autocomplete"
          class="form-control autocomplete" name="empresa_id"
          placeholder="Empresa">
        <label for="">Empresa</label>
      </div>
      @endif
          </div>
          <div class="col-md-6  col-12">
            <div class="form-label-group">
                <input type="text" class="form-control" placeholder="Nombres(*)"   id="nombres" name="nombres" required>
                <label for="">Nombres(*)</label>
            </div>
          </div>
          <div class="col-md-6  col-12">
            <div class="form-label-group" >
               <input type="text" class="form-control" placeholder="Apellidos(*) "   id="apellidos" name="apellidos" required> 
               <label for=""> Apellidos(*)</label>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="form-label-group" >
              <input type="email" class="form-control"  name="correo"  placeholder="Correo" >
              <label for="">Correo(*)</label>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="form-label-group">
              <input type="text" id="celular" class="form-control" name="celular" placeholder="Celular" required>
              <label for="plazo-servicio">Celular</label>
            </div>
          </div>
          <div class="col-md-12 col-12">
            <div class="form-label-group">
              <input type="text" class="form-control" name="area" placeholder="Área de trabajo" required>
              <label>Área</label>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-1 mb-1">Guardar </button>
            <button type="reset" class="btn btn-light-danger  mr-1 mb-1" data-dismiss="modal"   >Cancelar</button>
          </div>
        </div>
      </div>
   </form>
</div>
