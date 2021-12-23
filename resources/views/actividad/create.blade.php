<div class="text-center">
<div class="btn-group">
  <button type="button" class="btn btn-primary" data-popup="/actividades/crear?tipo=LLAMADA&{!! http_build_query($into) !!}">
    <i class="bx bx-plus"></i> Llamada
  </button>
  <button type="button" class="btn btn-success" data-popup="/actividades/crear?tipo=REUNION&{!! http_build_query($into) !!}">
    <i class="bx bx-plus"></i> Reunión
  </button>
  <button type="button" class="btn btn-danger" data-popup="/actividades/crear?tipo=ACTIVIDAD&{!! http_build_query($into) !!}">
    <i class="bx bx-plus"></i> Actividad
  </button>
  <button type="button" class="btn btn-info" data-popup="/actividades/crear?tipo=VISITA&{!! http_build_query($into) !!}">
    <i class="bx bx-plus"></i> Visita
  </button>
</div>
</div><br />
<div>
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Programadas</h4>
          <ul class="widget-timeline" id="timeline-cron"></ul>
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Realizadas</h4>
          <ul class="widget-timeline" id="timeline"></ul>
        </div>
      </div>
    </div>
  </div>
</div>
@section('page-styles')
<style>
.timeline-item {
  margin: 0;
  color: #fff;
  padding: 4px!important;
  border-radius: 3px;
  margin-bottom: 5px;
}
.timeline-item > .timeline-time {
  background: transparent!important;
  color: #fff!important;
  font-size: 11px!important;
}
.timeline-item > .timeline-content {
  background: transparent!important;
}
.kanban-drag {
  min-height: 400px!important;
}
.kanban-item[data-is_linked=true] {
  border-right: 5px solid #8fa4b9;
}
</style>
@endsection

@section('page-scripts')
<script>
function actualizar_timeline() {
  var ll = $('#timeline');
  var llc = $('#timeline-cron');
  Fetchx({
    url: '/actividades/timeline',
    type: 'POST',
    dataType: 'JSON',
    data: {!! json_encode($into) !!},
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    success: function(data) {
      ll.empty();
      llc.empty();
      $.each(data, function(y, n) {
        let box = $('<li>').addClass('timeline-items timeline-icon-success active timeline-item');
        box.attr('data-tipo', n.tipo);
        if(n.tipo == 'LLAMADA') {
          box.css({'background': '#5a8dee'});
        } else if(n.tipo == 'REUNION') {
          box.css({'background': '#38da8a'});
        } else if(n.tipo == 'ACTIVIDAD') {
          box.css({'background': '#ff5b5c'});
        } else if(n.tipo == 'VISITA') {
          box.css({'background': '#03cedd'});
        }

        box.append($('<div>').addClass('timeline-time').text(n.created_on));
        box.append($('<div>').addClass('timeline-content').text(n.texto));
        if(n.realizado) {
          ll.append(box);
        } else {
          llc.append(box);
        }
      });
    },
    error: function() {
      //
    }
  });
}
$(document).ready(function() {
  actualizar_timeline();
});
</script>
@endsection

