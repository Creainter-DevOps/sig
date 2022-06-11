@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Widgets')
{{-- vendor scripts --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<style>

  .SortAnimation{
    width:100%;
  }

  .BlockLayout{
    display:grid;
    grid-template-columns: 1fr  1fr 1fr;
    grid-gap:10px;
  }

  .file{
    background-color: white;
    border: 1px solid red;  
    min-height: 120px;
    width: 150px;
    display:flex;
    align-items:end;
    justify-content:center;
  }

  .file p{
    text-align:center;
  }

  img.background_image{
    position: absolute;
    height: auto;
    top: 0;
    width: 100%;
  }

  #ContainerOne .StackedListItem .StackedListContent{
    z-index:9;
  } 
  #ContainerOne .StackedListItem{
    list-style :none;
    min-height:180px;
    border:1px solid red;
    cursor:pointer;
    border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    cursor: move;
    overflow:hidden;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: #fff;
    border-radius: 4px;
    margin-right: 25px;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    padding: 10px;
    transition: box-shadow 200ms cubic-bezier(0, 0, 0.2, 1);
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
display:flex;
    align-items:end;
  }

  #ContainerTwo .StackedListItem{
    list-style :none;
    height:160px;
    border:1px solid red;
    min-height: 140px;
    cursor:pointer;
border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    cursor: move;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: #fff;
    border-radius: 4px;
    margin-right: 25px;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    padding: 10px;
    transition: box-shadow 200ms cubic-bezier(0, 0, 0.2, 1);
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
    display:flex;
    align-items:end;
  }
  #ContainerTwo .StackedListItem h4 { 
    font-size:15px;  
  }

  #MultipleContainers{
    width:100%;
    display:grid;
    grid-template-columns: 1fr 300px; 
    min-height: 500px;
  }

  #ContainerTwo .StackedList{
    display:flex;
    flex-direction: column;
    align-items: center;
    grid-gap:15px;
    padding: 0;
  }

  .doc {
    width: 100%;
    height: 100% ;
    min-height: 550px; 
  }

  #ContainerOne .StackedList {
    display:grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;  
    grid-gap:15px;
    min-height: 200px;
    padding: 0;
    border: 1px dashed #5030ff;
    margin: 15px;
    padding: 10px;
    border-radius: 10px;
    border-width: 3px;
    padding-bottom: 217px;
  }
  #ContainerTwo .StackedList {
    display:grid;
    grid-template-columns: 1fr; 
    border: 1px dashed #0689f9;
    padding: 10px;
    border-radius: 10px;
    border-width: 3px;
    padding-bottom: 50px;
    overflow: auto;
    max-height: 650px;
  } 

  #ContainerOne .StackedListContent .Heading {
    color: #dfe3e7;
    background-color: #1a233a;
    width: 100%;
    padding: 1px 4px; 
    border-radius: 5px;
    margin-top: 2px;
  }
  .BloqueBusqueda {
    max-height: 100%;
    overflow: auto;
  } 
  .BloqueBusqueda > .StackedListItem {
     max-height: 60px;
  }
.boxDraggable {
    list-style: none;
    cursor: pointer;
    position: relative;
    border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    border-radius: 4px;
    padding: 5px;
    background: #fff;
    transition: box-shadow 200ms cubic-bezier(0, 0, 0.2, 1);
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
    padding-bottom: 15px;
}
.boxDraggable .tools {
    position: absolute;
    top: 3px;
    right: 3px;
    background: rgb(0 0 0 / 32%);
    border-radius: 3px;
    padding: 2px 10px;
    font-size: 11px;
    color: #fff;
}
.boxDraggable[data-plantilla='true'] {
    background-color: #ffebd0;
    color: #000;
    border: 1px solid #ffd49a;
}
.boxDraggable[data-tipo='CONTRATO'] {
}
.boxDraggable[data-tipo='CONTRATO'] .CardContentTitulo {
    font-size: 11px;
    text-align: center;
}

