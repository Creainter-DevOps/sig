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
                            <div>
                            @include('actividad.create', [
                              'into' => [
                                'documento_id' => $documento->id
                              ]
                            ])
                            </div>
                      </div>
                      @if (!empty($documento->elaborado_step))
                      <div class="col-8">
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

            </div>
                      </div>
                      @endif
                </div>
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
