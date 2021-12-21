
let form = document.getElementById('form-data');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  let id = document.getElementById('id').value;
  let data = new FormData(form);
  let action = form.action
  fetch( action  , {
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    method: "post",
    body:data
  }).then(response => response.json())
  .then(data => {
    if(data.status){
      toastSuccess();
      window.location =  data.redirect;
    }
  })
})

