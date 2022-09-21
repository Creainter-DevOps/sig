@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Invoice Add')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Bucket.css') }}">
@endsection
{{-- page styles --}}
@section('page-styles')
@parent
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')
    <!-- app invoice View Page -->
<section class="invoice-edit-wrapper">
  <div class="row">
            <div class="col-12">
                <div class="row">
                  <div class="col-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                @include('oportunidad.table', [
                                  'oportunidad' => $cotizacion->oportunidad()
                                ])
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-6">
                @include('actividad.create', [
                    'into' => [
                        'cotizacion_id'  => $cotizacion->id,
                        'oportunidad_id' => $cotizacion->oportunidad_id,
                        'licitacion_id'  => $cotizacion->oportunidad()->licitacion_id,
                    ],
                ])
                  </div>
                </div>
            </div>
    <!-- invoice view page -->
    <div class="col-xl-9 col-md-8 col-12">
      <div class="card">
        <div class="card-content">
          <form class="form invoice-item-repeater" method="POST">
              @csrf
          <div class="card-body pb-0 mx-25">
            <!-- header section -->
            <div class="row mx-0">
              <div class="col-xl-4 col-md-12 d-flex align-items-center pl-0">
                <h6 class="invoice-number mr-75">#{{ $cotizacion->codigo() }}</h6>
              </div>
              <div class="col-xl-8 col-md-12 px-0 pt-xl-0 pt-1">
                <div class="invoice-date-picker d-flex align-items-center justify-content-xl-end flex-wrap">
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-75">Fecha: </small>
                    <fieldset class="d-flex ">
                      <input type="text" name="fecha" class="form-control pickadate mr-2 mb-50 mb-sm-0" placeholder="Seleccione" value="{{ $cotizacion->fecha }}">
                    </fieldset>
                  </div>
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-75">Vencimiento: </small>
                    <fieldset class="d-flex align-items-center">
                      <input type="text" name="validez" class="form-control pickadate mb-50 mb-sm-0" placeholder="Seleccione" value="{{ $cotizacion->validez }}">
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row my-2 py-50">
              <div class="col-sm-6 col-12 order-2 order-sm-1">
                <h4 class="text-primary">Cotización</h4>
              </div>
              <div class="col-sm-6 col-12 order-1 order-sm-1 d-flex justify-content-end">
                <img src="{{asset('images/pages/pixinvent-logo.png')}}" alt="logo" height="46" width="164">
              </div>
            </div>
            <hr>
            <!-- invoice address and contact -->
            <div class="row invoice-info">
              <div class="col-6 mt-1">
                <h6 class="invoice-from">Generado por:</h6>
                <div class="mb-1">
                  <span>{{ $cotizacion->empresa()->razon_social }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $cotizacion->empresa()->direccion }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $cotizacion->empresa()->correo_electronico }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $cotizacion->empresa()->telefono }}</span>
                </div>
              </div>
              <div class="col-6 mt-1">
                <h6 class="invoice-to">Dirigido a:</h6>
                @if(empty($cotizacion->oportunidad()->empresa_id))
                  <div style="background: #ffc800;color: #fff;padding: 10px;">
                    Es importante vincular la Oportunidad a una empresa para finalizar con la cotización.
                    Haga click <a href="/oportunidades/{{ $cotizacion->oportunidad_id }}">Aquí</a>
                  </div>
                @else
                <div class="mb-1">
                  <span>{{ $cotizacion->oportunidad()->empresa()->razon_social }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $cotizacion->oportunidad()->empresa()->direccion }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $cotizacion->oportunidad()->empresa()->correo_electronico }}</span>
                </div>
                <div class="mb-1">
                  <span>{{ $cotizacion->oportunidad()->empresa()->telefono }}</span>
                </div>
                @endif
              </div>
            </div>
            <hr>
          </div>
          <div class="card-body pt-50">
            <div class="invoice-product-details">
              <div data-repeater-list="item">
                @if (empty( $cotizacion->items()) )
                <div data-repeater-item>
                  <div class="row mb-50">
                    <div class="col-3 col-md-5 invoice-item-title">Item</div>
                    <div class="col-3 col-md-3 invoice-item-title">Costo</div>
                    <div class="col-3 col-md-2 nvoice-item-title">Cantidad</div>
                    <div class="col-3 col-md-2 invoice-item-title">Precio</div>
                  </div>
                  <div class="invoice-item d-flex border rounded mb-1">
                    <div class="invoice-item-filed row pt-1 px-1">
                      <div class="col-12 col-md-5 form-group">
                        <input type="text" class="form-control" value="" name="producto" placeholder="Item" required>
                      </div>
                      <div class="col-md-3 col-12 form-group">
                        <input type="text" class="form-control txtMonto" name="costo" value="0">
                      </div>
                      <div class="col-md-2 col-12 form-group">
                        <input type="text" class="form-control txtCantidad" name="cantidad" value="1">
                      </div>
                      <div class="col-md-2 col-12 form-group">
                        <strong class="text-primary align-middle txtTotalItem">00.00</strong>
                      </div>
                      <div class="col-md-5 col-12 form-group">
                        <textarea class="form-control invoice-item-desc" name="descripcion" placeholder="Descripcion"></textarea>
                      </div>
                      <div class="col-md-7 col-12 form-group">
                        <span>Discount: </span><span class="discount-value mr-1">0%</span>
                        <span class="mr-1 tax1">0%</span>
                        <span class="mr-1 tax2">0%</span>
                      </div>
                    </div>
                    <div class="invoice-icon d-flex flex-column justify-content-between border-left p-25">
                      <span class="cursor-pointer" data-repeater-delete>
                        <i class="bx bx-x"></i>
                      </span>
                      <div class="dropdown">
                        <i class="bx bx-cog cursor-pointer dropdown-toggle" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false" role="button"></i>
                        <div class="dropdown-menu p-1">
                          <div class="row">
                            <div class="col-12 form-group">
                              <label for="discount">Discount(%)</label>
                              <input type="number" class="form-control" id="discount" placeholder="0">
                            </div>
                            <div class="col-6 form-group">
                              <label for="Tax1">Tax1</label>
                              <select name="tax1" id="Tax1" class="form-control invoice-tax">
                                <option selected>1%</option>
                                <option>10%</option>
                                <option>18%</option>
                                <option>40%</option>
                              </select>
                            </div>
                            <div class="col-6 form-group">
                              <label for="Tax2">Tax2</label>
                              <select name="tax1" id="Tax2" class="form-control invoice-tax">
                                <option selected>1%</option>
                                <option>10%</option>
                                <option>18%</option>
                                <option>40%</option>
                              </select>
                            </div>
                          </div>
                          <hr>
                          <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary invoice-apply-btn" data-dismiss="modal">
                              <span>Apply</span>
                            </button>
                            <button type="button" class="btn btn-light-primary ml-1" data-dismiss="modal">
                              <span>Cancel</span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                @foreach($cotizacion->items() as $n)
                <div data-repeater-item>
                  <div class="row mb-50">
                    <div class="col-3 col-md-5 invoice-item-title">Item</div>
                    <div class="col-3 col-md-3 invoice-item-title">Costo</div>
                    <div class="col-3 col-md-2 invoice-item-title">Cantidad</div>
                    <div class="col-3 col-md-2 invoice-item-title">Precio</div>
                  </div>
                  <div class="invoice-item d-flex border rounded mb-1">
                    <div class="invoice-item-filed row pt-1 px-1">
                      <div class="col-12 col-md-5 form-group">
                        <input type="text" class="form-control" value="{{ $n->producto->nombre }}" name="producto" placeholder="Item" required>
                      </div>
                      <div class="col-md-3 col-12 form-group">
                        <input type="number" class="form-control txtMonto" name="costo" value="{{ $n->monto }}" min="0" max="99999999999" step="0.01">
                      </div>
                      <div class="col-md-2 col-12 form-group">
                        <input type="number" class="form-control txtCantidad" name="cantidad" value="{{ $n->cantidad }}" min="0" max="99999999999" step="0.01">
                      </div>
                      <div class="col-md-2 col-12 form-group">
                        <strong class="text-primary align-middle txtTotalItem">00.00</strong>
                      </div>
                      <div class="col-md-5 col-12 form-group">
                        <textarea class="form-control invoice-item-desc" name="descripcion" placeholder="Descripcion">{{ $n->descripcion }}</textarea>
                      </div>
                      <div class="col-md-7 col-12 form-group">
                        <span>Discount: </span><span class="discount-value mr-1">0%</span>
                        <span class="mr-1 tax1">0%</span>
                        <span class="mr-1 tax2">0%</span>
                      </div>
                    </div>
                    <div class="invoice-icon d-flex flex-column justify-content-between border-left p-25">
                      <span class="cursor-pointer" data-repeater-delete>
                        <i class="bx bx-x"></i>
                      </span>
                    </div>
                      </div>
                    </div>
                @endforeach
              </div>
              <div class="form-group">
                <div class="col p-0">
                  <button class="btn btn-light-primary btn-sm" data-repeater-create type="button">
                    <i class="bx bx-plus"></i>
                    <span class="invoice-repeat-btn">Agregar Item</span>
                  </button>
                </div>
              </div>
          </div>
          <!-- invoice subtotal -->
          <hr>
          <div class="invoice-subtotal pt-50">
            <div class="row">
              <div class="col-md-5 col-12">
                <div class="form-group">
                  <input type="text" class="form-control" name="terminos" placeholder="Términos de Pago" value="{{ $cotizacion->terminos }}">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="notas" placeholder="Notas para el Cliente" value="{{ $cotizacion->notas }}">
                </div>
              </div>
              <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                    <span class="invoice-subtotal-title">Subtotal</span>
                    <h6 class="invoice-subtotal-value mb-0 txtEndSubTotal">00.00</h6>
                  </li>
                  <!--<li class="list-group-item d-flex justify-content-between border-0 pb-0">
                    <span class="invoice-subtotal-title">Discount</span>
                    <h6 class="invoice-subtotal-value mb-0 txtEndDiscount">- 00.00</h6>
                  </li>-->
                  <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                    <span class="invoice-subtotal-title">I.G.V</span>
                    <h6 class="invoice-subtotal-value mb-0 txtEndIGV">00.00</h6>
                  </li>
                  <li class="list-group-item py-0 border-0 mt-25">
                    <hr>
                  </li>
                  <li class="list-group-item d-flex justify-content-between border-0 py-0">
                    <span class="invoice-subtotal-title">Total</span>
                    <h6 class="invoice-subtotal-value mb-0 txtEndTotal">00.00</h6>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- invoice action  -->
  <div class="col-xl-3 col-md-4 col-12">
    <div class="card invoice-action-wrapper shadow-none border">
      <div class="card-body">
        <div class="invoice-action-btn mb-1">
          <button class="btn btn-primary btn-block" id="btnGuardar">
            <i class='bx bx-save'></i>
            <span>Guardar Cotización</span>
          </button>
        </div>
        @if(!empty($cotizacion->oportunidad()->empresa_id))
        <div class="invoice-action-btn mb-1">
          <button class="btn btn-success btn-block" id="btnDescargar">
            <i class='bx bx-download'></i>
            <span>Descargar Cotización</span>
          </button>
        </div>
        <div class="invoice-action-btn mb-1">
          <button class="btn btn-primary btn-block" id="btnRepositorio">
            <i class='bx bx-file'></i>
            <span>Guardar en el repositorio</span>
          </button>
        </div>
        @if(!empty($cotizacion->oportunidad()->correo_id))
        <div class="invoice-action-btn mb-1">
          <button class="btn btn-success btn-block" id="btnResponder">
            <i class="bx bx-send"></i>
            <span>Responder Cotización</span>
          </button>
          <div class="text-center" style="font-size:11px;">a {{ $cotizacion->oportunidad()->correo()->correo_desde }}</div>
        </div>
        @endif
        @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{ asset('js/Bucket.js') }}"></script>
