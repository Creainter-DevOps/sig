function eliminar(e){
  console.log(e.target);   
  window.event.preventDefault();  
  dialogDelete( 'Desea Eliminar este registro',e.target.href);
}

$(document).ready(function() {
  'use strict';
   // table extended success
})

let search = document.getElementById('search-table');
let table = document.getElementById('table-extended-success');
