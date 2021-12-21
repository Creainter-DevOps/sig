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
        let box = $('<li>').addClass('timeline-items timeline-icon-success active');
        box.append($('<div>').addClass('timeline-time').text(n.created_on));
        box.append($('<div>').addClass('timeline-content').text(n.texto));
        if(n.completed) {
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

