@extends('layouts.contentLayoutMaster')
@section('title','Correos')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.snow.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
<style>
.snow-container * {
  border: none!important;
}
</style>
@endsection
@section('content')
<div>
    <div class="card shadow-none quill-wrapper p-0">
      <div class="card-header">
        <h3 class="card-title" id="emailCompose">Responder Correo</h3>
      </div>
      <form action="{{ route('correos.responder_store', $correo->id) }}" method="POST" id="compose-form" enctype="multipart/form-data">
      @csrf
        <div class="card-content">
          <div class="card-body pt-0">
            <div class="form-group pb-50">
              <label for="emailfrom">Desde</label>
              <select name="perfil_id" class="form-control">
@foreach(App\User::perfiles(null, null, $correo->correo_hasta) as $r)
                <option value="{{ $r->id }}">{{ $r->cargo }} ({{ $r->correo }})</option>
@endforeach
             </select>
             <div style="font-size: 11px;">Correo recibido en: {{ $correo->correo_hasta }}</div>
            </div>
            <div class="form-group pb-50">
              <label for="emailfrom">Hasta</label>
              <div>{{ $correo->correo_desde }}</div>
            </div>
            <div class="form-label-group">
              <input type="text" name="cc" id="emailCC" class="form-control" placeholder="CC">
              <label for="emailCC">CC</label>
              <div style="font-size: 11px;">Para responder a todos, haga click <a href="#">aquí</a>.</div>
            </div>
            <div class="form-label-group">
              <input type="text" name="asunto" id="emailSubject" class="form-control" placeholder="Asunto" value="RE: {{ $correo->asunto }}">
              <label for="emailSubject">Asunto</label>
            </div>
            <div class="snow-container border rounded p-50 ">
              <div class="compose-editor mx-75"></div>
              <div class="d-flex justify-content-end">
                <div class="compose-quill-toolbar pb-0">
                  <span class="ql-formats mr-0">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                  </span>
                </div>
              </div>
              <textarea name="texto" style="display:none;"></textarea>
            </div>
            <div class="form-group mt-2">
              <div class="custom-file">
                <input type="file" name="adjunto[]" class="custom-file-input" id="emailAttach" multiple>
                <label class="custom-file-label" for="emailAttach">Adjunto</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-end pt-0">
          <button type="reset" class="btn btn-light-secondary cancel-btn mr-1">
            <i class='bx bx-x mr-25'></i>
            <span class="d-sm-inline d-none">Cancelar</span>
          </button>
          <button type="submit" class="btn-send btn btn-primary">
            <i class='bx bx-send mr-25'></i> <span class="d-sm-inline d-none">Responder</span>
          </button>
        </div>
      </form>
      <!-- form start end-->
    </div>
</div>
@endsection
@section('vendor-scripts')
@endsection

@section('page-scripts')
<script src="https://www.adjudica.com.pe/vendors/js/editors/quill/quill.min.js"></script>

  <script>
    var composeMailEditor = new Quill('.compose-editor', {
    modules: {
      toolbar: '.compose-quill-toolbar'
    },
    placeholder: 'Ingrese algo...',
    theme: 'snow'
  });
    composeMailEditor.on('text-change', function() {
      $("textarea[name='texto']").val(composeMailEditor.container.firstChild.innerHTML);
    });
  </script>
@endsection
