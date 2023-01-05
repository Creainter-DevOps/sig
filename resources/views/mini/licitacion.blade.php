@extends('mini.theme')
@section('title', 'Licitaciones') 
@section('page-styles')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/sip.css')}}">
<link rel="stylesheet" type="text/css" href="/vendors/css/extensions/toastr.css">
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
 // height:100vh;
}

/* Individual Task */
.task { 
  width: 100%;
  height: max-content;
  
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

.task:not(.completed):not(.completing) { border-bottom: 2px solid #d44a29; }


.task.completing { text-decoration: line-through; background-color: green; }

.task.completed { 
  opacity: 0.5;
  background-color: #323232; }

.task.completed:before { content: ""; }

.task.deleting { background-color: #323232; }
  .stats{
  bottom: 0px;
  background: antiquewhite;
padding: 10px;
 }
</style>
@endsection
@section('content')
<section class="clear">
			<ul class="task-list">
			</ul>
</section>
  <div class="stats" style="position:fixed ; left:0; right:0; width:100%; display:flex;justify-content:space-between; " > 
    <button class="btn btn-danger cant_aprobadas"> 0 </button>
    <div class="navegacion" style="display:flex; align-items: center;  " >
      <i class='bx bx-chevron-left' style="font-size:40px;color:var(--blue)" onclick="side_slide(-1)" ></i>
      <span class="num_licitacion"> 1 de 15</span>
      <i class='bx bx-chevron-right'style=" font-size:40px;color:var(--blue)" onclick="side_slide(1)" ></i>
    </div>
    <button class="btn btn-success cant_rechazadas "> 0 </button>
  </div>
<br>
  
<template id="template-licitacion" >
<li class="task card" style="display:none;">
<!--    <div class="card-header block-header-default">
       <h3 class="block-title">Nuevo cliente</h3
    </div>-->
    <div class="card-content card-container"  >
       <div class="card-body" style="padding:0; " >
        <div class="content-swipe" data-url_aprobar=""  data-url_desaprobar="" data-id="" data-tipo="">
          <div class="media-body" style="height:100vh;" >
            <h4 class="media-heading"></h6>
            <h6 class="users-view-username text-muted font-medium-1 "> <i class="bx bx-buildings " ></i>  </h6>  
            <h6 class="licitacion-id" >ID:</h6>
            <span class="users-view-id"></span>
            <table >
              <tr>
                <th style="width:30%" >Monto:</th>
                <td style="width:70%" ><div class="editable-monto-view" data-editable="/monto?update" data-name="monto_base"> </div></td>
              </tr>
            </table>
            <iframe src='https://view.officeapps.live.com/op/embed.aspx?src='height="70%"  width="100%"frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
            <a  class="btn btn-primary descargar" target="_blank" href="">Descargar</a>
          </div>
      </div>
    </div>
</div>
</li>
</template>
@endsection

@section('page-scripts')
<script src="/vendors/js/vendors.min.js"></script>
<script src="/assets/js/scripts.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>-->
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
<script src="/vendors/js/extensions/toastr.min.js"></script>
<script>

  var licitaciones = [] ;
  var cnt_aprobada = 0;
  var cnt_rechazadas = 0;
  var index_licitacion = 1; 
  var indexValue = 1; 
  let containersCards = document.querySelector('.task-list');
  let template = document.getElementById('template-licitacion');

  let rechazadas = document.querySelector(".cant_rechazadas");
  let aprobadas = document.querySelector(".cant_aprobadas");
  let num_licitacion = document.querySelector(".num_licitacion");

  function money( monto, moneda = 1 ){

    if(moneda == 2 ){
      return (new Intl.NumberFormat('us-US',{ style: 'currency', currency: 'USD' }).format(monto))
    }
    return (new Intl.NumberFormat('es-PE',{ style: 'currency', currency: 'PEN' }).format(monto))
  }

  function n_oportunidad(num,total){
    return `${num} de ${total}`;
  }

  function cargar_licitaciones(){

  var url = window.location;
  url  = url + "?ids=" + Object.keys(licitaciones);

  fetch('/mini/licitaciones',{
    headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                'X-Requested-With': 'XMLHttpRequest'
              }
              
  }).then(response => response.json())
    .then( data => {
        console.log(data);
           
        data.data.forEach( (item ) => {
          addCard(item)  
          //etiquetas.push(item)
          licitaciones[item.id] = item;
        })

        side_slide(0);
        iniciar();
      }) 
  }

  cargar_licitaciones();

  function addCard(item){
    let clone = template.content.cloneNode(true);
    console.log(clone)
    clone.querySelector('.media-heading').textContent =  item.rotulo.toUpperCase() 
    clone.querySelector('li').dataset.url_aprobar = `/licitaciones/${item.id}/aprobar`;
    clone.querySelector('li').dataset.id = item.id;
    clone.querySelector('.users-view-username').append(document.createTextNode(item.empresa)) 
    clone.querySelector('.licitacion-id').textContent = item.nomenclatura ;
    clone.querySelector('li').dataset.url_desaprobar = `/licitaciones/${item.id}/rechazar`;
    clone.querySelector('.editable-monto-view').setAttribute('data-editable',  `/licitaciones/${item.id}?_update=monto`) ;
    clone.querySelector('.editable-monto-view').textContent = money( item.monto, 1 );
    clone.querySelector('iframe').src = `https://view.officeapps.live.com/op/embed.aspx?src=http://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode=${item.bases_integradas}`;  

    clone.querySelector('.descargar').href = `https://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode=${item.bases_integradas}`;  

    containersCards.append(clone) 
  }  
  
  function btm_slide(e){
    showLicitacion(indexValue = e);
  }
  function side_slide(e){
    showLicitacion(indexValue += e);
  }
  function showLicitacion(e){
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

    num_licitacion.textContent = `${indexValue} de ${listCards.length}`  
    rechazadas.textContent = cnt_rechazadas;
    aprobadas.textContent = cnt_aprobada;
  }
 function swipe( url, motivo = null ){

    let data = {
        method : motivo ?'post': 'get',   
        headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'X-Requested-With': 'XMLHttpRequest'
        }
      };
    if ( motivo ) {
      let formdata = new FormData();
      formdata.append( 'value', motivo );
      data.body = formdata;  
    }    

    return fetch( url, data )
      .then(response => response.json() )
      .then(data => {
         console.log(data);
         console.log( licitaciones );
         if( containersCards.childElementCount <= 10 ){
            cargar_licitaciones()
         }
         if( motivo == null ){
           toast('success', "Licitacion aprobada",900 )
         } else {
           toast('warning', "Licitacion rechazada",900 )    
         }
          return data;
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
  
  render_editable();
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

    if ( typeof  currentTask == 'undefined' || currentTask == null  ){
      return; 
    }

    if( currentTask.classList.contains("completing") ){
      currentTask.classList.remove("completing");
      //currentTask.classList.add("completed");
      swipe(currentTask.dataset.url_aprobar)
      cnt_rechazadas++;
      currentTask.remove();      
      side_slide(0);
    }
    else if( currentTask.classList.contains("deleting") ){
      console.log(licitaciones)

       rechazar(currentTask);
    }      

    console.log(licitaciones) 
    mouseOrigin = null;
    isSwiping = false;     
    currentTask.style.margin = 0;
    currentTask = null;
  }

  async function rechazar(currentTask){
    let response = await  Swal.fire({
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
             return data;
          })
          //return swipe(currentTask.dataset.url_desaprobar, motivo )
        }
      })
    if(response.isConfirmed){
      currentTask.remove();     
      cnt_aprobada++;
      toast('warning', "Licitacion rechazada",900 )    
      if ( containersCards.childElementCount <= 10 ){
         cargar_licitaciones()
      }
      side_slide(0)
    } else{
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
      else if( (mouseOrigin < currentMousePosition) &&
        !currentTask.classList.contains("completed") ){
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
