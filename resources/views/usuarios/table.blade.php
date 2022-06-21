<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head">
      @if(!empty($cliente->id)) 
      <a class="link-primary" href=" {{ route('clientes.show', [ 'cliente' => $cliente->id  ]) }}"
       target="_blank" >CLIENTE
      </a>
      @else 
        CLIENTE
      @endif
    </th>
  </tr>
<tbody>
  @if (!empty($cliente))
  <tr>
      <th>Ruc</th>
      <td>{{ $cliente->empresa()->ruc }}</td>
      <th>Cliente</th>
      <td>{{ $cliente->empresa()->razon_social }}</td>
  </tr>
  <tr>
      <th>Seudonimo</th>
      <td>{{ $cliente->empresa()->seudonimo }}</td>
      <th>Alias</th>
      <td>{{ $cliente->nomenclatura }}</td>
  </tr>
  <tr>
      <th>Dirección</th>
      <td colspan="3">{{ $cliente->empresa()->direccion }}</td>
  </tr>
  @else
  <tr> 
    <td class="text-center" > Sin Informacion de cliente </td>
  </tr>
  @endif
</tbody>
</table>
@if(!empty($contactos))
<div>
@include('clientes.contactos', compact('cliente'))
</div>
@endif
