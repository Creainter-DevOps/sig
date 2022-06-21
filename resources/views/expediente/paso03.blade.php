@extends('expediente.theme')
@section('contenedor')
<section id="icon-tabs">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
              <li class="nav-item">
                <a class="nav-link" href="/expediente/{{ $cotizacion->id }}/paso01">
                  Anexos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/expediente/{{ $cotizacion->id }}/paso02">
                  Modificación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/expediente/{{ $cotizacion->id }}/paso03">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso04">
                  Magia
                </a>
              </li>
            </ul>

            <div class="wizard-horizontal" style="padding: 0 15px;">
                <div class="row">
                  <section id="MultipleContainers" >
                    <article id="ContainerOne" class="StackedListWrapper StackedListWrapper--sizeLarge StackedListWrapper--axisHorizontal Container" style="position:relative;">
                      <header class="StackedListHeader">
                        <h3 class="Heading Heading--size3 Heading--colorWhite">Mesa de Trabajo</h3>
                        <button class="btn btn-primary btn-sm" data-popup="/documentos/nuevo"  style="margin-right: 25px;position: absolute;top: 0;right: 10px;">+ Nuevos Documentos</button>
                      </header>

                      <ul class="StackedList" data-container="draw">
                      @foreach ($workspace['paso03'] as $k => $file)
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="{{ $k }}" data-orden="{{$file['orden'] }}" data-firma="{{ !empty($file['estampados']['firma']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}"  data-visado="{{ !empty($file['estampados']['visado']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}">
                        <img class="background_image" src="/expediente/{{ $cotizacion->id }}/generarImagen?page=0&cid={{$k}}&t={{time()}}"/>
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
              <!-- body content of Step 3 end-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-scripts')
@parent
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.12/draggable.bundle.js" integrity="sha512-CY+c7SEffH9ZOj1B9SmTrJa/ulG0I6K/6cr45tCcLh8/jYqsNZ6kqvTFbc8VQA/rl9c2r4QBOx2Eur+2vkVWsA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
var current_tool = null;
const cotizacion_id = {{$cotizacion->id}};

$(document).on('click', '[data-tools]', function() {
  current_tool = $(this).attr('data-tools');
  $('.contentPoint').addClass('activePoint');

});

$(document).on('click', '[data-remove]', function(e) {
  current_tool = $(this).attr('data-tools');
  //$('.contentPoint').addClass('activePoint');
  let url = '/expediente/{{$cotizacion->id}}/eliminarFirmas';
  var cid = e.target.parentNode.parentNode.parentNode.querySelector('.imagePoint').dataset.cid;
  console.log(cid);

  let formdata = new FormData();

  formdata.append('cid', cid );

   fetch( url , {
      method: 'post',
      headers: {
        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body : formdata
   })
   .then( response => response.json() )
   .then( data => {
      console.log(data)
   });

});

$(document).on('mousemove', '.contentPoint', function(e) {
  var x = e.pageX - $(this).offset().left;
  var y = e.pageY - $(this).offset().top;
  console.log('mousemove', '.contentPoint', x, y);
  if(x >= 20 && x <= $(this).width() - 45
    && y >= 20 && y <= $(this).height() - 45) {
    $(this).find('.puntero').css({
      left: x,
      top: y,
    });
  }
});

$(document).on('click', '.contentPoint', function(e) {
  var x = e.pageX - $(this).offset().left;
  var y = e.pageY - $(this).offset().top;

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
    if ( current_tool == "firma" && ( element.dataset.firma != "true" || element.dataset.firma == 'undefined' ) ){

      current_tool = null;
      element.dataset.firma = "true"  
      element.querySelector('.Pattern--typeHalftone').insertAdjacentHTML('afterbegin','<span class="text-white" style="text-align:center; padding:3px;border-radius:4px; background-color:#ff7600;"><i class="bx bxs-edit-alt"></i> </span>');
       
    } else if ( current_tool == "visado" && (element.dataset.visado != "true" || element.dataset.visado == 'undefined' ) ){

      current_tool = null;
      element.dataset.visado = "true"  
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
      .then( res => {
      if(render === true) {
        res.data.forEach(doc => {
        var container = document.querySelector('#ContainerOne .StackedList');
        container.insertAdjacentHTML('beforeend',`
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="${doc.cid}" data-orden="${ doc.orden }" data-tipo="${doc.tipo}">
                        <img class="background_image" src="/expediente/${cotizacion_id}/generarImagen?cid=${ doc.cid }&page=${ doc.page }&t={{time()}}" />
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
        });
      }
      render_dom_popup();
      })   
  }
 
</script>
@endsection
