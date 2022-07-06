@extends('licitacion.theme')
@section('title', 'Nuevo Cliente') 
@section('page-styles')
<style>
  .content-wrapper{
    padding: 0;
  }

  .card { overflow-x: hidden }

  .content-body {
    --n: 1;
    display: flex;
    align-items: center;
    overflow-y: hidden;
    width: 100%; // fallback
    width: calc(var(--n)*100%);
    //	height: 50vw; max-height: 100vh;
    transform: translate(calc(var(--tx, 0px) + var(--i, 0)/var(--n)*-100%));
  }

  table {
    width:100%;
  }
.smooth { transition: transform .5s ease-out; }
  </style>
@endsection
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="card" style="width:100%;margin-top:15px;" >
<!--    <div class="card-header block-header-default">
       <h3 class="block-title">Nuevo cliente</h3
    </div>-->
    <div class="card-content card-container"  >
       <div class="card-body " >
       <!-- <a class="mr-1" href="#">
          <img src="https://sig.creainter.com.pe/images/portrait/small/avatar-s-26.jpg" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>-->
        <div class="content-swipe" data-url_aprobar="{{  '/etiquetas/'. $etiqueta->id . '/aprobar' }}"  data-url_desaprobar="{{ '/etiquetas/' . $etiqueta->id . '/rechazar' }}" data-id="{{ $etiqueta->id }}" data-tipo="{{ $etiqueta->tipo }}">
          <div class="media-body">
            <h6 class="media-heading"><span class="users-view-name">{{ strtoupper( $etiqueta->nombre ) }} </span><span class="text-muted font-medium-1">
            </span></h6>
            <span class="users-view-username text-muted font-medium-1 "> <i class="bx bx-buildings " ></i>  {{ $etiqueta->entidad ?? 'SIN ENTIDAD' }}</span></br>
            <span>Solicitado el :{{Helper::fecha( $etiqueta->solicitado_el ) }}  </span></br>
            <span>Solicitado por:{{ $etiqueta->solicitado_por  }}  </span>
      </div>
    </div>
</div>
@endsection
@section('page-scripts')

<script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>

<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>
<script>

  document.addEventListener('swiped-left', function(e) {
      console.log(e.target); // the element that was swiped
      //alert("left");
      let element = e.target;
      let parent = element.closest('.content-swipe')
      if ( parent ) { 
        console.log(parent);  
        swipe(parent.dataset.url_desaprobar,'---' )
      }     
  });

  document.addEventListener('swiped-right', function(e) {
      console.log(e.target); // the element that was swiped

      let element = e.target;
      let parent = element.closest('.content-swipe')

      //toastCheck()
      if ( parent ){
        console.log(parent);  
        swipe(parent.dataset.url_aprobar )
      } 
      //alert("right");
  });
  function swipe( url, motivo = null ){

    let data = {
        method :  motivo ?'post': 'get',   
        headers : { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          'X-Requested-With': 'XMLHttpRequest'
              }
      };
    if (motivo){
      let formdata = new FormData();
      formdata.append('value', motivo );
      data.body = formdata;  
    }    

    fetch( url, data )
      .then(response => response.json() )
      .then(data => {
           console.log(data);
           if(data.refresh == true ){
              location.reload();   
           }
      })
    }
  const _C = document.querySelector('.content-body'), 
      N = _C.children.length;

let i = 0, x0 = null, locked = false;

function unify(e) {	return e.changedTouches ? e.changedTouches[0] : e };

function lock(e) {
  x0 = unify(e).clientX;
	_C.classList.toggle('smooth', !(locked = true))
};

function drag(e) {
	e.preventDefault();
	
  
  const container_card = document.querySelector('.card-container');
	if(locked) 		
		_C.style.setProperty('--tx', `${Math.round(unify(e).clientX - x0)}px`)
     container_card.style.backgroundColor = 'background-color rgba(0, 0, 0, 0)'  
  if(( (unify(e).clientX ) > 90)  &&( (unify(e).clientX ) < 200 ) ) {
   console.log((unify(e).clientX ),'Rojo' );
   container_card.style.backgroundColor = 'var(--red)'
  } else if ((unify(e).clientX ) > 320  && (unify(e).clientX ) < 420  ) {
   console.log((unify(e).clientX ),'Verde' );
    container_card.style.backgroundColor = 'var(--green)'
  }else{
     container_card.style.backgroundColor = 'rgba(0, 0, 0, 0)'  
  }
};

function move(e) {
  const container_card = document.querySelector('.card-container');
  if(locked) {
    let dx = unify(e).clientX - x0, s = Math.sign(dx);

    if((i > 0 || s < 0) && (i < N - 1 || s > 0)){
      _C.style.setProperty('--i', i -= s);
    }
    _C.style.setProperty('--tx', '0px');

    container_card.style.backgroundColor = 'rgba(0, 0, 0, 0)'  
    _C.classList.toggle('smooth', !(locked = false));
    x0 = null
  }
};

_C.style.setProperty('--n', N);

_C.addEventListener('mousedown', lock, false);
_C.addEventListener('touchstart', lock, false);

_C.addEventListener('mousemove', drag, false);
_C.addEventListener('touchmove', drag, false);

_C.addEventListener('mouseup', move, false);
_C.addEventListener('touchend', move, false);  

</script>
@endsection
