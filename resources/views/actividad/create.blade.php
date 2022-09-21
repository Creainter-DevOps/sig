<div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Historial</h4>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>
                <i class="bx bx-dots-vertical-rounded" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo=LLAMADA&{!! http_build_query($into) !!}">+ Llamada</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo=REUNION&{!! http_build_query($into) !!}">+ Reunión</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo=ACTIVIDAD&{!! http_build_query($into) !!}">+ Actividad</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo=VISITA&{!! http_build_query($into) !!}">+ Visita</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo=NOTA&{!! http_build_query($into) !!}">+ Nota</a>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-content collapse show">
            <ul class="widget-timeline" id="timeline" style="height: 415px;overflow: auto;"></ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@section('page-styles')
@parent
<style>
.timeline-item {
    font-family: "IBM Plex Sans", Helvetica, Arial, serif !important;
  background: #f3f3f3;
  border: 1px solid #e5e5e5;
  color: #000;
  padding: 5px;
  margin: 0;
  border-radius: 3px;
  margin-bottom: 5px;
  border-left: 5px solid rgb(90, 141, 238);
  padding: 3px 5px;
  font-size: 11px;
}
.timeline-item > .timeline-time {
  background: transparent!important;
  font-size: 10px!important;
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
.widget-timeline li .timeline-title {
  margin-bottom: 0;
  font-size: 13px;
}
.widget-timeline li .timeline-text {
  margin-bottom: 0;  
}
.timeline-actions {
  float: right;
  margin-top: -14px;
  margin-right: 5px;
  font-size: 11px;
}
.timeline-user{
    position: absolute;
    color: #636364;
    font-size: 12px;
    right: 5px;
    bottom: 0;
    margin: 0;
}
</style>
@endsection

@section('page-scripts')
  @parent
  <script src="{{ asset('js/scripts/pages/app-invoice.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
  <script type="module" src="{{asset('vendors/js/calendar/moment.js')}}"></script>
  <script>
function actualizar_timeline() {
  moment.locale('es');
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
        
        box.css({'padding': '5px'});
        if(n.importancia == 1) {
          box.css({'border-left': '5px solid #5a8dee'});
        } else if(n.importancia == 2) {
          box.css({'border-left': '5px solid #38da8a'});
        } else if(n.importancia == 3) {
          box.css({'border-left': '5px solid #ff5b5c'});
        }

          var html = `<div class="timeline-time">${ moment( n.created_on ).fromNow() + ` ( ${moment(n.created_on).format('DD/MM/YYYY hh:MM:ss a') } ) `}</div>
                      <h6 class="timeline-title">${n.texto}</h6>
                      <p class="timeline-text">${ n.descripcion}</p>
                      <p class="timeline-user" ><i style="font-size:inherit;" class="bx bxs-user"></i> ${n.usuario } </p>`;
          box.append(html);

        if(n.estado ) {
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

