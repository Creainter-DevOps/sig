<style>
.blockProcess {
  display: none;
}
.blockLog {
    margin: 10px;
    background: #000000;
    min-height: 30px;
    border-radius: 3px;
    color: #fff;
    padding: 10px;
    text-align: center;
    white-space: pre;
    white-space: pre-line;
}
.blockEndProcess {
  display: none;
}
</style>
            <div class="blockProcess">
              <div style="font-size: 30px;text-align: center;color: #8b5bff;">Se está procesando {{ $documento->folio }} páginas...</div>
              <div class="blockLog"></div>
            </div>
            <div class="blockEndProcess">
              <div style="background: #efefef;border: 1px solid #d5d5d5;border-radius: 5px;padding: 5px;">
                <iframe  class="doc" src='{{ $workspace['documento_final'] }}' frameborder='0' style="height:500px;">
                This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
              </div>
              <div class="text-center" style="padding:10px;">
              <div class="row">
                <div class="col-3">
                  @if(!empty($documento->original))
                  <a class="btn btn-primary text-white" data-url-download-original target="_blank">Descargar Original
                    <i class="bx bxs-download" ></i>
                  </a>
                  @endif
                  </div>
                  <div class="col-3">
                  <a class="btn btn-secondary text-white" data-url-download target="_blank">Descargar Documento
                    <i class="bx bxs-download" ></i>
                  </a>
                  </div>
                  <div class="col-3">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Página" value="1" min="1" max="{{ $documento->folio }}">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="javascript:descargar_pagina(this);">Descargar Página</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-3">
                  @if(!empty($cotizacion))
                  @if(empty($cotizacion->propuesta_el))
                    <a class="btn btn-secondary text-white" data-confirm href="/cotizaciones/{{ $cotizacion->id }}/enviar" class="btn btn-sm btn-dark">Enviar Propuesta</a>
                  @else
                    Ya se ha registrado el Envio:<br /> {{ Helper::fecha($cotizacion->propuesta_el, true) }}
                  @endif
                  @endif
                  </div>
                </div>
              </div>
            </div>
@section('page-scripts')
@parent
<script>
function descargar_pagina(box) {
  let page = $(box).closest('.input-group').find('input').val();
  if(!(page >= 1 || /^[\d]+\-[\d]+$/.test(page))) {
    return alert('Ingrese una página válida:' + page);
  }
  const a = document.createElement('a');
    a.style.display = 'none';
    a.href = '/documentos/{{ $documento->id }}/descargarParte?page=' + page;
    a.download = 'Parte_de_documento_' + page + '.pdf';
    document.body.appendChild(a);
    a.click();
}
function parallelStatus() {
  let url = '/documentos/{{ $documento->id }}/parallelStatus';
  fetch(url, {
    method: 'post',
    headers: {
      "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
  })
  .then( response => response.json() )
  .then( res => {
    console.log(res);
    if(res.finished) {
      $(".blockProcess").slideUp();
      $(".blockEndProcess").show();
      $(".blockEndProcess").find('[data-url-download-original]').attr('href', res.data.url_original);
      $(".blockEndProcess").find('iframe').attr('src', $(".blockEndProcess").find('iframe').attr('src') + '?refresh');
      $(".blockEndProcess").find('[data-url-download]').attr('href', res.data.url_archivo);
      $(".blockEndProcess").find('.doc').attr('src', res.data.url_seace);

    } else {
      $(".blockProcess").show();
      $(".blockProcess").find(".blockLog").text(res.log);
      setTimeout(parallelStatus, 2000);
    }
  });
}
parallelStatus();
</script>
@endsection