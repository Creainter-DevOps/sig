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
    <button type="button" class="btn btn-success" data-popup="/actividades/crear?tipo=NOTA&{!! http_build_query($into) !!}">
    <i class="bx bx-plus"></i> Nota
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
  background: #f3f3f3;
  border: 1px solid #e5e5e5;
  color: #000;
  padding: 0!important;
  margin: 0;
  border-radius: 3px;
  margin-bottom: 5px;
}
.timeline-item > .timeline-time {
  background: transparent!important;
  font-size: 11px!important;
}
.timeline-item > .timeline-content {
  background: transparent!important;
  padding: 5px 10px!important;
}
.kanban-drag {
  min-height: 400px!important;
}
.kanban-item[data-is_linked=true] {
  border-right: 5px solid #8fa4b9;
}
.timeline-actions {
  float: right;
  margin-top: -14px;
  margin-right: 5px;
  font-size: 11px;
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

        if(n.importancia == 1) {
          box.css({'border-left': '5px solid #5a8dee'});
        } else if(n.importancia == 2) {
          box.css({'border-left': '5px solid #38da8a'});
        } else if(n.importancia == 3) {
          box.css({'border-left': '5px solid #ff5b5c'});
        }

        if(n.tipo == 'LLAMADA') {
          box.append($('<div>').addClass('timeline-time').text(n.fecha + ' ' + n.hora));
          box.append($('<div>').addClass('timeline-content').html('<div>LLAMADA A <b>' + n.contacto_nombres + '</b>: ' + n.texto + '</div>'));
          box.find('.timeline-content>div').append('<div style="max-width: 450px;max-height: 100px;overflow: hidden;">' + n.contenido + '</div>');
          box.append($('<div>').addClass('timeline-actions')
            .append($('<a>').attr('href', 'javascript:void(0)').attr('data-popup', '/actividades/' + n.id + '/editar').text('Ver más'))
          );

        } else if(n.tipo == 'REUNION') {
          box.append($('<div>').addClass('timeline-time').text(n.fecha + ' ' + n.hora));
          box.append($('<div>').addClass('timeline-content').text(n.texto));
          box.find('.timeline-content>div').append('<div style="max-width: 450px;max-height: 100px;overflow: hidden;">' + n.contenido + '</div>');
          box.append($('<div>').addClass('timeline-actions')
            .append($('<a>').attr('href', 'javascript:void(0)').attr('data-popup', '/actividades/' + n.id + '/editar').text('Ver más'))
          );

        } else if(n.tipo == 'ACTIVIDAD') {
          box.append($('<div>').addClass('timeline-time').text(n.fecha + ' ' + n.hora));
          box.append($('<div>').addClass('timeline-content').html('<div>ACTIVIDAD : ' + n.texto + '</div>'));
          box.find('.timeline-content>div').append('<div style="max-width: 450px;max-height: 100px;overflow: hidden;">' + n.contenido + '</div>');
          box.append($('<div>').addClass('timeline-actions')
            .append($('<a>').attr('href', 'javascript:void(0)').attr('data-popup', '/actividades/' + n.id + '/editar').text('Vér más'))
          );

        } else if(n.tipo == 'NOTA') {
          box.append($('<div>').addClass('timeline-time').text(n.fecha + ' ' + n.hora));
          box.append($('<div>').addClass('timeline-content').html('<div>NOTA : ' + n.texto + '</div>'));
          box.find('.timeline-content>div').append('<div style="max-width: 450px;max-height: 100px;overflow: hidden;">' + n.contenido + '</div>');
          box.append($('<div>').addClass('timeline-actions')
            .append($('<a>').attr('href', 'javascript:void(0)').attr('data-popup', '/actividades/' + n.id + '/editar').text('Ver más'))
          );

        } else if(n.tipo == 'VISITA') {
          box.append($('<div>').addClass('timeline-time').text(n.fecha + ' ' + n.hora));
          box.append($('<div>').addClass('timeline-content').text(n.texto));
          box.find('.timeline-content>div').append('<div style="max-width: 450px;max-height: 100px;overflow: hidden;">' + n.contenido + '</div>');
          box.append($('<div>').addClass('timeline-actions')
            .append($('<a>').attr('href', 'javascript:void(0)').attr('data-popup', '/actividades/' + n.id + '/editar').text('Ver más'))
          );
        }
        if(n.estado == 3) {
          ll.append(box);
        } else {
          llc.append(box);
        }
      });
      render_dom_popup();
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