.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc01 {
    text-align: center;
    font-size: 12px;
}
.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc01 {
    text-align: center;
    font-size: 12px;
}

.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc02 {
position: absolute;
    bottom: 0;
    left: 0;
    font-size: 11px;
    padding-left: 20px;
    padding-bottom: 2px;
}
.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc03 {
position: absolute;
    bottom: 0;
    right: 0;
    font-size: 11px;
    padding-right: 20px;
    padding-bottom: 2px;
}
.draggable-container--is-dragging {
  background: #fbf4ff;
}
.draggable-source--is-dragging {
    background: #ffffff!important;
    border: 1px dashed #00cd07!important;
    border-width: 2px!important;
}
.draggable-source--is-dragging > * {
  display: none;
}
[data-tools] {
    cursor: pointer;
    display: inline-block;
    padding: 5px 20px;
    margin: 2px 5px;
    background: #fff;
    color: black;
    text-align: center;
    border-radius: 5px;
}
.contentPoint {
  position:relative;
}
.contentPoint.activePoint .puntero {
  display:block!important;
}
.contentPoint .puntero {
  display: none;
  position: absolute;
  z-index: 999;
  top: 0;
  left: 0;
  width: 25px;
  height: 25px;
  background: #00e707;
}
.contentPoint .estampado[data-tipo='firma'] {
  position: absolute;
  z-index: 999;
  width: 50px;
  height: 50px;
  background: #ff7600;
}
.contentPoint .estampado[data-tipo='visado'] {
  position: absolute;
  z-index: 999;
  width: 50px;
  height: 50px;
  background: #188aff;
}
.folio {
  padding: 2px 6px ;
  width:max-content;
  color:white;
  font-size: 15px;
  border-radius: 5px;
  background-color: orange ;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/widgets.css')}}">
@endsection
@section('content')
<section id="icon-tabs">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <div class="wizard-horizontal" style="padding: 0 15px;">
                <div class="row">
                  <section id="MultipleContainers" >
                    <article id="ContainerOne" class="StackedListWrapper StackedListWrapper--sizeLarge StackedListWrapper--axisHorizontal Container" style="position:relative;">
                      <header class="StackedListHeader">
                        <h3 class="Heading Heading--size3 Heading--colorWhite">Ordenar PDF</h3>
                        <button class="btn btn-primary btn-sm" data-popup="/documentos/nuevo"  style="margin-right: 25px;position: absolute;top: 0;right: 10px;">+ Nuevos Documentos</button>
                      </header>

                      <ul class="StackedList" data-container="draw">
                      @foreach ($workspace['paso03'] as $k => $file)
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="{{ $k }}" data-orden="{{$file['orden'] }}" data-firma="{{ !empty($file['estampados']['firma']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}"  data-visado="{{ !empty($file['estampados']['visado']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}">
                        <img class="background_image" src="/expediente/{{ $cotizacion->id }}/generarImagen?page=0&cid={{$k}}"/>
                        <div class="StackedListContent">
                          <div class="tools">
                            <a href="javascript:void(0);" data-popup="/expediente/{{$cotizacion->id }}/visualizar?cid={{ $k }}">Editar</a>
                            <a href="javascript:eliminarCid('{{ $k }}');">Eliminar</a>
                          </div>
                          <div class="DragHandle">
                          </div>
                          <div class="Pattern Pattern--typeHalftone" style="position:absolute; top:4px;left:4px;" >
                             @if ( !empty( $file['estampados']['firma'] ))
                                <span class="text-white" style="text-align:center; padding:3px;border-radius:4px; background-color:#ff7600;"><i class="bx bxs-edit-alt"></i> </span>
                             @endif
                             @if ( !empty( $file['estampados']['visado'] )) 
                                <span class="text-white" style="margin-left:2px;text-align:center; padding:3px;border-radius:4px; background-color:#188aff ;" > <i class="bx bx-check-circle"></i> </span>
                             @endif
                          </div>
                        <div class="Pattern Pattern--typePlaced"style="display:flex;flex-direction: column; align-items:center; " >
                          <div class="folio">{{ $file['folio'] }}</div>
                          <div class="Heading Heading--size4 text-no-select">{{ $file['rotulo'] }}</div>
                        </div>
                        </div>
                      </li>
                      @endforeach
                     </ul>
                     <div style="position: absolute;bottom: 15px;right: 20px;">
                       <form method="post" action="{{ route('expediente.paso03',['cotizacion' => $cotizacion->id ]) }}"  >
                       @csrf
                       <button class="btn btn-primary" type="submit">Procesar</a>
                       </form>
                     </div>
                    </article>
                    <article id="ContainerTwo" class="StackedListWrapper StackedListWrapper--sizeMedium StackedListWrapper--hasScrollIndicator Container">
                    <header class="StackedListHeader">
                      <h3 class="Heading Heading--size3 Heading--colorWhite">Documentos</h3>
                      <div class="input-group" style="margin-bottom:10px;">
                      <input placeholder="Buscar" id="buscar" type="text" class="form-control" aria-label="Text input with dropdown button">
                      </div>
                    </header>
                    <ul class="StackedList StackedList--hasScroll BloqueBusqueda" data-container="news"></ul>
                  </article>
                  </section>
                </div>
              </fieldset>
              <!-- body content of Step 3 end-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- Form wizard with number tabs section end -->
  <!-- Task App Widget Ends -->
  </div>
  </div>
</section>
<!-- Widgets Charts End -->
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')

<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.12/draggable.bundle.js" integrity="sha512-CY+c7SEffH9ZOj1B9SmTrJa/ulG0I6K/6cr45tCcLh8/jYqsNZ6kqvTFbc8VQA/rl9c2r4QBOx2Eur+2vkVWsA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
var current_tool = null;
const cotizacion_id = {{$cotizacion->id}};
$(document).on('click', '[data-tools]', function() {
  current_tool = $(this).attr('data-tools');
  $('.contentPoint').addClass('activePoint');
});

$(document).on('mousemove', '.contentPoint', function(e) {
  var x = e.clientX - $(this).offset().left - 13;
  var y = e.clientY - $(this).offset().top - 13;
  if(x >= 20 && x <= $(this).width() - 45
    && y >= 20 && y <= $(this).height() - 45) {
    $(this).find('.puntero').css({
      left: x,
      top: y,
    });
  }
});

$(document).on('click', '.contentPoint', function(e) {
  var x = e.clientX - $(this).offset().left;
  var y = e.clientY - $(this).offset().top;

  var cid = $(this).find('img').attr('data-cid');
  var page = $(this).find('img').attr('data-page');

  $(this).find(".estampado[data-tipo='" + current_tool + "']").remove();

  $(this).append('<div class="estampado" data-tipo="' + current_tool + '" style="left:' + x + 'px;top:' + y + 'px;"></div>');

  $('.contentPoint').removeClass('activePoint');

  let url = '/expediente/{{$cotizacion->id}}/estampar';
  let formdata = new FormData();
  formdata.append('cid', cid);
  formdata.append('tool', current_tool);
  formdata.append('page', page);
  formdata.append('pos_x', x / $(this).width());
  formdata.append('pos_y', y / $(this).height());
  fetch(url, {
    method: 'post',
    headers: {
      "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formdata
  })
  .then( response => response.json() )
  .then( data => {
    console.log(data);
    let element = document.querySelector( `[data-id="${cid}"]` );  
    console.log(element);
    console.log(current_tool );
    console.log ( element.dataset.firma )
    if ( current_tool == "firma" && ( element.dataset.firma == null || element.dataset.firma == 'undefined' ) ){

      current_tool = null;
      element.dataset.firma == "true"  
      element.querySelector('.Pattern--typeHalftone').insertAdjacentHTML('afterbegin','<span class="text-white" style="text-align:center; padding:3px;border-radius:4px; background-color:#ff7600;"><i class="bx bxs-edit-alt"></i> </span>');
       
    } else if ( current_tool == "visado" && (element.dataset.visado == null || element.dataset.visado == 'undefined' ) ){

      element.dataset.visado == "true"  
      element.querySelector('.Pattern--typeHalftone').insertAdjacentHTML('beforeend',' <span class="text-white" style="margin-left:2px;text-align:center; padding:3px;border-radius:4px; background-color:#188aff ;" > <i class="bx bx-check-circle"></i> </span>')
    }

  });

});

let buscador = document.getElementById('buscar');

buscador.addEventListener('keyup', (e) => {
  if( e.key == "Enter" ){
     realizar_busqueda(buscador.value);
  }
})

/*function visualizar(cid) {
  console.log('visualizar', cid);
  let box = $("<a>").attr('data-popup', '/expediente/{{$cotizacion->id }}/visualizar?cid=' + cid);
  $('body').prepend(box);
  box.click();
}*/

function eliminarCid(cid) {
  let url = '/expediente/{{$cotizacion->id}}/eliminarDocumento';
  $("[data-id='" + cid + "']").hide();
  let formdata = new FormData();
  formdata.append('cid', cid);
  fetch(url, {
    method: 'post',
    headers: {
      "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formdata
  })
  .then( response => response.json() )
  .then( data => {
  });
}
function realizar_busqueda( query ) {
  let url = '/expediente/{{$cotizacion->id}}/busquedaDocumentos';
  let formdata = new FormData();
  formdata.append('query', query);
  fetch(url, {
    method: 'post',
    headers: {
      "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formdata
  })
  .then( response => response.json() )
  .then( data => {
    let box = $('.BloqueBusqueda') ;
    box.html("");
    data.forEach(n => {
      box.append(`<li class="boxDraggable StackedListItem--isDraggable" data-id="${n.id}" data-plantilla="${n.es_plantilla}" data-tipo="${n.tipo}" data-folio="${n.folio}" data-es-ordenable="${n.es_ordenable}">
                        <div class="CardContent">
                          <div class="CardContentTitulo">${ n.rotulo }</div>
                          <div class="CardContentDesc01">${ n.desc01 }</div>
                          <div class="CardContentDesc02">${ n.desc02 }</div>
                          <div class="CardContentDesc03">${ n.desc03 }</div>
                        </div>
                      </li>`);
    })
  });
}
realizar_busqueda('');

  const Classes = {
    draggable: 'StackedListItem--isDraggable',
    capacity: 'draggable-container-parent--capacity',
    dropzone: 'StackedListItem--isDropZone'
  };

  const containers = document.querySelectorAll('#MultipleContainers .StackedList');

  if (containers.length === 0) {
    //return false;
     console.log("sin contenedores");
  }

  const sortable = new Draggable.Sortable(containers, {
    delay: 100,
    draggable: `.${Classes.draggable}`,
    mirror: {
      constrainDimensions: true,
    },
    plugins: [Draggable.Plugins.ResizeMirror],
  });

  const containerTwoCapacity = 3;
  const containerTwoParent = sortable.containers[1].parentNode;

  let currentMediumChildren;
  let capacityReached;
  let lastOverContainer;

  // --- Draggable events --- //
  sortable.on('drag:start', (evt) => {
    currentMediumChildren = sortable.getDraggableElementsForContainer(sortable.containers[1])
      .length;
    capacityReached = currentMediumChildren === containerTwoCapacity;
    lastOverContainer = evt.sourceContainer;
    containerTwoParent.classList.toggle(Classes.capacity, capacityReached);
  });

  sortable.on('sortable:sort', (evt) => {
    if (!capacityReached) {
      //console.log('SOURCE', evt.dragEvent.source );
      return;
    }

    const sourceIsCapacityContainer = evt.dragEvent.sourceContainer === sortable.containers[1];

    if (!sourceIsCapacityContainer && evt.dragEvent.overContainer === sortable.containers[1]) {
      evt.cancel();
    }

  });

  sortable.on('sortable:sorted', (evt) => {
    if (lastOverContainer === evt.dragEvent.overContainer) {
      return;
    }
    lastOverContainer = evt.dragEvent.overContainer;
    if (evt.sourceContainer == sortable.containers[1]){
       console.log(evt.originalSource)      
    }

  });
  sortable.on('sortable:stop', (evt) => {
    if ( evt.data.oldContainer != lastOverContainer && $(lastOverContainer).attr('data-container') == 'draw') {
      var box = evt.data.dragEvent.data.originalSource;
      console.log('NUEVO ELEMENTO', evt.data.dragEvent, lastOverContainer);
      $(evt.data.dragEvent.data.source).remove();
      if (box.dataset.plantilla == "true") {
        let url = '/documentos/nuevo?generado_de_id=' + box.dataset.id + "&cotizacion_id=" + {{$cotizacion->id}} + "&order=" + evt.data.newIndex 
        var button = $("<button>").attr('data-popup', url );
        $("body").append(button);
        render_dom_popup();
        button.click();
        return 0 ;
      }

      agregarDocumento(box.dataset.id, evt.data.newIndex, true);

    } else if ( evt.data.oldContainer != lastOverContainer && $(lastOverContainer).attr('data-container') == 'news') {
      var box = evt.data.dragEvent.data.originalSource;
      console.log('RETIRAR ELEMENTO', box, lastOverContainer);
      move_card( box.dataset.id,evt.data.newIndex);

    } else if ( lastOverContainer === evt.data.newContainer) {
      console.log('MOVER', lastOverContainer, evt);
      var box = evt.data.dragEvent.data.originalSource;
      move_card( box.dataset.id,evt.data.newIndex);
    }
  });


  function workspace(data){
    data.forEach((item )  => {
     
    })
  }

  //return sortable;
//}
  //
  
  function move_card (id,orden){
      let url = '/expediente/{{ $cotizacion->id }}/ordenar';  
      let formdata = new FormData();
      formdata.append('id', id);
      formdata.append('orden', orden);
      //formdata.append('page', page) ;

      fetch( url, {
        method: 'post',
        headers: {
          "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        },
        body: formdata    
      }).then( response => response.json() )
        .then( data => {
          console.log(data);
        });
  }

  function agregarDocumento(documento_id, orden, render) {
    orden  = orden  || 0;
    render = render || false;
    
    let url = '/expediente/{{ $cotizacion->id }}/agregarDocumento/' + documento_id;

    let formdata = new FormData();
    formdata.append('numero', 123);
    formdata.append('orden', orden);

    fetch(url , {
      headers: {
         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
      },
      method: 'post',
      body: formdata 
    }).then( response => response.json())
      .then( data => {
      if(render === true) {
        doc = data.data[0];
        console.log(data);
        var container = document.querySelector('#ContainerOne .StackedList');
        container.insertAdjacentHTML('beforeend',`
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="${doc.cid}" data-orden="${ doc.orden }" data-tipo="${doc.tipo}">
                        <img class="background_image" src="/expediente/${cotizacion_id}/generarImagen?cid=${ doc.cid }&page=${ doc.page }" />
                        <div class="StackedListContent">
                          <div class="tools">
                            <a href="javascript:void(0);" data-popup="/expediente/${cotizacion_id}/visualizar?cid=${ doc.cid }">Editar</a>
                            <a href="javascript:eliminarCid(${doc.cid});">Eliminar</a>
                          </div>
                          <div class="DragHandle">
                          </div>
                          <div class="Pattern Pattern--typeHalftone" style="position:absolute; top:4px;left:4px;" >
                          </div>
                        <div class="Pattern Pattern--typePlaced"style="display:flex;flex-direction: column; align-items:center; " >
                          <div class="folio">${ doc.folio }</div>
                          <div class="Heading Heading--size4 text-no-select">${ doc.rotulo }</div>
                        </div>
                        </div>
                      </li>
                      `);
      }
      render_dom_popup();
      })   
    
  }
 
</script>
@endsection
