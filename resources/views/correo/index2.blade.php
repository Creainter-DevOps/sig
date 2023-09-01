@extends('layouts.contentLayoutMaster')
@section('title','Correos')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.snow.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
@endsection
@section('content')
<div>
<div style="margin-bottom:5px;">
  <a href="/correos/crear" class="btn btn-primary">Nuevo Correo</a>
</div>
<div class="row">
  <div class="col" style="max-width:300px;padding:0 10px;">
<ul class="list-group list-hover">
@foreach(App\Correo::buzones() as $b)
<li class="list-group-item d-flex justify-content-between align-items-center" onclick="javascript:mail_account({{ $b->id }});">
{{ substr($b->usuario, 0, 20) }}
@if(!empty($b->noleidos))
<span class="badge bg-label-primary">{{ $b->noleidos }}</span>
@endif
</li>
@endforeach
</ul>
  </div>
  <div class="col" style="max-width:600px;padding:0 10px;">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <table id="buzones"></table>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div id="ContentMail"></div>
      </div>
    </div>
  </div>
</div>
</div>
<style>
#ContentMail {
  overflow: auto;
  max-height: 600px;
}
</style>
@endsection
@section('vendor-scripts')
<script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
@endsection

@section('page-scripts')
<script>
  var tBuzones = new Tablefy({
            title: 'BUZONES',
            dom: '#buzones',
            height: 480,
            request: {
              url: '/correos/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Fecha',
                width: 80,
                style: {'text-align':'center'},
              },
              {
                name: 'Asunto',
                width: 300
              },
              {
                name: 'Leido',
              },
            ],
            enumerate: true,
            selectable: false,
            contextmenu: false,
            draggable: false,
            sorter: false,
            countSelectable: 0,
            onClick: function(a, b, c) {
              console.log('click', a, b, c);
              mail_content(a);
            }
        });
tBuzones.init(true);
function mail_account(bid) {
  tBuzones.edit({
    request: {
      type: 'POST',
      url: '/correos/tablefy/' + bid,
      headers : {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
    }
  }).refresh(true);
}
function mail_content(cid) {
  $('#ContentMail').html('<div style="text-align:center;">Cargando...</div>');
  $.ajax({
    url: '/correos/' + cid + '/ver',
    type: 'GET',
    success: function(res) {
      console.log('res', res);
      $('#ContentMail').html(res);
    }
  });
}
</script>
@endsection
