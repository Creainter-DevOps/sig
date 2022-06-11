<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
  <tr>
    <th colspan="4" class="table-head">
      @if(!empty($empresa->id)) 
      <a class="link-primary" 
       target="_blank" >Proveedor
      </a>
      @else 
        CLIENTE
      @endif
    </th>
  </tr>
<tbody>
  @if (!empty($empresa))
  <tr>
      <th>Ruc</th>
      <td>{{ $empresa->ruc }}</td>
      <th>Cliente</th>
      <td>{{ $empresa->razon_social }}</td>
  </tr>
  <tr>
      <th>Seudonimo</th>
      <td>{{ $empresa->seudonimo }}</td>
      <th>Alias</th>
      <td>{{ $empresa->nomenclatura }}</td>
  </tr>
  <tr>
      <th>Dirección</th>
      <td colspan="3">{{ $empresa->direccion }}</td>
  </tr>
  <tr>
      <th>Cuentas Bancarias</th>
      <td colspan="3">{{ $proveedor->cuentas_bancarias }}</td>
  </tr>
  <tr>
      <th>observaciones</th>
      <td colspan="3">{{ $proveedor->observaciones}}</td>
  </tr>
  @else
  <tr> 
    <td class="text-center"> Sin Informacion de Proveedor </td>
  </tr>
  @endif
</tbody>
</table>
@if(!empty($contactos))
<div>
@include('clientes.contactos', compact('cliente'))
</div>
@endif
