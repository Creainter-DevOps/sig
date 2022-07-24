@extends('documento.theme')
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
<section id="icon-tabs">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
              <li class="nav-item">
                <a class="nav-link " href="/documentos/{{ $documento->id }}/expediente/paso01">
                  Mesa de Trabajo
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/documentos/{{ $documento->id }}/expediente/paso02">
                  Magia
                </a>
              </li>
            </ul>
            @include('documento.procesando', compact('documento','workspace','cotizacion'))
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
