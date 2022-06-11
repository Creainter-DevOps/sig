@extends('layouts.contentLayoutMaster')
@section('title', 'Proveedor - Productos') 
@section('content')
<!-- Button trigger modal -->
<div class="row d-flex justify-content-between "  >
  <h4 class="title">Proveedor : {{ $proveedor->empresa()->razon_social }}</h4>
  <button type="button" data-id="0" data-productoid="0"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
   Agregar producto 
  </button>
</div>
</br>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Proveedor - Agregar producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('proveedor.saveproducto') }}" class="form form-data" method="post">
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    </div>
  </div>
</div>
<h4 class="text-primary">Productos</h4>
<div class="row">
  <div class="card card-body">
    <div class="table-responsive">
      <table class="table">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Monto</th>
              <th>Moneda</th>
              <th>Plazo entrega</th>
              <th>Garantia</th>
              <th>Parametros</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="tbodyProducto">
            @foreach($proveedor->productos()  as  $pproducto )
            <tr>
              <td class="text-bold-500"  data-productoid="{{ $pproducto->producto_id }}"  >{{ $pproducto->producto() ? $pproducto->producto()->nombre : 'No encontrado' }}</td>
<td data-value="{{$pproducto->monto}}">{{Helper::money($pproducto->monto ,$pproducto->moneda_id ) }}</td>
              <td data-value="{{ $pproducto->moneda_id }}">{{ Helper::moneda($pproducto->moneda_id)   }}</td>
              <td>{{ $pproducto->plazo_entrega }}</td>
              <td>{{ $pproducto->garantia }}</td>
              <td>{{ $pproducto->parametros }}</td>
              <td>
                <a data-id="{{ $pproducto->id }}" data-productoid="{{ $pproducto->producto_id }}"   style="cursor:pointer;" data-toggle="modal" data-target="#exampleModalCenter">
                  <i class="badge-circle badge-circle-light-secondary bx bx-pencil font-medium-1"></i>
                </a>
                <a data-id="{{ $pproducto->id }}" style="cursor:pointer;" data-toggle="modal" data-target="#exampleModalCenter">
                  <i class="badge-circle badge-circle-danger bx bx-x font-medium-1"></i>
                </a>
              </td>
            </tr>
            @endforeach 
          </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('page-scripts')
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
  <script src="{{ asset('js/scripts/proveedores/proveedor.producto.js') }}"></script>
@endsection


