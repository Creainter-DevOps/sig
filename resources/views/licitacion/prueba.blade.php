
@extends('licitacion.theme')
@section('title', 'Nuevo Cliente') 
@section('page-styles')
<meta name="csrf-token" content="{{ csrf_token() }}" />
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

.task:before { content: "\2714"; left: -40px; }

.task:after { content: "\2718"; right: -40px; }

.task:not(.completed):not(.completing) { border-bottom: 2px solid #d44a29; }


.task.completing { text-decoration: line-through; background-color: green; }

.task.completed { 
  opacity: 0.5;
  background-color: #323232; }

.task.completed:before { content: ""; }

.task.deleting { background-color: #323232; }

</style>
@endsection
@section('content')
<section class="clear">
			<ul class="task-list">
			</ul>
</section>
  <div class="stats" style="position:fixed ; left:0; right:0; bottom: 10px;width:100%; display:flex;justify-content:space-between; padding: 0 5px 0 5px;" > 
    <button class="btn btn-danger cant_aprobadas"> 0 </button>
    <div class="navegacion" style="display:flex; align-items: center;  " >
      <i class='bx bx-chevron-left' style="font-size:40px;color:var(--blue)"></i>
      <span> 10 </span>
      <i class='bx bx-chevron-right'style=" font-size:40px;color:var(--blue)" ></i>
    </div>
    <button class="btn btn-success cant_rechazadas "> 0 </button>
  </div>
<br>
  
<template id="template-licitacion" >
<li class="task card" >
<!--    <div class="card-header block-header-default">
       <h3 class="block-title">Nuevo cliente</h3
    </div>-->
    <div class="card-content card-container"  >
       <div class="card-body" style="padding:0; " >
       <!-- <a class="mr-1" href="#">
          <img src="/images/portrait/small/avatar-s-26.jpg" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>-->
        <div class="content-swipe" data-url_aprobar=""  data-url_desaprobar="" data-id="" data-tipo="">
          <div class="media-body" style="height:100vh;" >
            <h4 class="media-heading"></h6>
            <h6 class="users-view-username text-muted font-medium-1 "> <i class="bx bx-buildings " ></i>  </h6>  
            <h6 class="licitacion-id" >ID:</h6>
            <span class="users-view-id"></span>
            <table >
              <tr>
                <th style="width:30%" >Monto:</th>
                <td style="width:70%" ><div class="editable-monto-view" data-editable="" data-name="monto_base"> </div></td>
              </tr>
            </table>
            <iframe src='https://view.officeapps.live.com/op/embed.aspx?src='height="70%"  width="100%"frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
          </div>
      </div>
    </div>
</div>
</li>
</template>
@endsection

@section('page-scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>
<script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
<script>

  var licitaciones = [] ;
  var cnt_aprobada = 0;
  var cnt_rechazadas = 0;
  
  let containersCards = document.querySelector('.task-list');
  let template = document.getElementById('template-licitacion');
  function money( monto, moneda ){
    //let d = (new Itl.numberFormat('es-PE',
    //{ style: 'currency', currency: 'PEN' }).format(monto));
    let d = (monto.toFixed(2)).replace( '.00', '',' ');
    if ( moneda == 1 ){
      return 'S/. '+ d;  
    }
    return d + 'USD';
    //return d;
  }

  function cargar_licitaciones(){
  fetch('/licitaciones/mini',{
    headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                'X-Requested-With': 'XMLHttpRequest'
              }
              
  }).then(response => response.json())
    .then( data => {
        console.log(data);
        if(licitaciones.length == 0){
          licitaciones = data.data;
          data.data.forEach( (item ) => {
            addCard(item)  
          })
        }else{
          data.data.forEach( (item ) => {
            addCard(item)  
            licitaciones.push(item)
          })
        }
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
    clone.querySelector('.editable-monto-view').setAttribute('data-editable',  `/licitaciones/${item.id}?update_monto`) ;

    clone.querySelector('.editable-monto-view').textContent = money( item.id, 1 );

    clone.querySelector('iframe').src = `https://view.officeapps.live.com/op/embed.aspx?src=http://prodapp.seace.gob.pe/SeaceWeb-PRO/SdescargarArchivoAlfresco?fileCode=${item.bases_integradas}`;  
    containersCards.append(clone) 
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

    fetch( url, data )
      .then(response => response.json() )
      .then(data => {
         console.log(data);
         console.log( licitaciones );
         if( containersCards.childElementCount <= 10 ){
            cargar_licitaciones()
         }
         if( motivo == 'aprobar' ){
           toast('success', "Licitacion aprobada",900 )
         }else{
           toast('warning', "Licitacion rechazada",900 )    
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
  var swipeMargin=20;
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
    let rechazadas =  document.querySelector(".cant_rechazadas");
    let aprobadas =  document.querySelector(".cant_aprobadas");
    console.log(currentTask) 
    if( currentTask.classList.contains("completing") ){
      currentTask.classList.remove("completing");
      //currentTask.classList.add("completed");
      //list.appendChild(currentTask);
      let lc = licitaciones.find(el => el.id == currentTask.dataset.id);
      licitaciones.splice(licitaciones.indexOf(lc), 1) 
      cnt_aprobada++;
      aprobadas.textContent = cnt_aprobada;
      swipe(currentTask.dataset.url_aprobar, 'aprobar')
      currentTask.remove();      
    }
    else if( currentTask.classList.contains("deleting") ){
      console.log(licitaciones)
      swipe(currentTask.dataset.url_desaprobar,'---' )
      let lc = licitaciones.find( el => el.id == currentTask.dataset.id );
      licitaciones.splice(licitaciones.indexOf(lc), 1) 
      cnt_rechazadas++;
      rechazadas.textContent = cnt_rechazadas      
      currentTask.remove();      
    }      

    console.log(licitaciones) 
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
