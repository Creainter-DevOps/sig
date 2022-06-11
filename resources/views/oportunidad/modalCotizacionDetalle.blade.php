<div class="modal fade" id="modalCotizacionDetalle" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cotizacion #</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="invoice-edit-wrapper">
        <div class="row">
          <!-- invoice view page -->
          <div class="card-content" style="width:100%" >
            <div class="card-body pb-0 mx-25">
              <!-- header section -->
              <div class="row my-2 py-50">
                <div class="col-sm-12 col-12 order-2 order-sm-1">
                  <h4 class="text-primary"></h4>
                </div>
              </div>
              <hr>
              <div class="row mx-0 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                  <small class="text-muted mr-75">Fecha Inicio: </small>
                  <fieldset class="d-flex ">
                    <input type="date" name="fecha"  value="" class="form-control  mb-50 mb-sm-0" placeholder="Seleciona fecha">
                  </fieldset>
                </div>
                <div class="d-flex align-items-center">
                  <small class="text-muted mr-75">Fecha Vencimiento: </small>
                  <fieldset class="d-flex justify-content-end">
                    <input type="date" name="validez"  value=""  class="form-control mb-50 mb-sm-0" placeholder="Select Date">
                  </fieldset>
                </div>
              </div>
              <!-- logo and title -->
            </div>
            <div class="card-body pt-50">
              <p class="text-primary">Detalle</p>
              <hr>
              <table class="table">
                <thead>
                 <tr>
                  <th></th>
                   <th>Item</th>
                   <th>Precio.U</th>
                   <th>Cantidad</th>
                   <th>Subtotal</th>
                </tr>
                </thead>
                <tbody id="productos">
                </tbody>
                <template id="template">
                   <tr>
                    <td style=" width: 2%;padding: 0; text-align: left;">
                      <a data-id="4" style="cursor:pointer;" data-remove="true"  data-action="removeElement"  data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="badge-circle badge-circle-danger bx bx-x font-medium-1"></i>
                      </a>
                    </td>
                    <td  style=" width: 40%; padding:10px 5px;" >
                      <input class="form-control autocomplete producto" type="text" name="producto_id" placeholder="Producto" data-ajax="/productos/autocomplete"></td>
                    <td style="padding:10px 5px;" ><input  data-action="changePrecio" onkeyup="changePrecio(this)" class="form-control precio" name="precio"  type="number"  placeholder="Precio"></td>
                    <td  style="padding:10px 5px;" ><input  data-action="changeCantidad" onkeyup="changePrecio(this)" class=" form-control cantidad" type="number" placeholder="Cantidad"></td>
                    <td class="subtotal" style="text-align: right; ">0.00</td>
                  </tr> 
                </template>
              </table>  
              <div class="form-group">
                  <div class="col p-0">
                    <button class="btn btn-light-primary btn-sm" onclick="addProduct()" data-toggle="modal" data-target="#modalAddProduct" data-repeater-create type="button">
                      <i class="bx bx-plus"></i>
                      <span class="invoice-repeat-btn">Agregar producto</span>
                    </button>
                </div>
             </div>
              <!-- invoice subtotal -->
              <hr>
              <div class="invoice-subtotal pt-50">
                <div class="row">
                  <div class="col-md-5 col-12">
                  </div>
                  <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                        <span class="invoice-subtotal-title ">Subtotal</span>
                        <h6 class="c-subtotal invoice-subtotal-value mb-0">S/00.00</h6>
                      </li>
                      <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                        <span class="invoice-subtotal-title">Descuento</span>
                        <h6 class="invoice-subtotal-value mb-0">- S/ 00.00</h6>
                      </li>
                      <li class="list-group-item py-0 border-0 mt-25">
                        <hr>
                      </li>
                      <li class="list-group-item d-flex justify-content-between border-0 py-0">
                        <span class="invoice-subtotal-title">Total </span>
                        <h6 class="invoice-subtotal-value mb-0 c-total ">S/ 00.00</h6>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="saveDetalle()" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
