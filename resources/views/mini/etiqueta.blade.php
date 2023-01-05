@extends('mini.theme')
@section('title', 'Etiquetas') 
@section('page-styles')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" type="text/css" href="/css/themes/layout.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/sip.css')}}">
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
.task-list { 
  background-color: #272822;
  //min-height: 400px;
  margin:0;
  overflow: hidden;
  list-style:none;
  padding : 0;
  //height:100vh;
}

/* Individual Task */
.task { 
  width: 100%;
  height: auto;
  
  //min-height: 100vh;
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

.task:before { content: "\2714"; left: -40px; }

.task:after { content: "\2718"; right: -40px; }

.task:not(.completed):not(.completing) {
  border-bottom: 2px solid #d44a29;
}

.stats{
  bottom: 0px;
  background: antiquewhite;
padding: 10px;
 }

.task.completing { text-decoration: line-through; background-color: green; }

.task.completed { 
  opacity: 0.5;
  background-color: #323232; }

.task.completed:before { content: ""; }

.task.deleting { background-color: #323232; }

[data-tipo="1"],[data-tipo="1"]:before {
  background-color: #39DA8A;  
}
[data-tipo="1"]:before {
  content : "A favor"
}

[data-tipo="2"]{
  background-color: #FF5B5C;
}

[data-tipo="2"]:before {
  content : "En contra"
}
[data-tipo="0"] {
  background-color: #fd541b;
}


[data-tipo="0"]:before{
  content : "sin tipo"  
}

</style>
@endsection
@section('content')
<section class="clear">
			<ul class="task-list">
			</ul>
</section>
  <div class="stats" style="position:fixed ; left:0; right:0; width:100%; display:flex;justify-content:space-between;" > 
    <button class="btn btn-danger cant_aprobadas"> 0 </button>
    <div class="navegacion btn btn-secondary " style="display:flex; align-items: center;  " >
    15
    </div>
    <button class="btn btn-success cant_rechazadas "> 0 </button>
  </div>
<br>
  
<template id="template-licitacion" >
<li class="task card"style="margin-bottom:0;" >
<!--    <div class="card-header block-header-default">
       <h3 class="block-title">Nuevo cliente</h3
    </div>-->
    <div class="card-content card-container">
       <div class="card-body" style="padding:0;" >
       <!-- <a class="mr-1" href="#">
          <img src="/images/portrait/small/avatar-s-26.jpg" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
</a>-->
        <span class="badge ">  </span>
        <div class="content-swipe" data-url_aprobar=""  data-url_desaprobar="" data-id="" data-tipo="">
          <div class="media-body" style="text-aling:center;">
            <h3 class="media-heading nombre"></h3>
            <h6 class="text-muted font-medium-1 empresa"> <i class="bx bx-buildings " ></i>  </h6>  
            <h6 class="solicitado"> Solicitada por:</h6>
            <span class="solicitado_el"></span>
            <table>
              <tr>
                <th style="width:30%" >Repetidas: </th>
                <td style="width:70%" ><div class="editable-monto-view" data-editable="" data-name="monto_base"> </div></td>
              </tr>
            </table>
      </div>
    </div>
</div>
</li>
</template>
@endsection

@section('page-scripts')
<script src="/vendors/js/vendors.min.js"></script>
<script src="/js/scripts/typeahead.js"></script>
<script src="/assets/js/scripts.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
<script>

  var etiquetas = [] ;
  var cnt_aprobada = 0;
  var cnt_rechazadas = 0;
  var index_licitacion = 1; 
  var indexValue = 1;
  let containersCards = document.querySelector('.task-list');
  let template = document.getElementById('template-licitacion');

  let rechazadas = document.querySelector(".cant_rechazadas");
  let aprobadas = document.querySelector(".cant_aprobadas");
  let num_etiquetas = document.querySelector(".navegacion");

  function cargar_etiquetas(){
    var url = window.location;
    url  = url + "?ids=" + Object.keys(etiquetas) ;

    fetch(url, {
      headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                  'X-Requested-With': 'XMLHttpRequest'
                }
                
    }).then(response => response.json())
      .then( data => {

          data.data.forEach( (item ) => {
            addCard(item)  
            etiquetas[item.id] = item;
          })
          if( Object.keys( etiquetas).length > 0 ){
            footer();
            iniciar();
          }
        }) 
  }

  cargar_etiquetas();

  function tipo(elem){
    console.log(elem)
    if(elem.dataset.tipo == "0" ){
      elem.dataset.tipo = "1"  
    } else if(elem.dataset.tipo == "1" ){
      elem.dataset.tipo = "2"
    } else if(elem.dataset.tipo == "2" ){
      elem.dataset.tipo = "1"
    }
  }

  function footer(){
    num_etiquetas.textContent = containersCards.children.length;  
    rechazadas.textContent = cnt_rechazadas;
    aprobadas.textContent = cnt_aprobada;
  }
  function addCard(item){
    let clone = template.content.cloneNode(true);
    console.log(clone)
    let badge = clone.querySelector(".badge");
    badge.dataset.tipo = (item.tipo == null) ? "": item.tipo 

    clone.querySelector('.nombre').textContent = item.nombre 
    clone.querySelector('li').dataset.url_aprobar = `/etiquetas/${item.id}/aprobar`;
    clone.querySelector('li').dataset.id = item.id;
   if( typeof item.razon_social != 'undefined' && item.razon_social != null   ){
      clone.querySelector('.empresa').append(document.createTextNode(item.razon_social)) 
   } 
   /*else {
      let input = document.createElement("input");
      input.type = "text";
      input.placeholder ="empresa" 
      input.name = "empresa_id"
      input.classList.add("form-control","autocomplete");
      input.dataset.ajax = "/empresas/autocomplete?propias=1"
      clone.querySelector('.empresa').append(input);
   }*/
    clone.querySelector('.solicitado').textContent = typeof item.solicitada_por != 'undefined' ? item.solicitada_por.toUpperCase() : '';
    clone.querySelector('li').dataset.url_desaprobar = `/etiquetas/${item.id}/rechazar`;
    clone.querySelector('.solicitado_el').textContent = typeof item.solicitado_el != 'undefined' ? new Date( item.solicitado_el).toLocaleString() : '';
    clone.querySelector('.editable-monto-view').textContent = item.repetidas;
    containersCards.append(clone) 
  }  

  function swipe( url, motivo = null,parameters ){
    let data = {
        method : 'get',   
        headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'X-Requested-With': 'XMLHttpRequest'
        }
      };

    if(parameters){
      url = url + '?' + new URLSearchParams(parameters).toString() 
    }

    fetch( url, data )
      .then(response => response.json() )
      .then(data => {
         console.log(data);
         console.log(etiquetas.keys())
         console.log( etiquetas );
         if( containersCards.childElementCount <= 10 ){
            cargar_etiquetas()
         }
         if( motivo == 'aprobar' ){
           toast('success', "Etiqueta aprobada",900 )
         } else {
           toast('warning', "Etiqueta rechazada",900 )    
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
  render_autocomplete(); 
  document.addEventListener('mouseup', endSwipe);
  document.addEventListener('touchend', endSwipe,false );
  document.addEventListener('mousemove', detectMouse);
  document.addEventListener('touchmove', detectMouse,false );
  
  document.addEventListener('swiped-left', function(e) {
    console.log(e.target); // the element that was swiped
  })    
  //STARTSWIPE
  function startSwipe(evt){ 
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
    console.log(etiquetas); 
    if( currentTask.classList.contains("completing") ){
      currentTask.classList.remove("completing");

      swipe(currentTask.dataset.url_aprobar, 'aprobar' )
      cnt_rechazadas++;

      delete etiquetas[currentTask.dataset.id];
      currentTask.remove();      
      footer();
    }
    else if( currentTask.classList.contains("deleting") ){
      swipe(currentTask.dataset.url_desaprobar)
      cnt_aprobada++;
      delete etiquetas[ currentTask.dataset.id ]; 
      currentTask.remove();      
      footer();
    }      

    //console.log(etiquetas) 
    mouseOrigin = null;
    isSwiping = false;     
    currentTask.style.margin = 0;
    currentTask = null;
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
