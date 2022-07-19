<style>
.StackedListItem {
  background-image: url('/images/loading.gif')!important;
  background-size: 50px!important;
  background-repeat: no-repeat!important;
  background-position: center!important;
}
.StackedList.ready_for_upload {
  background: #cfffb1!important;
}
</style>
<div class="wizard-horizontal" style="padding: 0 15px;">
                <div class="row">
                  <section id="MultipleContainers" >
                    <article id="ContainerOne" class="StackedListWrapper StackedListWrapper--sizeLarge StackedListWrapper--axisHorizontal Container" style="position:relative;">
                      <header class="StackedListHeader">
                        <h3 class="Heading Heading--size3 Heading--colorWhite">Mesa de Trabajo</h3>
                        <div style="margin-right: 25px;position: absolute;top: 0;right: 10px;">
                          <button class="btn btn-primary btn-sm" id="btnRepositorio">Agregar de Repositorio</button>
                          <button class="btn btn-primary btn-sm" data-popup="/documentos/nuevo">Subir Documento</button>
                        </div>
                      </header>
                      <div id="drawRepositorio" style="padding: 5px 15px;display:none;">
                        <div id="BucketRepositorio" data-bucket="1" data-path="{{ $documento->directorio }}" data-upload="true" style="border:3px dashed #ff9900!important;"></div>
                      </div>
                      <ul class="StackedListDrag StackedList" data-container="draw" data-dropzone="draw">
                      @if(!empty($workspace['paso03']))
                      @foreach (Helper::workspace_ordenar($workspace['paso03']) as $k => $file)
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="{{ $k }}" data-orden="{{$file['orden'] }}" data-firma="{{ !empty($file['estampados']['firma']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}"  data-visado="{{ !empty($file['estampados']['visado']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}">
                        <img class="background_image" src="/documentos/{{ $documento->id }}/generarImagenTemporal?page=0&cid={{$k}}&t={{time()}}"/>
                        <div class="StackedListContent">
                          <div class="tools">
                            <a href="javascript:void(0);" data-popup="/documentos/{{ $documento->id }}/visualizar?cid={{ $k }}">Editar</a>
                            <a href="javascript:eliminarCid('{{ $k }}');">Eliminar</a>
                          </div>
                          <div class="DragHandle">
                          </div>
                          <div class="Pattern Pattern--typeHalftone" style="position:absolute; top:4px;left:4px;" >
                             @if ( !empty($file['estampados']['firma'] ))
                                <span class="text-white" style="text-align:center; padding:3px;border-radius:4px; background-color:#ff7600;"><i class="bx bxs-edit-alt"></i> </span>
                             @endif
                             @if ( !empty($file['estampados']['visado'] )) 
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
                      @endif
                     </ul>
                    </article>
                    <article id="ContainerTwo" class="StackedListWrapper StackedListWrapper--sizeMedium StackedListWrapper--hasScrollIndicator Container">
                    <header class="StackedListHeader">
                      <h3 class="Heading Heading--size3 Heading--colorWhite">Documentos</h3>
                      <div class="input-group" style="margin-bottom:10px;">
                      <input placeholder="Buscar" id="buscar" type="text" class="form-control" aria-label="Text input with dropdown button">
                      </div>
                    </header>
                    <ul class="StackedListDrag StackedList StackedList--hasScroll BloqueBusqueda" data-container="news" data-dropzone="draw">
                    </ul>
                  </article>
                  </section>
                </div>
            </div>
            <template id="template-icon-firma">
              <span class="text-white" style="text-align:center; padding:3px;border-radius:4px; background-color:#ff7600;"><i class="bx bxs-edit-alt"></i> </span>'
            </template>
            <template id="template-icon-visado">
              <span class="text-white" style="margin-left:2px;text-align:center; padding:3px;border-radius:4px; background-color:#188aff;" > <i class="bx bx-check-circle"></i> </span>
            </template>
            <template id="template-documento" >
              <li class="boxDraggable StackedListItem--isDraggable" data-id="" data-plantilla="" data-tipo="" data-folio="" data-es-ordenable="">
                  <div class="CardContent">
                    <div class="CardContentTitulo"></div>
                    <div class="CardContentDesc01"></div>
                    <div class="CardContentDesc02"></div>
                    <div class="CardContentDesc03"></div>
                  </div>
                </li>
            </template>
