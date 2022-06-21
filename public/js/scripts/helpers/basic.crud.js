function deleteItem(url){
  fetch(url,{
    method : 'DELETE',
    headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    }
    }).
    then( response => response.json() ).
    then( data => {
        console.log( data );
        if(data.status){
          toastSuccess( data.refresh || false);
        }else{
          toastError();
        }
    })
}

var forms =  document.querySelectorAll(".form-data")
forms.forEach((element) =>{   
  element.addEventListener('submit', (e) => {
  console.log('event', e);
  e.preventDefault();
  let form = e.target;
  let action = form.action;
  let md = form.getAttribute('method');
  let formData = new FormData(form);
  
  fetch( action, {
    headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    method: md,
    body:formData
  }).then(response => response.json())
  .then(data => {
    if(data.status && typeof data.redirect != 'undefined'){
      toastSuccessResponse(data.redirect);
      form.reset();
    } else if(data.refresh){
      location.reload()
    } else if( data.status){
      toastSuccess();
      form.reset();
      if(typeof actionResponse === "function" ){
        actionResponse(data.object);
      }
    } else {
      toastInfo(data.message);
    }
  }) 
  })
})  

function requestForm(evm , actionResponse = 'actionResponse' ){
  
}

/*document.querySelector(".btnDelete").addEventListener( 'click', (e) => {
  e.preventDefault();
  let url = event.target.href;
})*/ 

