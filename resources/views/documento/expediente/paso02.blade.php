@extends('documento.expediente.theme')
@section('contenedor')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('documento.expediente_paso01', ['documento' => $documento->id])}}">
                  Anexos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{{ route('documento.expediente_paso02', ['documento' => $documento->id])}}">
                  Modificación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="{{ route('documento.expediente_paso03', ['documento' => $documento->id])}}">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="{{ route('documento.expediente_paso04', ['documento' => $documento->id])}}">
                  Magia
                </a>
              </li>
            </ul>
            <div class="wizard-horizontal">
                <div class="row">
                      <div class="col-8" id="iframe_container" >
                      <iframe  class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src=https://sig.creainter.com.pe/static/temporal/{{ reset($workspace['paso02'])['uri'] }}?t={{time()}}' width='1366px' frameborder='0'  style="height:600px">
                      This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
                      </div>
                      <div class="col-4">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom">
                            <h4 class="card-title d-flex">
                              <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Documentos Iniciales
                            </h4><br />
                            <ul class="list-inline d-flex mb-0">
                              <li class="d-flex align-items-center">
                                <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                                {{ $documento->cotizacion()->empresa()->razon_social }}
                              </li>
                            </ul>
                          </div>
                          <form class="form" action="{{ route('documento.expediente_paso02', ['documento' => $documento->id])}}" method="post">
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
                                    <div class="badge badge-pill badge-light-success mr-1" onclick="visualizar(this)" style="cursor:pointer;" data-url="{{'https://sig.creainter.com.pe/static/temporal/' . $anexo['uri'] }}?t={{time()}}"><i class="bx bx-show"></i> </div>
                                    <a class="avatar bg-rgba-secondary  m-0 mr-50" href="/static/temporal/{{$anexo['uri']}}?t={{time()}}" download rel="noopener noreferrer">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bxs-download"></i>
                                      </div>
                                    </a>
                                    <input type="file" id="archivo-{{$anexo["generado_de_id"]}}" name="archivo-{{$anexo['generado_de_id'] }}" hidden style="display:none;" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" data-docid="{{ $anexo['generado_de_id'] }}" data-cid="{{ $key }}" onchange="actualizar_archivo(this)" /> 
                                    
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
   let url = encodeURIComponent(e.dataset.url);
   let contairner_iframe= document.getElementById('iframe_container');
   contairner_iframe.innerHTML = '';
   let html = `<iframe class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src=${url}' width='1366px' frameborder='0' style="height:600px">
     This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> documen</iframe>`;
   contairner_iframe.insertAdjacentHTML('beforeend', html );
}
  function actualizar_archivo(file) {
    let box = $(file).closest('.widget-todo-item-action');
    let url = "/documentos/{{ $documento->id }}/expediente/actualizar";
    let formdata = new FormData();
    formdata.append('archivo', file.files[0])
    formdata.append('cid', file.dataset.cid);

    box.prepend(`
                                    <div class="avatar bg-rgba-warning m-0 mr-50">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bx-loader-circle"></i>
                                        </div>
                                      </div>`);
    Fetchx({
      title: 'Actualizar Archivo',
      url: url,
      headers: {
         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      type: 'post',
      data:formdata,
      processData: false,
      contentType: false,
      success: function() {
        box.find('.bg-rgba-warning').slideUp();
        let see = box.find('.badge-light-success');
        see.attr('data-url', see.attr('data-url') + Math.random());
        see.click();
      }
    });
  }
</script>
@endsection
