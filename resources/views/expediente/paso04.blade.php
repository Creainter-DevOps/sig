@extends('expediente.theme')
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
                <a class="nav-link" href="/expediente/{{ $cotizacion->id }}/paso03">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/expediente/{{ $cotizacion->id }}/paso04">
                  Magia
                </a>
              </li>
            </ul>
            <div class="blockProcess">
              <div style="font-size: 30px;text-align: center;color: #8b5bff;">Se está procesando el documento</div>
              <div class="blockLog"></div>
            </div>
            <div class="blockEndProcess">
              <div style="background: #efefef;border: 1px solid #d5d5d5;border-radius: 5px;padding: 5px;">
                <iframe  class="doc" src='https://sig.creainter.com.pe/storage/{{ $workspace['documento_final'] }}' frameborder='0' style="height:500px;">
                This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
              </div>
              <div class="text-center" style="padding:10px;">
                <a class="btn btn-primary text-white" data-url-download target="_blank"> Propuesta 
                  <i class="bx bxs-download" ></i>
                  </a>
                <a class="btn btn-secondary text-white" data-url-download-seace target="_blank"> Propuesta SEACE
                  <i class="bx bxs-download" ></i>
                </a>
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
  let url = '/expediente/{{ $cotizacion->id }}/parallelStatus';
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
      $(".blockEndProcess").find('[data-url-download]').attr('href', res.data.url);
      $(".blockEndProcess").find('[data-url-download-seace]').attr('href', res.data.url_seace);
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