@section('page-scripts')
@parent
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.12/draggable.bundle.js" integrity="sha512-CY+c7SEffH9ZOj1B9SmTrJa/ulG0I6K/6cr45tCcLh8/jYqsNZ6kqvTFbc8VQA/rl9c2r4QBOx2Eur+2vkVWsA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
let preventDefaults = function (e) {
      e.preventDefault()
      e.stopPropagation()
    };
    let dropArea = document.querySelector('[data-container="draw"]');
    console.log('dropArea', dropArea);
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      dropArea.addEventListener(eventName, preventDefaults, false)
      document.body.addEventListener(eventName, preventDefaults, false)
    });
    dropArea.addEventListener('dragenter', function(e) {
      $(dropArea).addClass('ready_for_upload');
    });
    dropArea.addEventListener('dragleave', function(e) {
      $(dropArea).removeClass('ready_for_upload');
    });
    dropArea.addEventListener('dragover', function(e) {
      $(dropArea).addClass('ready_for_upload');
    });
    dropArea.addEventListener('drop', function(e) {
      console.log('drop', e);
      var dt = e.dataTransfer;
      var files = dt.files;
      handleFiles(files);
    }, false);

var current_tool = null;
$('#btnRepositorio').on('click', function() {
  $('#drawRepositorio').toggle();
});
$(document).on('click', '[data-tools]', function() {
  current_tool = $(this).attr('data-tools');
  $('.contentPoint').addClass('activePoint');
});

