
$('#exampleModalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var tr = button.parent().parent()
  console.log(tr)
  var pp_id = button.attr('data-id') 
  var producto_id = button.attr('data-productoid') 
  console.log(button)
  console.log(producto_id); 
  var modal = $(this)
  if ( producto_id == 0 ) {
    modal.find('.modal-title').text('Proveedor - Agregar producto')
    modal.find('input[name="id"]').val(0);
    $('input[name="producto_id_rotulo"]').attr('value',''  )
    $('input[name="producto_id"]').attr('value', '')
    $('input[name="producto_id_rotulo"]').attr('data-value', 0 )
    $('input[name="producto_id"]').attr('data-value', '' )
    modal.find('form').trigger("reset");
  } else {
    modal.find('.modal-title').text('Proveedor - Editar producto' )
    modal.find('input[name="id"]').val( pp_id )
    $('input[name="producto_id_rotulo"]').attr('value', tr.find('td:nth-child(1)').text() )
    $('input[name="producto_id"]').attr('value', producto_id)
    $('input[name="producto_id_rotulo"]').attr('data-value',tr.find('td:nth-child(1)').text()   )
    $('input[name="producto_id"]').attr('data-value',tr.find('td:nth-child(1)').text() )
    console.log( producto_id, tr.find('td:nth-child(1)').text()) 
    $('input[name="monto"]').val(tr.find('td:nth-child(2)').data('value'))
    $('input[name="plazo_entrega"]').val(tr.find('td:nth-child(4)').text())
    $('input[name="garantia"]').val(tr.find('td:nth-child(5)').text() )
    $('textarea[name="parametros"]').val(tr.find('td:nth-child(6)').text())
    $('select[name="moneda_id"]').val(tr.find('td:nth-child(3)').data('value'))
    $('select[name="moneda_id"]').attr('data-value',tr.find('td:nth-child(3)').text() )
  }
})

function actionResponse(data){
  console.log(data);
$('#exampleModalCenter').modal('hide')
 let tbody = document.getElementById('tbodyProducto');
 tbody.innerHTML = '';
 data.forEach((item) =>{
 tbody.insertAdjacentHTML('beforeend', `<tr>
        <td class="text-bold-500"  data-productoid="${item.producto_id}" >${ item.producto != null ?  item.product.nombre : 'No encontrado' } </td>
        <td>${item.monto} </td>
        <td>${item.plazo_entrega}</td>
        <td>${item.garantia}</td>
        <td><a href="#"><i data-id="${data.id}" class="badge-circle badge-circle-light-secondary bx bx-envelope font-medium-1"></i></a></td>
      </tr>`)
 }) 
}
