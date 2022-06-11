<section class="invoice-edit-wrapper">
  <div class="row">
    <!-- invoice view page -->
    <div class="col-xl-12 col-md-12 col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body pb-0 mx-25">
            <!-- header section -->
            <div class="row mx-0">
              <div class="col-xl-4 col-md-12 d-flex align-items-center pl-0">
                <h6 class="invoice-number mr-75">Cotizacion# {{ $cotizacion->id }}</h6>
                <!--<input type="text" class="form-control pt-25 w-50" value=""  placeholder="#000">-->
              </div>
              <div class="col-xl-8 col-md-12 px-0 pt-xl-0 pt-1">
                <div class="invoice-date-picker d-flex align-items-center justify-content-end flex-wrap">
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-75">Fecha Inicio: </small>
                    <fieldset class="d-flex ">
                      <input type="date" value="{{$cotizacion->fecha }}" class="form-control  mb-50 mb-sm-0" placeholder="Seleciona fecha">
                    </fieldset>
                  </div>
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-75">Fecha Vencimiento: </small>
                    <fieldset class="d-flex justify-content-end">
                      <input type="date" value="{{ $cotizacion->validez }}"  class="form-control mb-50 mb-sm-0" placeholder="Select Date">
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <!-- logo and title -->
            <div class="row my-2 py-50">
              <div class="col-sm-12 col-12 order-2 order-sm-1">
                <h4 class="text-primary">{{ $cotizacion->rotulo }}</h4>
              </div>
            </div>
            <hr>
          </div>
          <div class="card-body pt-50">
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
                 <tr>
                  <td style=" width: 2%;
    padding: 0;
    text-align: left;"  ><a data-id="4" style="cursor:pointer;" data-toggle="modal" data-target="#exampleModalCenter">
                  <i class="badge-circle badge-circle-danger bx bx-x font-medium-1"></i>
                </a></td>
                  <td class="nombre"  style=" width: 40%; padding:10px 5px;" ><input class="form-control autocomplete" type="text" placeholder="Producto" data-ajax="/productos/autocomplete"></td>
                  <td class="precio"   style="padding:10px 5px;" ><input class="form-control" type="number"  placeholder="Precio"></td>
                  <td class="cantidad" style="padding:10px 5px;" ><input class="form-control" type="number" placeholder="Cantidad"></td>
                  <td class="subtotal" style="text-align: right;">0.00</td>
                </tr> 
              </tbody>
              <template id="template">
                <tr>
                  <td class="nombre"></td>
                  <td class="precio"></td>
                  <td class="cantidad"><input></td>
                  <td class="subtotal"></td>
                </tr> 
              </template>
            </table>  
            <div class="form-group">
                <div class="col p-0">
                  <button class="btn btn-light-primary btn-sm" onclick="addProduct()"  data-toggle="modal" data-target="#modalAddProduct" data-repeater-create type="button">
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
                  <!--<div class="form-group">
                    <input type="text" class="form-control" placeholder="Add Payment Terms">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Add client Note">
                  </div>-->
                </div>
                <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">Subtotal</span>
                      <h6 class="invoice-subtotal-value mb-0">$00.00</h6>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">Descuento</span>
                      <h6 class="invoice-subtotal-value mb-0">- $ 00.00</h6>
                    </li>
                    <!--<li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">Tax</span>
                      <h6 class="invoice-subtotal-value mb-0">0.0%</h6>
                    </li>-->
                    <li class="list-group-item py-0 border-0 mt-25">
                      <hr>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 py-0">
                      <span class="invoice-subtotal-title">Total </span>
                      <h6 class="invoice-subtotal-value mb-0">$ 00.00</h6>
                    </li>
                    <!--<li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">Paid to date</span>
                      <h6 class="invoice-subtotal-value mb-0">- $ 00.00</h6>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                      <span class="invoice-subtotal-title">Balance (USD)</span>
                      <h6 class="invoice-subtotal-value mb-0">$ 000</h6>
                    </li>
                    <li class="list-group-item border-0 pb-0">
                      <button class="btn btn-primary btn-block subtotal-preview-btn">Preview</button>
                    </li>-->
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
