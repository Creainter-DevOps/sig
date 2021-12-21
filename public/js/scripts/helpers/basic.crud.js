
function deleteItem(url){
  fetch(url).
    then( response => response.json() ).
    then( data => {
        console.log( data );
        if(data.status){
          toastSuccess();
        }else{
          toastError();
        }
    })
}

document.querySelector(".form-data").addEventListener('submit', (e) => {
  e.preventDefault();
  let form = e.target;
  let action = form.action
  let formData = new FormData(form);
  
  fetch( action, {
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                      .getAttribute("content")
    },
    method: "post",
    body:formData
  }).then(response => response.json())
  .then(data => {
    if(data.status){
      toastSuccess();
      window.location =  data.redirect;
    }else {
      toastInfo(data.message);
    }
  }) 
}) 

/*document.querySelector(".btnDelete").addEventListener( 'click', (e) => {
  e.preventDefault();
  let url = event.target.href;
})*/ 

