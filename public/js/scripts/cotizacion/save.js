$(document).ready(function() {
  'use strict';
  $("#validez").pickadate({ hiddenName: true} );
  $("#fecha").pickadate({hiddenName: true } );
});
let form = document.getElementById('form-data'); 
form.addEventListener( 'submit', (e) => {
  e.preventDefault();
  save();
})

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

function save(){
  let formdata = new  FormData(form);
  let action = form.action
  fetch(action, {
   method: 'post',
   body : formdata
  }).then(response => response.json())
  .then(data =>{
    console.log(data); 
    Toast.fire({
      icon: 'success',
      title: 'Operacion Realizada con exito',
      didClose: () => {
        window.location = data.redirect;
      }
    })
  });
}
