var detalle = {}
var oportunidad = [];
const fragment = document.createDocumentFragment();
const templateRow = document.getElementById('template').content;
function addProduct(p = {} ,index ){
   console.log(p)
  var count = Object.keys(detalle).length;
   console.log(count);
   if( typeof count != 'undefined' ){
      index = count 
   }else if ( typeof index == 'undefined' ) { 
      index = 0
   }
  const producto = {
    id: p.id || '' ,
    cotizacion_id : p.cotizacion_id || oportunidad.cotizacion.id, 
    producto_id: p.producto_id || 0,
    cantidad:  p.cantidad || 0,
    monto: ( p.monto /  p.cantidad  ) || 0,
    nombre:  p.producto != null ? p.producto.nombre : ''  ,
    eliminado: false ,
    parametros : p.parametros || ''       
  }
  detalle[ index ] = { ...producto }
  console.log(p.id);  
  templateRow.querySelector('.precio').value = producto.monto
  templateRow.querySelector('.cantidad').value = producto .cantidad
  templateRow.querySelector(".producto").setAttribute("value",producto.producto_id) ;
  templateRow.querySelector(".producto").setAttribute("data-value",producto.nombre) 
  const clone = templateRow.cloneNode( true );
  fragment.appendChild( clone );
  productos.appendChild( fragment );
  var eProducto = document.querySelector( `#productos tr:nth-child(${index + 1 }) .producto`);
  var edv = document.querySelector( `#productos tr:nth-child(${index + 1 }) .precio`);
  var event = new Event('keyup');
  var change = new Event('change');
  edv.dispatchEvent(event);
  eProducto.dispatchEvent(change);
  render_autocomplete();
  console.log(detalle);
}
$('#modalCotizacionDetalle').on('hidden.bs.modal', function (e) {
  console.log()
  detalle = {}
  oportunidad = [];
})

class Menu {
    constructor(elem) {
      this._elem = elem;
      elem.onclick = this.onClick.bind(this); // (*)
    }

    removeElement(a) {
      var tr = a.closest('tr')
      var indextr = [...tr.parentElement.children].indexOf(tr);
      if(detalle[indextr].id != 0){
        tr.style.display = 'none';
        detalle[indextr].eliminado = true;
      }else if( Object.keys(detalle).length > 0 ){
        var temp = {}
        var c = 0;   
        Object.keys(detalle).forEach(( index, obj) =>{
          if( index !=  indextr ){
            temp[c] = detalle[obj];
            c++;
          }
        }) 
        console.log('temps: ' , temp)
        detalle = temp;
        this._elem.removeChild( tr )
      }
    }

    onClick(event) {
    let action = event.target.closest('a').dataset.action;
      if (action) {
        this[action](event.target);
        changePrecio(event.target)
      }
    }
    onKeyup(event){
      console.log(event.target);
    }
  }

new Menu(productos);

function changePrecio(e){
  var tr = e.closest('tr')
  var index = [...tr.parentElement.children].indexOf(tr);
  let precio = tr.querySelector('.precio')
  let cantidad = tr.querySelector('.cantidad')
  let subtotal = tr.querySelector('.subtotal')

  subtotal.textContent = cantidad.value * precio.value
  detalle[index].monto = parseFloat( precio.value ) * parseInt( cantidad.value )   
  detalle[index].cantidad = cantidad.value  
  
  totalDetalle();
}

function totalDetalle(){
  const nTotal = Object.values(detalle).reduce((acc, {eliminado, monto, cantidad }) => {
  if ( eliminado == true ) {
    return acc + parseInt(0)
  } else {
    return acc + parseFloat( monto )
  }  
}, 0);
  oportunidad.cotizacion.monto = nTotal
  document.querySelector('.c-subtotal').textContent = 'S/. ' + nTotal
  document.querySelector('.c-total').textContent = 'S/. ' + nTotal
  console.log(oportunidad);
}

$('imput[name="producto_id"]').each( function() {
  $(this).change(function(){
    console.log('producto_id',   $(this).val());
  })  
})
function saveDetalle(){
  oportunidad.detalle = detalle;
  fetch(`/cotizaciones/${ oportunidad.cotizacion.id }/detalle`,
          {
            headers : {
             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
               'Content-Type': 'application/json'
            },
            method:'post', 
            body : JSON.stringify(oportunidad),
          }
        )
        .then( response => response.json() )
        .then( data => {
          //console.log(data);
          $('#modalCotizacionDetalle').modal('hide');
          toastSuccess('Se registro el detalle de la cotizacion')
        })
}

function verDetalle(e) {
  var id = e.dataset.id;
  productos.innerHTML = '';
  fetch(`/cotizaciones/${id}/detalle`)
    .then(response => response.json())
    .then(data =>{
      oportunidad = data; 
      //console.log( data );
      infoDetalle( data.cotizacion );
        data.detalle.forEach(( ele ,index ) => {
        addProduct( ele,index );  
    })
  })
}

function infoDetalle(cotizacion){
  var modal = document.getElementById('modalCotizacionDetalle');
  modal.querySelector('[name="fecha"]').value = cotizacion.fecha 
  modal.querySelector('[name="validez"]').value = cotizacion.validez
  modal.querySelector('h4').textContent  = cotizacion.rotulo
  modal.querySelector('h5').textContent  = 'Cotizacion #' +  cotizacion.id
}

