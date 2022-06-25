@extends('expediente.theme')
@section('contenedor')
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
                <a class="nav-link active" href="/expediente/{{ $cotizacion->id }}/paso02">
                  Modificación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso03">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="/expediente/{{ $cotizacion->id }}/paso04">
                  Magia
                </a>
              </li>
            </ul>
            <div class="wizard-horizontal">
                <div class="row">
                      <div class="col-6" id="iframe_container" >
                      <iframe  class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src=https://sig.creainter.com.pe/storage/{{ reset($workspace['paso02'])['root']  }}?t={{time()}}' width='1366px' frameborder='0'  style="height:600px">
                      This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
                      </div>
                      <div class="col-6">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex">
                              <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Documentos
                            </h4>
                            <ul class="list-inline d-flex mb-0">
                              <li class="d-flex align-items-center">
                                <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                                {{ $cotizacion->empresa()->razon_social }}
                              </li>
                            </ul>
                          </div>
                          <form class="form" action="{{ route('expediente.paso02', ['cotizacion' => $cotizacion->id])}}" method="post">
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                              @foreach ($workspace['paso02'] as $key => $anexo)               
                              @csrf
                              <li class="widget-todo-item" data-id="anexo_1" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <span class="widget-todo-title ml-50">{{$anexo['rotulo'] }}</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1" onclick="visualizar(this)" style="cursor:pointer;" data-url="{{'https://sig.creainter.com.pe/storage/' . $anexo['root'] }}?t={{time()}}"><i class="bx bx-show"></i> </div>
                                    <a class="avatar bg-rgba-secondary  m-0 mr-50" href="https://sig.creainter.com.pe/storage/{{$anexo['root']}}" download="documento.docx" rel="noopener noreferrer">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bxs-download"></i>
                                      </div>
                                    </a>
                                    <input type="file" id="archivo-{{$anexo["generado_de_id"]}}" name="archivo-{{$anexo['generado_de_id'] }}" hidden style="display:none;" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" data-docid="{{ $anexo['generado_de_id'] }}" data-key="{{ $key }}" onchange="actualizar_archivo(this)" /> 
                                    
                                     <a class="avatar bg-rgba-primary m-0 mr-50" onclick="$('#archivo-{{$anexo['generado_de_id']}}').click();"  >
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bx-upload"></i>
                                      </div>
                                    </a>
                                    </div>
                                </div>
                              </li>
                              @endforeach
                            </ul>
                          </div>
                          <button class="btn btn-primary text-white" type="submit" href=""  id="save">Generar</button>
                        </div>
                      </div>
                </div>
              </fieldset>   
              <!-- body content of Step 3 end-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('page-scripts')
  @parent
<script>
function visualizar(e){
   let url = e.dataset.url
   let contairner_iframe= document.getElementById('iframe_container');
   contairner_iframe.innerHTML = '';
   let html = `<iframe class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src=${url}' width='1366px' frameborder='0' style="height:600px">
     This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> documen</iframe>`;
   contairner_iframe.insertAdjacentHTML('beforeend', html );
}
  $("#save").click( function() {
    const data = $('#list-anexos > li.completed').map(function() {
      if ( $(this).find(':input[type=checkbox]').val() == 'on' ) {
        return $(this).attr('data-id')
      }
    }).get()
    let empresa_id = document.getElementById('dropdownMenuButton').dataset.empresa_id;
    let formdata = new FormData();
    formdata.append('cotizacion_id', {{$cotizacion->id }} );
    formdata.append('anexos',data);

    fetch( '/expediente/', {
        headers:{
         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        method: 'post',
        body:formdata
    }).then(response => response.json()
    ).then(data => {
      console.log(data);
    })
  })

  function actualizar_archivo(file) {
    let box = $(file).closest('.widget-todo-item-action');
    let url = "/expediente/{{ $cotizacion->id }}/archivo/actualizar";
    let formdata = new FormData();
    formdata.append('archivo', file.files[0])
    formdata.append('documento_id', file.dataset.docid);
    formdata.append('key', file.dataset.key)

    box.prepend(`
                                    <div class="avatar bg-rgba-warning m-0 mr-50">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bx-loader-circle"></i>
                                        </div>
                                      </div>`);
    fetch( url , {
      headers: {
         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      method: 'post',
      body:formdata,
    }).then(response=> response.json())
      .then( data => {
        box.find('.bg-rgba-warning').slideUp();
        let see = box.find('.badge-light-success');
        see.attr('data-url', see.attr('data-url') + Math.random());
        see.click();
      });
  }
</script>
@endsection
