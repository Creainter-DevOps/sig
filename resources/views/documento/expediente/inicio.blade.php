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
            <div class="wizard-horizontal">
                <div class="row" style="display:flex;justify-content:center;" >
                      <div class="col-4 col-sm-4">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom d-flex justify-content-between align-items-center" style="flex-direction: column;" >
                            @if(!empty($documento->oportunidad_id))
                            <h2 class="card-title d-flex">
                              {{ $documento->oportunidad()->rotulo }}
                            </h4>
                            @else
                            <h2 class="card-title d-flex">
                              Expediente Virtual
                            </h4>
                            @endif
                          </div>
                          <br/>
                          <table>
                          <tr>
                            <th>Elaborado desde:</th>
                            <td>{{ Helper::fecha($documento->elaborado_desde, true) }}</td>
                          </tr>
                          <tr>
                            <th>Elaborado hasta:</th>
                            <td>{{ Helper::fecha($documento->elaborado_hasta, true) }}</td>
                          </tr>
                            <th>Elaborado Por:</th>
                            <td>{{ Auth::user()->byId($documento->elaborado_por) }}</td>
                          </tr>
                          <tr>
                            <th>Procesado desde:</th>
                            <td>{{ Helper::fecha($documento->procesado_desde, true) }}</td>
                          </tr>
                          <tr>
                            <th>Procesado hasta:</th>
                            <td>{{ Helper::fecha($documento->procesado_hasta, true) }}</td>
                          </tr>
                          <tr>
                            <th>Procesado Por:</th>
                            <td>{{ Auth::user()->byId($documento->finalizado_por) }}</td>
                          </tr>
                          </table>
                          <hr>
                          @if(empty($documento->finalizado_el))
                          <form class="form" action="{{ route('documento.expediente_inicio_store', ['documento' => $documento->id])}}" method="post">
                            @csrf
                          <div style="display:flex;justify-content:center;">
                            <button class="btn btn-primary text-white" type="submit" id="save" data-confirm>Iniciar Expediente</button>
                          </div><br />
                          <div>Si actualmente cuenta con un expediente en desarrollo, esta acción borrará todo lo avanzado.</div>
                          </form>
                          <hr>
                          @endif
                          <div>
                            @include('actividad.create', [
                              'into' => [
                                'documento_id' => $documento->id
                              ]
                            ])
                            </div>
                        </div>
                      </div>
                      @if (!empty($documento->elaborado_step))
                      <div class="col-8">
                        <div>
                          @if(!empty($documento->finalizado_el))
                            @if(!empty($documento->revisado_el))
                              @if($documento->revisado_status)
                              <div style="font-size: 27px;color: #fd4f1b;">Expediente APROBADO por {{ Auth::user()->byId($documento->revisado_por) }}</div>
                              <div>Puede volver a editar el expediente en caso se requiera:</div>
                              <div style="padding: 10px 0px;">
                                <a data-button-dinamic href="{{ route('documento.expediente_reanudar', ['documento' => $documento->id])}}" class="btn btn-warning text-white btn-sm" style="margin-right: 5px;">Habilitar Edición</a>
                              </div>
                              @else
                              <div style="font-size: 27px;color: #fd4f1b;">Expediente OBSERVADO por {{ Auth::user()->byId($documento->revisado_por) }}</div>
                              <div>Puede revisar el motivo de la observación en el cuadro izquierdo:</div>
                              <div style="padding: 10px 0px;">
                                <a data-button-dinamic href="{{ route('documento.expediente_reanudar', ['documento' => $documento->id])}}" class="btn btn-warning text-white btn-sm" style="margin-right: 5px;">Habilitar Edición</a>
                              </div>
                              @endif
                            @else
                        <div>
                          <div style="font-size: 27px;color: #fd4f1b;">Expediente pendiente de revisión</div>
                          <div>Es necesario realizar la revisión del expediente antes de continuar:</div>
                          <div style="padding: 10px 0px;width:300px;">
                            <div class="row">
                              <div class="col-6">
                                <a data-button-dinamic data-confirm-input="¿Por qué desea Observarlo?" href="{{ route('documento.expediente_observar', ['documento' => $documento->id])}}" class="btn btn-danger text-white" style="margin-right: 5px;">Observar</a>
                              </div>
                              <div class="col-6">
                                <a data-button-dinamic href="{{ route('documento.expediente_aprobar', ['documento' => $documento->id])}}" class="btn btn-success text-white" style="margin-right: 5px;">Aprobar</a>
                              </div>
                            </div>
                          </div>
                        </div>
                            @endif
                          @else
                            <div style="font-size: 27px;color: #fd4f1b;">Continuar trabajando</div>
                            <div>El expediente se encuentra disponible para continuar trabajando:</div>
                            <div style="padding: 10px 0px;">
                              <a href="/documentos/{{ $documento->id }}/expediente/paso0{{ min(3, $documento->elaborado_step) }}" class="btn btn-primary text-white btn-sm" style="margin-right: 5px;">Seguir Trabajando</a>
                            </div>
                          @endif
                        </div>
                        <div class="blockProcess">
              <div style="font-size: 30px;text-align: center;color: #8b5bff;">
                Se está procesando {{ $documento->folio }} páginas, tiempo estimado:
                <div data-time-left="{{ strtotime($documento->procesado_desde) + ((int) ($documento->folio * 9.78)) - time() }}"></div>
              </div>
              <div class="blockLog"></div>
            </div>
            <div class="blockEndProcess">
              <div style="background: #efefef;border: 1px solid #d5d5d5;border-radius: 5px;padding: 5px;">
                <iframe  class="doc" src='https://storage.googleapis.com/creainter-peru/storage/{{ $documento->archivo }}' frameborder='0' style="height:600px;">
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
                  @if(!empty($documento->revisado_status))
                  @if(!empty($documento->cotizacion_id))
                  @if(empty($documento->cotizacion()->propuesta_el))
                    <a class="btn btn-secondary text-white" data-confirm data-button-dinamic href="/cotizaciones/{{ $documento->cotizacion()->id }}/registrarPropuesta" class="btn btn-sm btn-dark">Marcar como Enviado</a>
                  @else
                    Ya se ha registrado el Envio:<br /> {{ Helper::fecha($documento->cotizacion()->propuesta_el, true) }} por {{ Auth::user()->byId($documento->cotizacion()->propuesta_por) }}
                  @endif
                  @endif
                  @endif
                  </div>
                </div>
              </div>
            </div>
            @if(!empty($documento->cotizacion_id) && !empty($documento->cotizacion()->oportunidad()->correo_id) && false)
            <div class="blockSendMail" style="max-width: 700px;margin:0 auto;background: #f3f3f3;border: 1px solid #e1e1e1;color: #000;padding: 10px;border-radius: 3px;">
              <fieldset class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">De:</label>
                    </div>
                    <select class="form-control" onchange="$(this).closest('.blockSendMail').find('a.btn').attr('data-pass-value', $(this).val());">
                      <option>Elija el Remitente</option>
                    @foreach(App\User::perfiles($documento->cotizacion()->empresa_id) as $r)
                      <option value="{{ $r->id }}">{{ $r->cargo }} ({{ $r->correo }})</option>
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
                <a class="btn btn-secondary text-white" data-confirm data-button-dinamic href="/cotizaciones/{{ $documento->cotizacion_id }}/enviarPorCorreo" class="btn btn-sm btn-dark">Envíar por Correo Eléctronico</a>
              </div>
            </div>
            @endif

                      </div>
                      @endif
                </div>
                <!--demo-->
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
parallelStatus();</script>
@endsection
