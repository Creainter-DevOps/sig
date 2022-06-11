
<div class="modal fade  modal-dialog-centered" id="modalAddProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAddProducto" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="proveedor_id" value="{{ $proveedor->id ?? 0 }}"/>
            <input type="hidden" name="id"  value="0"/>
            <div class="row">
              <div class="col-mb-6 col-12">
                <div class="form-label-group container-autocomplete">
                  <input type="text" class="form-control autocomplete" name="producto_id"  placeholder="Producto" required data-ajax="/productos/autocomplete"   >
                  <label>Producto</label> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-mb-6 col-6">
                <div class="form-label-group ">
                  <input type="number" steep="0.1"  class="form-control" name="monto"  placeholder="Monto" required>
                  <label>Monto</label>
                </div>
              </div>
              <div class="col-mb-6 col-6">
                <div class="form-label-group">
                  <input type="text" class="form-control " name="garantia" placeholder="Garantia" required >
                  <label>Garantia</label>
                </div>
              </div>
           </div>
           <div class="row">
              <div class="col-mb-8 col-8">
                <div class="form-label-group ">
                  <input type="text" class="form-control " name="plazo_entrega"  placeholder="Plazo de entrega" required >
                  <label>Plazo de entrega</label>
                </div>
              </div>
              <div class="col-mb-4 col-4">
                <div class="form-label-group ">
                  <input type="hidden">
                  <select class="form-control" name="moneda_id" >
                  @foreach ( Helper::moneda() as $key => $value )
                    <option value="{{ $key }}">{{$value}}</option>
                  @endforeach
                  </select>  
                  <label>Moneda</label>
                </div>
              </div>
           </div>
           <div class="row"> 
            <div class="col-mb-12 col-12">
              <div class="form-label-group ">
                <textarea class="form-control" name="parametros"   placeholder="Parametros" required ></textarea>
                <label>Parametros</label> 
              </div>
            </div>
           </div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
