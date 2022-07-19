@extends('mini.theme')
@section('title', 'Oportunidades') 
@section('page-styles')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/sip.css')}}">
<link rel="stylesheet" type="text/css" href="https://sig.creainter.com.pe/css/themes/layout.css">
<link rel="stylesheet" type="text/css" href="https://sig.creainter.com.pe/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="https://sig.creainter.com.pe/css/Bucket.css">
<script src="https://sig.creainter.com.pe/js/Bucket.js"></script>
<style>
  body {
    margin:0;
  }

.list-header { display: flex; align-items: center; background-color: #e0dee0; border-top-left-radius: 5px; border-top-right-radius: 5px; padding: 10px 20px; }

.list-header div { width: 20%; }

.list-header .circles div { height: 15px; width: 15px; border-radius: 50%; display: inline-block; margin-right: 5px; }

.list-header .circles div:nth-child(1) { background-color: #fc615d; }

.list-header .circles div:nth-child(2) { background-color: #fec342; }

.list-header .circles div:nth-child(3) { background-color: #34c749; }

.list-header .menu { display: flex; align-items: flex-end; flex-direction: column; }

.list-header .menu div { width: 25px; height: 3px; background-color: #a9a9a9; border-radius: 3px; }

.list-header .menu div:nth-child(2) { margin: 4px 0; }

.list-header h1 { width: 60%; text-align: center; }

/* Task List */
.task-list { background-color: #272822; min-height: 400px;
  margin:0;
  overflow: hidden;
  list-style:none;
  padding : 0;
  height:100vh;
}

/* Individual Task */
.task { 
  width: 100%;
  height: auto;
  
  min-height: 100vh;
  line-height: 2;
  position: relative;
  padding: 8px 20px;
  height: auto;
  transition: background-color 1s; 

  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
}

.task:before, .task:after { position: absolute; top: 0; width: 40px; height: 50px; line-height: 50px; text-align: center; }

.task:before { 
  content: "\2714"; 
  left: -40px; 
}

.task:after {
  content: "\2718"; right: -40px; 
}

.task:not(.completed):not(.completing) { 
  border-bottom: 2px solid #d44a29; 
}
.stats{
background: antiquewhite;
padding: 10px;
bottom:0;
}
.task.completing { 
  text-decoration: line-through;
  background-color: green; 
}

.task.completed { 
  opacity: 0.5;
  background-color: #323232;
}

.task.completed:before { 
  content: "";
}

.task.deleting { 
  background-color: #323232;
}
.table thead th{
  font-size: 0.5rem;  
}
</style>
@endsection
@section('content')
<section class="clear">
			<ul class="task-list">
			</ul>
</section>
  <div class="stats" style="position:fixed ; left:0; right:0;width:100%; display:flex;justify-content:space-between; " > 
    <button class="btn btn-danger cant_rechazadas"> 0 </button>
    <div class="navegacion" style="display:flex; align-items: center;  " >
      <i class='bx bx-chevron-left' style="font-size:40px;color:var(--blue)" onclick="side_slide(-1)" ></i>
      <span class="num_oportunidad"> 1 de 15 </span>
      <i class='bx bx-chevron-right'style=" font-size:40px;color:var(--blue)" onclick="side_slide(1)" ></i>
    </div>
    <button class="btn btn-success cant_aprobadas"> 0 </button>
  </div>
  
<template id="template-oportunidad" >
<li class="task card" style="display:none;">
<!--    <div class="card-header block-header-default">
       <h3 class="block-title">Nuevo cliente</h3
    </div>-->
    <div class="card-content card-container"  >
       <div class="card-body" style="padding:0; " >
       <!-- <a class="mr-1" href="#">
          <img src="https://sig.creainter.com.pe/images/portrait/small/avatar-s-26.jpg" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>-->
        <div class="content-swipe" data-url_aprobar=""  data-url_desaprobar="" data-id="" data-tipo="">
          <div class="media-body" style="height:100vh;" >
            <span class="badge badge-primary correo" style="display:none"   >Correo</span>  
            <span class="badge badge-info oportunidad"  style="display:none" >Licitacion</span>  
            <h4 class="media-heading"></h4>
            <div class="empresa">
              <h6 class="users-view-username text-muted font-medium-1 "> <i class="bx bx-buildings " ></i>  </h6>  
            </div>
            <h6 class="oportunidad-id" >ID:</h6>
            <span class="users-view-id"></span>
            <table>
              <tr>
                <th style="width:30%" >Monto Base:</th>
                <td style="width:70%" ><div class="editable-monto-view" data-editable="" data-name="monto_base"> </div></td>
              </tr>
            </table>

            <div class="embed" style="width: 100%;">
              <div id="" data-path="OPORTUNIDADES/D-2022-07-0040/" data-upload="false" data-oid="201651"></div>
            </div>
            </div>
        </div>
      </div>
</div>
</li>
</template>
@endsection

@section('page-scripts')

<script src="https://sig.creainter.com.pe/vendors/js/vendors.min.js"></script>
<script src="https://sig.creainter.com.pe/js/scripts/typeahead.js"></script>
<script src="https://sig.creainter.com.pe/assets/js/scripts.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
<script src="https://sig.creainter.com.pe/vendors/js/extensions/toastr.min.js"></script>
<script>

  var oportunidades = [] ;
  var cnt_aprobada = 0;
  var cnt_rechazadas = 0;
  var index_oportunidad = 1; 
  var indexValue = 1;
  let containersCards = document.querySelector('.task-list');
  let template = document.getElementById('template-oportunidad');

  let rechazadas = document.querySelector(".cant_rechazadas");
  let aprobadas = document.querySelector(".cant_aprobadas");
  let num_oportunidad = document.querySelector(".num_oportunidad");
  let bucketjs = new Bucketjs();
  function money( monto, moneda =1 ){
    if( moneda == 2 ){
      return (new Intl.NumberFormat('us-US',{ style: 'currency', currency: 'USD' }).format(monto))
    }
    return (new Intl.NumberFormat('es-PE',{ style: 'currency', currency: 'PEN' }).format(monto))
  }
  function n_oportunidad(num,total ){
    return `${num} de ${total}`;
  }
  function mover( op ){
    //console.log(op);

    let card = containersCards.querySelector('li[style*="display: block;"]'); 
    //console.log(card);
    if(op=='siguiente'){
      if ( null !== card.nextElementSibling){
        //console.log(card.nextSibling)
        card.nextElementSibling.style.display = 'block';
        //bucketjs.capture(card.nextElementSibling.querySelector(".embed > div ")); 
        card.style.display = 'none';
        index_oportunidad++;
        num_oportunidad.textContent = n_oportunidad(  index_oportunidad,Object.keys(oportunidades).length ) ;
        if(card.nextElementSibling.querySelector(" .embed > div").dataset.bucket != "1" ){
          bucketjs.capture(card.nextElementSibling.querySelector(".embed > div ")); 
          card.nextElementSibling.querySelector(".embed > div ").dataset.bucket = "1";
        }
      }
    } else if (op == 'anterior'){
      if(null !== card.previousElementSibling ){
        //console.log(card.previousElementSibling)
        card.style.display = 'none';
        card.previousElementSibling.style.display = 'block';
        //bucketjs.capture(card.previousElementSibling.querySelector(".embed > div ")); 
        index_oportunidad--;
        num_oportunidad.textContent =n_oportunidad(  index_oportunidad, Object.keys(oportunidades).length ) ;
        if(card.previousElementSibling.querySelector(".embed > div").dataset.bucket != "1" ){
          bucketjs.capture(view.previousElementSibling.querySelector(".embed > div ")); 
          card.previousElementSibling.querySelector(".embed > div ").dataset.bucket = "1";
        }
      }
    }   

  }

  function cargar_oportunidades(){

    var url = window.location;
    url  = url + "?ids=" + Object.keys(oportunidades) ;

  fetch( url ,{
    headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                'X-Requested-With': 'XMLHttpRequest'
              }
              
  }).then(response => response.json())
    .then( data => {
        console.log(data);


        data.data.forEach( (item ) => {
            addCard(item)  
            oportunidades[item.id] = item;
        })

        showOportunidad(indexValue);
        footer();
        iniciar();
      }) 
  }

  cargar_oportunidades();


  function btm_slide(e){
    showOportunidad(indexValue = e);
  }
  function side_slide(e){
    showOportunidad(indexValue += e);
  }
  function showOportunidad(e){
    var i;
    const listCards = document.querySelectorAll('.task-list .task');
    //const slider = document.querySelectorAll('.btm-slides span');
    if( e > listCards.length){
       indexValue = 1
    }
    if(e < 1){
      indexValue = listCards.length
    }
    for(i = 0; i < listCards.length; i++){
      listCards[i].style.display = "none";
    }
    /*for(i = 0; i < slider.length; i++){
      slider[i].style.background = "rgba(255,255,255,0.1)";
    }*/
    listCards[indexValue-1].style.display = "block";
    bucket_capture(listCards[indexValue-1]);

    num_oportunidad.textContent = `${indexValue} de ${listCards.length}`  
    rechazadas.textContent = cnt_rechazadas;
    aprobadas.textContent = cnt_aprobada;
  }
  function bucket_capture(view){
    if( typeof view.querySelector(" .embed > div").dataset.bucket == 'undefined' && view.querySelector(".embed > div").dataset.bucket != "1" ){
      bucketjs.capture(view.querySelector(".embed > div ")); 
      view.querySelector(".embed > div ").dataset.bucket = "1";
    }
  }

  function addCard(item){
    let clone = template.content.cloneNode(true);
    console.log(clone)
    if(item.correo_id != null  ){
       clone.querySelector(".correo").style.display = 'block';  
    }else{
       clone.querySelector(".oportunidad").style.display = 'block';  
    }

    if(item.entidad == null ){ 
      let input = document.createElement("input");
      input.type = "text";
      input.placeholder ="empresa" 
      input.name = "empresa_id"
      input.classList.add("form-control","autocomplete");
      input.dataset.ajax = "/empresas/autocomplete"
      input.onchange = function (e){
        //editar();
        console.log(e.target.closest(".empresa").querySelector("input[name='empresa_id']"));
        editar_empresa(item.id, e.target.closest(".empresa").querySelector("input[name='empresa_id']").value )
      }
      //input.setAttribute('data-editable',  `/oportunidades/${item.id}?_update=empresa_id`) ;
      clone.querySelector('.empresa').append(input);
   }
   else{
      clone.querySelector('.users-view-username').append(document.createTextNode(item.entidad )) 
   }
    clone.querySelector('.media-heading').textContent =  item.rotulo.toUpperCase() 
    clone.querySelector('li').dataset.url_aprobar = `/oportunidades/${item.id}/aprobar`;
    clone.querySelector('li').dataset.id = item.id;
    clone.querySelector('.oportunidad-id').textContent = item.nomenclatura ;
    clone.querySelector('li').dataset.url_desaprobar = `/oportunidades/${item.id}/rechazar`;
    clone.querySelector('.editable-monto-view').setAttribute('data-editable',  `/oportunidades/${item.id}?_update=monto_base`) ;
    clone.querySelector('.editable-monto-view').textContent = money( item.monto, item.moneda );

    clone.querySelector('.embed div').id = item.id;
    clone.querySelector('.embed div').dataset.oid = item.id;
    clone.querySelector('.embed div').dataset.path = `OPORTUNIDADES/${item.nomenclatura}/`;
    containersCards.append(clone) 
  }  
  function editar_empresa(id_oportunidad, id_empresa ){
    let formdata = new FormData();
    formdata.append('value', id_empresa);
    console.log("Empresa",  id_empresa)
    let url = `/oportunidades/${id_oportunidad}?_update=empresa_id`
    fetch (url,{
        method: 'put',
        headers : { 
           'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({value:id_empresa }) 
     }
    ).then( response => response.json() )
     .then( data => {
       console.log(data);
       toastSuccess(); 
     })
  }
  function footer(){
    /*let nodes = Array.prototype.slice.call(containersCards.children);
    let card = containersCards.querySelector('li[style*="display: block;"]'); 
    let num = nodes.indexOf(card);
    let total = nodes.length
    num_oportunidad.textContent = `${num} de ${total}`  
    rechazadas.textContent = cnt_rechazadas;
    aprobadas.textContent = cnt_aprobada;*/
  }
  function swipe( url, motivo = null ){

    let data = {
        method : motivo ?'post': 'get',   
        headers : { 
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'X-Requested-With': 'XMLHttpRequest'
        }
    };
    if ( motivo != null ) {
      let formdata = new FormData();
      formdata.append( 'value', motivo );
      data.body = formdata;  
    }    

    fetch( url, data )
      .then(response => response.json() )
      .then(data => {
         console.log(data);
         console.log( oportunidades );
         if( containersCards.childElementCount <= 10 ){
            cargar_oportunidades()
         }
         if( motivo == null ){
           toast('success', "oportunidad aprobada",900 )
         } else {
           toast('warning', "oportunidad rechazada",900 )    
         }
      })

     if( motivo == null ){
       toast('success', "oportunidad aprobada",900 )
     } else {
       toast('warning', "oportunidad rechazada",900 )    
     }
    }
        
async function dialog_rechazar(currentTask ) {

  return Swal.fire({
    title: 'Motivo',
    input: 'textarea',
    inputAttributes: {
      autocapitalize: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Aceptar',
    showLoaderOnConfirm: true,
    preConfirm: (motivo) => {

      let formdata = new FormData();
      formdata.append( 'value', motivo );

      return fetch( currentTask.dataset.url_desaprobar , { method: 'post',
        headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formdata
      })
      .then(response => response.json() )
      .then(data => {
         console.log(data);
         if( containersCards.childElementCount <= 10 ){
            cargar_oportunidades()
         }
          cnt_aprobada++;
          aprobadas.textContent = cnt_aprobada;
         return data;
      })
    }
  })
}     
function iniciar(){
  
  var list = document.getElementsByClassName('task-list')[0];
  var tasks = document.getElementsByClassName('task');
  
  var mouseOrigin;
  var isSwiping = false;
  var mouseRelease;
  var currentTask;
  var swipeMargin=80;
  var originalClassList;
  
  Array.prototype.forEach.call(tasks, function addSwipe(element){
    element.addEventListener('mousedown', startSwipe,false ); 
    element.addEventListener('touchstart', startSwipe);
  });
  
  /* 
    Defined events on document so that a drag or release outside of target 
    could be handled easily 
  */
  document.addEventListener('mouseup', endSwipe);
  document.addEventListener('touchend', endSwipe,false );
  document.addEventListener('mousemove', detectMouse);
  document.addEventListener('touchmove', detectMouse,false );
  
  render_autocomplete(); 
  render_editable()
  //STARTSWIPE
  function startSwipe(evt  ){ 
    console.log("event start")
    mouseOrigin = evt.screenX || evt.touches[0].screenX;
    currentTask = evt.target.closest('li');
    isSwiping = true;
    originalClassList = currentTask.classList.value;
    console.log("event start done", mouseOrigin  )
  }
  
  //ENDSWIPE
  function endSwipe(evt){
    var completedTask;    
    if(typeof currentTask == 'undefined' || currentTask == null  ){
      return
    }
    
    if( currentTask.classList.contains("completing") ){
      currentTask.classList.remove("completing");
      //currentTask.classList.add("completed");
      //list.appendChild(currentTask);
      swipe(currentTask.dataset.url_aprobar)
      cnt_aprobada++;
      currentTask.remove();      
      side_slide(0);

    }
    else if( currentTask.classList.contains("deleting") ){
     rechazar(currentTask);
    }      

    console.log(oportunidades) 
    mouseOrigin = null;
    isSwiping = false;     
    currentTask.style.margin = 0;
    currentTask = null;
  }

  async function rechazar(currentTask){
      
     let response = await dialog_rechazar(currentTask );
     if( response.isConfirmed ) {
          currentTask.remove();     
          cnt_rechazadas++;
          toast('warning', "Oportunidad rechazada",900 )    
          side_slide(0);
     }else{
         currentTask.classList.remove("deleting");
     }
     
  }
  
  //DETECTMOUSE
  function detectMouse(evt){
    var currentMousePosition = evt.screenX || evt.touches[0].screenX;
    var swipeDifference = Math.abs(mouseOrigin - currentMousePosition)
    
    if(isSwiping && currentTask && (swipeDifference > swipeMargin) ){ 
      if( (swipeDifference-swipeMargin) <= swipeMargin ){
        //no change, allows user to take no action
        currentTask.classList.remove("completing");
        currentTask.classList.remove("deleting");
        currentTask.style.margin = 0;
      }
      else if( mouseOrigin > currentMousePosition ){
        //swipe left        
        currentTask.classList.remove("completing");
        currentTask.classList.add("deleting");
        currentTask.style.marginLeft = -swipeDifference+"px";
      }
      else if( (mouseOrigin < currentMousePosition) && !currentTask.classList.contains("completed") ){
        //swip right");
        currentTask.classList.remove("deleting");
        currentTask.classList.add("completing");
        currentTask.style.marginLeft = swipeDifference+"px";
      }
    }
  }  
};
</script>
@endsection
