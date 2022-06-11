const ToastBasic = Swal.mixin({
  toast: true,
  position: 'top',
  showConfirmButton: false,
  timerProgressBar: true,
})

const dialogBasic = Swal.mixin  ({
    toast: true,
    position: 'top',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
})

function toastSuccess( message = 'Operacion Realizada correctamente', timer = 2000  ){
    ToastBasic.fire( {
      timer: timer,
      icon : 'success',
      title : message,
    });
}
function toastInfo(message ='' , timer = 2000 ){
    ToastBasic.fire( {
      timer: timer,
      icon : 'info',
      title : message,
    });
}
function toastSuccessResponse(redirect = null, message = "Operacion Realizada correctamente",  timer = 1000){ 
ToastBasic.fire( {
      timer: timer,
      icon : 'success',
      title : message,
      didClose :(event) => {
       if(redirect != null ){
         redirect_to(redirect);
         return
       }
      }
    });
}

function redirect_to(url){
  window.location = url;
}

function toastError (message = 'Error... Algo sucedio', timer = 3000 ){
  ToastBasic.fire({
    timer : timer,
    icon: 'error',
    title : message
  });
}

function dialogDelete( message = ' Desea eliminar este registro' ){
  return dialogBasic.fire({
    title: message,
    icon: 'warning',
  })
}