$(document).on('click', '[data-remove]', function(e) {
  current_tool = $(this).attr('data-tools');
  let url = '/documentos/{{ $documento->id }}/eliminarFirmas';
  let bodyModal =  e.target.parentNode.parentNode.parentNode;
  var cid = e.target.parentNode.parentNode.parentNode.querySelector('.imagePoint').dataset.cid;
  console.log(cid);

  let formdata = new FormData();

  formdata.append('cid', cid );

   fetch( url, {
      method: 'post',
      headers: {
        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body : formdata
   })
   .then( response => response.json() )
   .then( data => {
      console.log(data)

       let element = document.querySelector( `[data-id="${cid}"]` );  
       element.querySelector('.Pattern--typeHalftone').innerHTML = '';
       let estampados = bodyModal.querySelectorAll('.estampado')
       estampados.forEach( (estampado) => {
        if(estampado.dataset.tipo != "null" ){
          estampado.parentNode.removeChild(estampado);  
        }  
       }) 
   });

});

$(document).on('mousemove', '.contentPoint', function(e) {
  var x = e.pageX - $(this).offset().left;
  var y = e.pageY - $(this).offset().top;
  console.log('mousemove', '.contentPoint', x, y);
  if(x >= 50 && x <= $(this).width() - 75
    && y >= 50 && y <= $(this).height() - 75) {
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

  let url = '/documentos/{{ $documento->id }}/estampar';
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
      let clon_firma = document.getElementById("template-icon-firma").content.cloneNode(true).children[0];
      element.querySelector('.Pattern--typeHalftone').insertAdjacentElement('afterbegin',clon_firma);
      //'<span class="text-white" style="text-align:center; padding:3px;border-radius:4px; background-color:#ff7600;"><i class="bx bxs-edit-alt"></i> </span>');
      //element.querySelector('.Pattern--typeHalftone').append(template_firma.cloneNode(true));
    } else if ( current_tool == "visado" && (element.dataset.visado != "true" || element.dataset.visado == 'undefined' ) ){

      current_tool = null;
      element.dataset.visado = "true"  
      let clon_visado = document.getElementById("template-icon-visado").content.cloneNode(true).children[0];
      element.querySelector('.Pattern--typeHalftone').insertAdjacentElement('beforeend',clon_visado );
      //element.querySelector('.Pattern--typeHalftone').insertAdjacentHTML('beforeend',
      //' <span class="text-white" style="margin-left:2px;text-align:center; padding:3px;border-radius:4px; background-color:#188aff ;" > <i class="bx bx-check-circle"></i> </span>')
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
  let url = '/documentos/{{$documento->id}}/eliminarDocumento';
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
  let url = '/documentos/{{ $documento->id }}/buscar';
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
    let template = document.getElementById("template-documento").content;
    data.forEach( n => {
      /*let clone = template.cloneNode(true);
      console.log(clone);
      let li =  clone.querySelector("li");
      li.dataset.plantilla = n.es_plantilla;
      li.dataset.tipo =  n.tipo ;
      li.dataset.folio = n.folio;
      li.dataset.id = n.id;
      li.setAttribute("es-ordenable", n.es_ordenable );
      li.querySelector(".CardContentTitulo").textContent = n.rotulo ? n.rotulo : '';
      li.querySelector(".CardContentDesc01").textContent = (typeof n.desc01 !== 'undefined') ? n.desc01 : '';
      li.querySelector(".CardContentDesc02").textContent = (typeof n.desc02 !== 'undefined') ? n.desc02 : '';
      li.querySelector(".CardContentDesc03").textContent = (typeof n.desc03 !== 'undefined') ? n.desc03 : '';
      box.append(clone);*/

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

var bucket = new Bucketjs();
bucket.capture(document.getElementById('BucketRepositorio'));

  const Classes = {
    draggable: 'StackedListItem--isDraggable',
    capacity: 'draggable-container-parent--capacity',
    dropzone: 'StackedListItem--isDropZone'
  };

  const containers = document.querySelectorAll('#MultipleContainers .StackedListDrag');

  if (containers.length === 0) {
   console.log("sin contenedores");
  }
  console.log('CONTENEDORES', containers);

  const sortable = new Draggable.Sortable(containers, {
    delay: 100,
    draggable: `.${Classes.draggable}`,
    dropzone: `.${Classes.dropzone}`,
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
    console.log('drag:start');
    currentMediumChildren = sortable.getDraggableElementsForContainer(sortable.containers[1])
      .length;
    capacityReached = currentMediumChildren === containerTwoCapacity;
    lastOverContainer = evt.sourceContainer;
    containerTwoParent.classList.toggle(Classes.capacity, capacityReached);
  });
  sortable.on('droppable:dropped', (evt) => {
    console.log('droppable:dropped');
  });
  sortable.on('sortable:sort', (evt) => {
    console.log('sortable:sort', evt.dragEvent.sourceContainer.dataset.container, evt.dragEvent.sourceContainer.dataset.dropzone, evt.dragEvent.overContainer.dataset.container);
    if(evt.dragEvent.sourceContainer.dataset.dropzone != evt.dragEvent.overContainer.dataset.container) {
      console.log('CANCELANDO...');
//      sortable.dragging = false;
      return evt.cancel();
    }
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
      if (box.dataset.plantilla == "true") {
        let url = '/documentos/nuevo?generado_de_id=' + box.dataset.id + "&expediente_id=" + {{$documento->id}} + "&orden=" + evt.data.newIndex 
        var button = $("<button>").attr('data-popup', url );
        $("body").append(button);
        render_dom_popup();
        button.click();
        return 0;
      }
      console.log('agregarDocumento', evt.data.newIndex);
      agregarDocumento(box.dataset.id, evt.data.newIndex, true, evt.data.dragEvent.data.originalSource);
      return 0;

    } else if ( evt.data.oldContainer != lastOverContainer && $(lastOverContainer).attr('data-container') == 'news') {
      var box = evt.data.dragEvent.data.originalSource;
      console.log('RETIRAR ELEMENTO', box, lastOverContainer);
      $(box).remove();
      return 0;

    } else if ( lastOverContainer === evt.data.newContainer && $(lastOverContainer).attr('data-container') == 'draw' && evt.data.newIndex !== evt.data.oldIndex) {
      console.log('MOVER', evt.data.newIndex, evt.data.oldIndex, lastOverContainer, evt);
      var box = evt.data.dragEvent.data.originalSource;
      move_card( box.dataset.id, evt.data.newIndex);
      return 0;
    }
  });


  function move_card (id, orden){
      let url = '/documentos/{{ $documento->id }}/ordenar';
      let formdata = new FormData();
      formdata.append('id', id);
      formdata.append('orden', orden);
      //formdata.append('page', page) ;

      Fetchx({
        title: 'Ordenando',
        url: url,
        type: 'post',
        headers: {
          "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        },
        data: { id: id, orden: orden },
        dataType: 'json',
        success: function(data) {
          console.log(data);
        }
      });
  }
  function insertAtIndex(container, box, i) {
    console.log('insertAtIndex', i);
    i --;
    if(i < 0) {
     $(container).prepend(box);
     return;
    }
    var apoyo = $(container).children().eq(i);
    if(apoyo.length) {
      apoyo.after(box);
    } else {
      $(container).append(box);
    }
  }
  function agregarDocumento(documento_id, orden, render, reemplazar) {
    orden  = orden  || 0;
    render = render || false;
   
    let url = '/documentos/{{ $documento->id }}/agregarDocumento/' + documento_id;

    Fetchx({
      title: 'Agregar Documento',
      url: url,
      headers: {
         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
      },
      type: 'post',
      data: { orden: orden - 1 }, 
      success: function(res) {
        $(reemplazar).remove();
        if(!res.status) {
          return toastr.error('Denegado', res.message);
        }
        if(render === true) {
          res.data.forEach(doc => {
            insertAtIndex('#ContainerOne .StackedListDrag.StackedList', `
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="${doc.cid}" data-orden="${ doc.orden }" data-tipo="${doc.tipo}">
                        <img class="background_image" src="/documentos/{{ $documento->id}}/generarImagenTemporal?cid=${ doc.cid }&page=${ doc.page }&t={{time()}}" />
                        <div class="StackedListContent">
                          <div class="tools">
                            <a href="javascript:void(0);" data-popup="/documentos/{{ $documento->id }}/visualizar?cid=${ doc.cid }">Editar</a>
                            <a href="javascript:eliminarCid('${doc.cid}');">Eliminar</a>
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
                      </li>`, orden);
            orden++;
          });
        }
        render_dom_popup();
      },
    });
  }
 
</script>
@endsection