<script>
$("#btnGuardar").on('click', function(e) {
  Fetchx({
    title: 'Guardando',
    type: 'post',
    headers: {
      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    data: $("form.invoice-item-repeater").serialize(),
    success: function(res) {

    }
  });  
});
$("#btnDescargar").on('click', function() {
  var link = document.createElement('a');
  link.href = '/cotizaciones/{{ $cotizacion->id }}/exportar';
  link.download = '{{ $cotizacion->codigo() }}.pdf';
  link.dispatchEvent(new MouseEvent('click'));
});
$("#btnRepositorio").on('click', function(e) {
  Fetchx({
    title: 'Exportando',
    url: '/cotizaciones/{{ $cotizacion->id }}/exportar_repositorio',
    type: 'POST',
    headers: {
      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    data: $("form.invoice-item-repeater").serialize(),
    success: function(res) {

    }
  });
});
function CalcularPrecios() {
  var subtotal = 0;
  let rows = $("[data-repeater-item]");
  rows.each(function() {
    let box = $(this);
    var aaa = parseFloat(box.find('.txtMonto').val());
    aaa = isNaN(aaa) ? 0 : aaa;
    var bbb = parseFloat(box.find('.txtCantidad').val());
    bbb = isNaN(bbb) ? 0 : bbb;
    let sub = aaa * bbb;
    box.find('.txtTotalItem').text(sub.toFixed(2));
    subtotal += sub;
  });
  $('.txtEndSubTotal').text(subtotal.toFixed(2));
  $('.txtEndIGV').text((subtotal * 0.18).toFixed(2));
  $('.txtEndTotal').text((subtotal * 1.18).toFixed(2));

}
$(".invoice-item-repeater").change(CalcularPrecios);
CalcularPrecios();
</script>
@endsection
