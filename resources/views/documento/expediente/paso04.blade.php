@extends('documento.expediente.theme')
@section('contenedor')
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
                <a class="nav-link" href="{{ route('documento.expediente_paso02', ['documento' => $documento->id])}}">
                  Modificación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('documento.expediente_paso03', ['documento' => $documento->id])}}">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{{ route('documento.expediente_paso04', ['documento' => $documento->id])}}">
                  Magia
                </a>
              </li>
            </ul>
            <div class="blockProcess">
              <div style="font-size: 30px;text-align: center;color: #8b5bff;">
                Se está procesando {{ $documento->folio }} páginas, tiempo estimado:
                <div data-time-left="{{ strtotime($documento->procesado_desde) + ((int) ($documento->folio * 9.78)) - time() }}"></div>
              </div>
              <div class="blockLog"></div>
              <div style="text-align:center;padding:10px;">
                <button class="btn btn-primary" onclick="cancelarProceso(event)"  data-id="{{ $documento->id }}">Cancelar proceso</button>
              </div>
            </div>
            <div class="blockEndProcess">
              <div style="background: #efefef;border: 1px solid #d5d5d5;border-radius: 5px;padding: 5px;">
                <iframe  class="doc" src='{{ $workspace['documento_final'] ?? '' }}' frameborder='0' style="height:500px;">
                This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
              </div>
              <div class="text-center" style="padding:10px;">
              <div class="row">
                <div class="col-3">
                  @if(!empty($documento->original))
                  <a class="btn btn-primary text-white" data-url-download-original target="_blank">Descargar Confidencial
                    <i class="bx bxs-download" ></i>
                  </a>
                  @endif
                  </div>
                  <div class="col-3">
                  <a class="btn btn-secondary text-white" data-url-download target="_blank">Descargar Expediente
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
                  @if(empty($documento->cotizacion()->propuesta_el))
                    <a class="btn btn-secondary text-white" data-confirm data-button-dinamic href="/cotizaciones/{{ $documento->cotizacion()->id }}/registrarPropuesta" class="btn btn-sm btn-dark">Marcar como Enviado</a>
                  @else
                    Ya se ha registrado el Envio:<br /> {{ Helper::fecha($documento->cotizacion()->propuesta_el, true) }} por {{ $documento->cotizacion()->propuesta_por }}
                  @endif
                  </div>
                </div>
              </div>
            </div>
            @if(!empty($documento->cotizacion()->oportunidad()->correo_id) && false)
            <div class="blockSendMail" style="max-width: 700px;margin:0 auto;background: #f3f3f3;border: 1px solid #e1e1e1;color: #000;padding: 10px;border-radius: 3px;">
              <fieldset class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">De:</label>
                    </div>
                    <select class="form-control" onchange="$(this).closest('.blockSendMail').find('a.btn').attr('data-pass-value', $(this).val());">
                      <option>Elija el Remitente</option>
                    @foreach(App\User::perfiles($documento->cotizacion()->empresa_id) as $r)
                      <option value="{{ $r->id }}">{{ $r->cargo }}</option>
                    @endforeach
                    </select>
                  </div>
                </fieldset>
              <table>
                <tr>
                  <th>Para:</th>
                  <td>{{ $documento->cotizacion()->oportunidad()->correo()->correo_desde }}</td>
                </tr>
              </table>
              <div class="text-center">
                <i>En el correo se adjuntará este expediente recién elaborado, puede que demore un minuto en llegar a tu correo.</i><br>
                <a class="btn btn-secondary text-white" data-confirm data-button-dinamic href="/documentos/{{ $documento->id }}/expediente/enviarPorCorreo" class="btn btn-sm btn-dark">Envíar por Correo Eléctronico</a>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
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
    function cancelarProceso(e){
        e.preventDefault();
           if(confirm("¿ Esta segur@ de cancelar el procesado ?")){
                let id = e.target.dataset.id;
                let url = `/documentos/${id}/expediente/cancelar_proceso`;
                let a = document.createElement("a");
                a.href = url;
                a.click(); 
           } 
             
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
