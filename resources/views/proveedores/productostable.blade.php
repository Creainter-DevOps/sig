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
            </tr>
          </thead>
          <tbody id="tbodyProducto">
            @foreach($pproductos as $pproducto )
            <tr>
              <td class="text-bold-500"  data-productoid="{{ $pproducto->producto_id }}"  >{{ $pproducto->producto() ? $pproducto->producto()->nombre : 'No encontrado' }}</td>
<td data-value="{{$pproducto->monto}}">{{Helper::money($pproducto->monto ,$pproducto->moneda_id ) }}</td>
              <td data-value="{{ $pproducto->moneda_id }}">{{ Helper::moneda($pproducto->moneda_id)   }}</td>
              <td>{{ $pproducto->plazo_entrega }}</td>
              <td>{{ $pproducto->garantia }}</td>
              <td>{{ $pproducto->parametros }}</td>
            </tr>
            @endforeach 
          </tbody>
      </table>
    </div>
  </div>
</div>
