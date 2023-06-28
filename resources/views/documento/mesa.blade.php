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

.contentPoint {

}
.contentPoint > .addons {
}
.contentPoint > .addons > div {
  text-align:center;
  width: 120px;
  height: 70px;
  position: absolute;
}
.contentPoint > .addons > div:hover {
  border: 2px solid red;
}
.contentPoint > .addons > div > img {
  max-width: 100%;
  max-height: 100%;
}
.tools > a {
  box-sizing: border-box;
  padding: 1px 4px 1px 4px;
  border-radius: 5px;
  /* border: 1px solid white; */
  line-height: 0.5;
  color: white;
}

.tools > .download{
  background-color: #fd7e14;  
}

.tools > .edit {
  background-color: #475F7B; 
}
.tools > .delete{
  background-color: #FF5B5C;
} 
.tools > .regenerar {
  background-color: #0066ff;  
}
</style>
<div class="wizard-horizontal" style="padding: 0 15px;">
                <div class="row">
                  <section id="MultipleContainers" >
                    <article id="ContainerOne" class="StackedListWrapper StackedListWrapper--sizeLarge StackedListWrapper--axisHorizontal Container" style="position:relative;">
                      <header class="StackedListHeader">
                        <h3 class="Heading Heading--size3 Heading--colorWhite">Mesa de Trabajo</h3>
                        <div style="margin-right: 25px;position: absolute;top: 0;right: 10px;">
                          <a href="/documentos/{{ $documento->id }}/downloadDirectory" class="btn btn-secondary btn-sm" style="background-color: #6e00ff!important" id="btnDownload" download onclick="javascript:$(this).slideUp();">Descargar en ZIP</a>
                          <button class="btn btn-primary btn-sm" id="btnRepositorio">Agregar de Repositorio</button>
                          <button class="btn btn-primary btn-sm" data-popup="/documentos/nuevo">Subir Documento</button>
                        </div>
                      </header>
                      <div id="drawRepositorio" style="padding: 5px 15px;display:none;">
                        <div id="BucketRepositorio" data-bucket="1" data-path="{{ $documento->directorio }}" data-upload="true" style="border:3px dashed #ff9900!important;"></div>
                      </div>
                      <ul class="StackedListDrag StackedList" data-container="secure" data-dropzone="secure,draw" style="min-height:225px;padding-bottom: 15px;background: #bcc1d7;">
                      @if(!empty($workspace['paso03']))
                      @foreach (Helper::workspace_ordenar($workspace['paso03']) as $k => $file)
                      @if(!empty($file['contexto']) && $file['contexto'] == 'secure')
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="{{ $k }}" data-orden="{{$file['orden'] }}" data-firma="{{ !empty($file['estampados']['firma']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}"  data-visado="{{ !empty($file['estampados']['visado']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}">
                        <img class="background_image" src="/documentos/{{ $documento->id }}/generarImagenTemporal?page=0&cid={{$k}}&t={{time()}}"/>
                        <div class="StackedListContent">
                          <div class="tools">
                            <a href="#">{{-- byteConvert(filesize($file['root'])) --}}</a>
                          @if(!empty($file['gid']))
                          <a class="regenerar" href="javascript:regenerarCid('{{ $k }}');">Regenerar</a>
                          @endif
                            <a class="download" href="/static/temporal/{{ str_replace('/tmp/', '', $file['root']) }}?t={{time()}}" download>Descargar</a>
                            <a class="edit"  href="javascript:void(0);" data-popup="/documentos/{{ $documento->id }}/visualizar?cid={{ $k }}">Editar</a>
                            <a class="delete" href="javascript:eliminarCid('{{ $k }}');">Eliminar</a>
                            @if(!file_exists($file['root']))
                            <div style="width: 8px;height: 8px;background: red;display: inline-block;border-radius: 6px;"></div>
                            @endif
                          </div>
                          <div class="DragHandle">
                          </div>
                          <div class="Pattern Pattern--typeHalftone" style="position:absolute; top:4px;left:4px;display: grid;grid-template: 1fr/1fr 1fr;column-gap: 4px;" >
                           @if ( Helper::recursive_count_key_value( $file, 'tool','firma') == ( $file['is_part'] == true ? 1 : $file['folio'] )   )
                                <span class="text-white" style="text-align:center; padding:1px 3px; border-radius:4px; background-color:#ff7600; cursor: initial;" title="Firmado">
                                  <i class="bx bxs-edit-alt" style="font-size:15px;"></i>
                                </span>
                             @endif

                             @if ( Helper::recursive_count_key_value( $file, 'tool','visado') == ( $file['is_part'] == true ? 1 : $file['folio'] ))
                                <span class="text-white" style="text-align:center; padding:1px 3px;border-radius:4px; background-color:#188aff; cursor: initial;"  title="Visado">
                                  <i class="bx bx-check-circle"style="font-size:15px;"></i>
                                </span>
                             @endif
                          </div>
                        <div class="Pattern Pattern--typePlaced"style="display:flex;flex-direction: column; align-items:center; " >
                          <div class="folio">{{ $file['folio'] }}</div>
                          <div class="Heading Heading--size4 text-no-select">{{ $file['rotulo'] }}</div>
                        </div>
                        </div>
                      </li>
                      @endif
                      @endforeach
                      @endif
                     </ul>
                      <ul class="StackedListDrag StackedList" data-container="draw" data-dropzone="draw,secure">
                      @if(!empty($workspace['paso03']))
                      @foreach (Helper::workspace_ordenar($workspace['paso03']) as $k => $file)
                      @if(empty($file['contexto']) || $file['contexto'] == 'draw')
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="{{ $k }}" data-orden="{{$file['orden'] }}" data-firma="{{ !empty($file['estampados']['firma']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}"  data-visado="{{ !empty($file['estampados']['visado']) ? "true" : '' }}" data-tipo="{{ $file['tipo'] }}">
                        <img class="background_image" src="/documentos/{{ $documento->id }}/generarImagenTemporal?page=0&cid={{$k}}&t={{time()}}"/>
                        <div class="StackedListContent">
                          <div class="tools">
                            <a href="#">{{-- byteConvert(filesize($file['root'])) --}}</a>
                          @if(!empty($file['gid']))
                          <a class="regenerar" href="javascript:regenerarCid('{{ $k }}');">Regenerar</a>
                          @endif
                            <a class="download" href="/static/temporal/{{ str_replace('/tmp/', '', $file['root']) }}?t={{time()}}" download>Descargar</a>
                            <a class="edit"  href="javascript:void(0);" data-popup="/documentos/{{ $documento->id }}/visualizar?cid={{ $k }}">Editar</a>
                            <a class="delete" href="javascript:eliminarCid('{{ $k }}');">Eliminar</a>
                            @if(!file_exists($file['root']))
                            <div style="width: 8px;height: 8px;background: red;display: inline-block;border-radius: 6px;"></div>
                            @endif
                          </div>
                          <div class="DragHandle">
                          </div>
                          <div class="Pattern Pattern--typeHalftone" style="position:absolute; top:4px;left:4px;display: grid;grid-template: 1fr/1fr 1fr;column-gap: 4px;" >
                           @if ( Helper::recursive_count_key_value( $file, 'tool','firma') == ( $file['is_part'] == true ? 1 : $file['folio'] )   )
                                <span class="text-white" style="text-align:center; padding:1px 3px; border-radius:4px; background-color:#ff7600; cursor: initial;" title="Firmado">
                                  <i class="bx bxs-edit-alt" style="font-size:15px;"></i>
                                </span>
                             @endif

                             @if ( Helper::recursive_count_key_value( $file, 'tool','visado') == ( $file['is_part'] == true ? 1 : $file['folio'] ))
                                <span class="text-white" style="text-align:center; padding:1px 3px;border-radius:4px; background-color:#188aff; cursor: initial;"  title="Visado">
                                  <i class="bx bx-check-circle"style="font-size:15px;"></i>
                                </span>
                             @endif
                          </div>
                        <div class="Pattern Pattern--typePlaced"style="display:flex;flex-direction: column; align-items:center; " >
                          <div class="folio">{{ $file['folio'] }}</div>
                          <div class="Heading Heading--size4 text-no-select">{{ $file['rotulo'] }}</div>
                        </div>
                        </div>
                      </li>
                      @endif
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
              <li class="boxDraggable StackedListItem--isDraggable" data-id="" data-plantilla="" data-tipo="" data-part="" data-folio="" data-es-ordenable="">
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
<?php if(!empty($_GET['verror'])) { ?>
setTimeout(function() {
  $(".StackedListItem[data-id='<?= $_GET['verror'] ?>']").find('.tools>[data-url]').click();
}, 1500);
<?php } ?>
function respaldar() {
  let url = '/documentos/{{ $documento->id }}/expediente/respaldar';
  Fetchx({
    id: 'respaldo',
    title: 'Respaldando',
    url: url,
    headers: {
       "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    type: 'POST',
  });
}

setInterval( respaldar, 1000 * 60 * 5 );

function restaurar() {
  let url = '/documentos/{{ $documento->id }}/expediente/restaurar';
  Fetchx({
    id: 'restauracion',
    title: 'Restaurando Archivos',
    url: url,
    headers: {
       "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    type: 'POST',
  });
}
restaurar();

let Empresas = {!! json_encode(App\EmpresaFirma::porTenant()) !!};

var commit = [];
var validateFile = function (file) {
    var validTypes = [
      "image/jpeg",
      "image/png",
      "image/gif",
      "application/pdf",
      "application/msword",
      "application/vnd.ms-powerpoint",
      "application/vnd.ms-excel",
      "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      "application/vnd.openxmlformats-officedocument.presentationml.presentation",
      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    ];
    if (validTypes.indexOf(file.type) === -1) {
      alert("El archivo tiene un formato no permitido: " + file.name);
      return false;
    }
    var maxSizeInBytes = 10e7; // 10MB
    if (file.size > maxSizeInBytes) {
      alert("El archivo es muy pesado: " + file.name);
      return false;
    }
    return true;
  };
var pushBucket = function () {
    if (commit.length === 0) {
      return false;
    }
    var formData = new FormData();
    for (var i = 0, len = commit.length; i < len; i++) {
      formData.append("files[]", commit[i]);
    }
    commit = [];
    Fetchx({
      title: 'Subiendo',
      url: '/documentos/{{ $documento->id }}/expediente/upload',
      data: formData,
      type: 'POST',
      headers: {
        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      contentType: false,
      processData: false,
      success: function(res) {
        if(!res.status) {
          return toastr.error('Denegado', res.message);
        }
        var orden = $("#ContainerOne .StackedListDrag.StackedList").children().length;
          res.append.forEach(doc => {
            insertAtIndex('#ContainerOne .StackedListDrag.StackedList', `
                      <li class="boxDraggable StackedListItem StackedListItem--isDraggable StackedListItem--item1" data-id="${doc.cid}" data-orden="${ doc.orden }" data-tipo="${doc.tipo}">
                        <img class="background_image" src="/documentos/{{ $documento->id}}/generarImagenTemporal?cid=${ doc.cid }&page=${ doc.page }&t={{time()}}" />
                        <div class="StackedListContent">
                          <div class="tools">
                            <a class="download" href="/static/temporal/${ doc.root.replace('/tmp/', '' )}?t={{ time() }}">Descargar</a>
                            <a class="edit" href="javascript:void(0);" data-popup="/documentos/{{ $documento->id }}/visualizar?cid=${ doc.cid }">Editar</a>
                            <a class="delete" href="javascript:eliminarCid('${doc.cid}');">Eliminar</a>
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
        render_dom_popup();
      }
    });
};
var handleFiles = function (files) {
    if (files.length === 0) {
      return false;
    }
    for (var i = 0, len = files.length; i < len; i++) {
      if (validateFile(files[i])) {
        commit.push(files[i]);
      }
    }
    pushBucket();
};


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
      $(dropArea).removeClass('ready_for_upload');
      handleFiles(files);
    }, false);

var current_tool = null;
$('#btnRepositorio').on('click', function() {
  $('#drawRepositorio').toggle();
});
$(document).on('click', '[data-tools]', function() {
  let tool = $(this).attr('data-tools');
  let eid  = $(this).closest('.modal-content').find('#selectEmpresa').val();

  current_tool = {
    type: 'image',
    eid: eid,
    tool: $(this).attr('data-tools'),
  };

  $('.contentPoint').addClass('activePoint');
});

$(document).on('mousemove', '.contentPoint', function(e) {
  if(current_tool) {
    var x = e.pageX - $(this).offset().left;
    var y = e.pageY - $(this).offset().top;
    if(x >= 50 && x <= $(this).width() - 75
      && y >= 50 && y <= $(this).height() - 75) {
      $(this).find('.puntero').css({
        left: x,
        top: y,
      });
    }
  }
});

$(document).on('click', '.contentPoint', function(e) {
  if(!current_tool) {
    return;
  }
  var x = (e.pageX - $(this).offset().left) / $(this).width();
  var y = (e.pageY - $(this).offset().top) / $(this).height();

  var cid = $(this).find('img').attr('data-cid');
  var page = $(this).find('img').attr('data-page');

  var el = pasteSign(this, current_tool, x, y);

  $('.contentPoint').removeClass('activePoint');

  let url = '/documentos/{{ $documento->id }}/estampar';

  Fetchx({
    title: 'Estampado',
    url: url,
    type: 'post',
    headers: {
      "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    data: {
      cid:   cid,
      eid:   current_tool.eid,
      tool:  current_tool.tool,
      page:  page,
      pos_x: x,
      pos_y: y,
    },
    dataType: 'json',
    beforeSend: function() {
      current_tool = null;
    },
    success: function(data) {
      $(el).attr('data-id', data.id);
    },
  });
});

$(document).on('click', '.addons>div[data-id]', function(e) {
  let url  = '/documentos/{{ $documento->id }}/eliminarEstampa';
  var cid  = $(this).closest('.contentPoint').find('.imagePoint').attr('data-cid');
  var fid  = $(this).attr('data-id');
  var page = $(this).closest('.contentPoint').find('.imagePoint').attr('data-page');

  $(this).closest('div').remove();
  
  Fetchx({
    url: url,
    type: 'post',
    headers: {
      "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    data: {
      cid: cid,
      fid: $(this).attr('data-id'),
      page: page,
    },
   })
});
function pasteSign(box, current, x, y) {
  if(typeof Empresas[current.eid] === 'undefined') {
//    return alert('La empresa no existe');
    return;
  }
  var image = null;
  if(current.tool == 'firma') {
    if(!Empresas[current.eid].imagen_firma) {
      return alert('No se ha encontrado una Imagen registrada.(1)');
    }
    image = '/static/cloud/' + Empresas[current.eid].imagen_firma;
  } else if(current.tool == 'visado') {
    if(!Empresas[current.eid].imagen_visado) {
      return alert('No se ha encontrado una Imagen registrada.(2)');
    }
    image = '/static/cloud/' + Empresas[current.eid].imagen_visado;
  } else {
    return alert('(3)');
  }

  var el = null;
  if(current.tool == 'firma') {
    el = $('<div>').css({
      left: (x*100 - 5) + '%',
      top: (y*100 - 5) + '%',
    }).html($('<img>').attr('src', image));

  } else if(current.tool == 'visado') {
    el = $('<div>').css({
      left: (x*100 - 5) + '%',
      top: (y*100 - 5) + '%',
    }).html($('<img>').attr('src', image));
  }
  console.log('AÑADIENDO', el, 'en', box);
  el.attr('data-tool', current.tool);
  if(typeof current.id !== 'undefined') {
    el.attr('data-id', current.id);
  }

  $(box).find(".addons").append(el);
  return el;
}
function fn_estamparCard(ContextId, relacion) {
  console.log('fn_estamparCard');
  for(var page in relacion) {
    if(relacion.hasOwnProperty(page)) {
      for(var fid in relacion[page]) {
        if(relacion[page].hasOwnProperty(fid)) {
          let fcard = relacion[page][fid];
          console.log('estampar', fcard);
          pasteSign($("#" + ContextId).find(".imagePoint[data-page='" + page + "']").closest('.contentPoint'), fcard, fcard.x, fcard.y);
        }
      }
    }
  }
}
let buscador = document.getElementById('buscar');

buscador.addEventListener('keyup', (e) => {
  if( e.key == "Enter" ){
     realizar_busqueda(buscador.value);
  }
})
function regenerarCid(cid) {
  let url = '/documentos/{{$documento->id}}/regenerarDocumento';
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
    respaldar();
  });
}
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
    respaldar();
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

      let clone = template.cloneNode(true);
      //console.log(clone);

      let li =  clone.querySelector("li");
      li.dataset.plantilla = n.es_plantilla;
      li.dataset.tipo =  n.tipo ;
      li.dataset.folio = n.folio;
      li.dataset.id = n.id;
      li.setAttribute( "es-ordenable", n.es_ordenable );
      li.querySelector(".CardContentTitulo").textContent = n.rotulo ? n.rotulo : '';
      li.querySelector(".CardContentDesc01").textContent = (typeof n.desc01 !== 'undefined') ? n.desc01 : '';
      li.querySelector(".CardContentDesc02").textContent = (typeof n.desc02 !== 'undefined') ? n.desc02 : '';
      li.querySelector(".CardContentDesc03").textContent = (typeof n.desc03 !== 'undefined') ? n.desc03 : '';
      box.append(clone);

    /* box.append(`<li class="boxDraggable StackedListItem--isDraggable" data-id="${n.id}" data-plantilla="${n.es_plantilla}" data-tipo="${n.tipo}" data-folio="${n.folio}" data-es-ordenable="${n.es_ordenable}">
                  <div class="CardContent">
                    <div class="CardContentTitulo">${ n.rotulo }</div>
                    <div class="CardContentDesc01">${ n.desc01 }</div>
                    <div class="CardContentDesc02">${ n.desc02 }</div>
                    <div class="CardContentDesc03">${ n.desc03 }</div>
                  </div>
                </li>`);*/

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
    var ll = evt.dragEvent.sourceContainer.dataset.dropzone.split(',');
    var rr = false;
    for(var ii in ll) {
      if(ll[ii] == evt.dragEvent.overContainer.dataset.container) {
        rr = true;
      }
    }
    if(!rr) {
      return evt.cancel();
    }

//  if(evt.dragEvent.sourceContainer.dataset.dropzone != evt.dragEvent.overContainer.dataset.container) {
//    console.log('CANCELANDO...');
//      sortable.dragging = false;
//    return evt.cancel();
//  }
    if (!capacityReached) {
      //console.log('SOURCE', evt.dragEvent.source );
      return;
    }
    const sourceIsCapacityContainer = evt.dragEvent.sourceContainer === sortable.containers[1];

    if (!sourceIsCapacityContainer && evt.dragEvent.overContainer === sortable.containers[1]) {
      //console.log('CANCELADO XD', sortable.containers);
      //evt.cancel();
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
//    console.log('SORTABLE:STOP', evt.data.oldContainer, evt.data.newContainer);
    if ( evt.data.oldContainer != lastOverContainer && $(evt.data.newContainer).attr('data-container') == 'draw' && $(evt.data.oldContainer).attr('data-container') == 'news') {
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
      box.remove();
      agregarDocumento(box.dataset.id, evt.data.newIndex, true, evt.data.dragEvent.data.originalSource);
      return 0;

    } else if ( evt.data.oldContainer != lastOverContainer && $(lastOverContainer).attr('data-container') == 'news') {
      var box = evt.data.dragEvent.data.originalSource;
      console.log('RETIRAR ELEMENTO', box, lastOverContainer);
      $(box).remove();
      return 0;

    } else if ( lastOverContainer === evt.data.newContainer && evt.data.newIndex !== evt.data.oldIndex && $(lastOverContainer).attr('data-container') == 'draw') {
      console.log('MOVER1', evt.data.newIndex, evt.data.oldIndex, lastOverContainer, evt);
      var box = evt.data.dragEvent.data.originalSource;
      move_card(box.dataset.id, evt.data.newIndex, $(lastOverContainer).attr('data-container'));
      return 0;
    } else if ( lastOverContainer === evt.data.newContainer && evt.data.newIndex !== evt.data.oldIndex && $(lastOverContainer).attr('data-container') == 'secure') {
      console.log('MOVER2', evt.data.newIndex, evt.data.oldIndex, lastOverContainer, evt);
      var box = evt.data.dragEvent.data.originalSource;
      move_card(box.dataset.id, evt.data.newIndex, $(lastOverContainer).attr('data-container'));
      return 0;
    }
  });


  function move_card (id, orden, contexto) {
    console.log('move_card', id, orden, contexto);
      let url = '/documentos/{{ $documento->id }}/ordenar';
      let formdata = new FormData();
      formdata.append('id', id);
      formdata.append('orden', orden);
      Fetchx({
        title: 'Ordenando',
        url: url,
        type: 'post',
        headers: {
          "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        },
        data: { id: id, orden: orden, contexto: contexto },
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
