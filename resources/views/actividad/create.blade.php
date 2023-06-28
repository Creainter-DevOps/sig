@php
$uid = uniqid();
@endphp
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Historial</h4>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>
                <i class="bx bx-dots-vertical-rounded" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo_id=2&{!! http_build_query($into) !!}">+ Llamada</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo_id=6&{!! http_build_query($into) !!}">+ Reunión</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo_id=4&{!! http_build_query($into) !!}">+ Actividad</a>
                  <a class="dropdown-item" href="#" data-popup="/actividades/crear?tipo_id=5&{!! http_build_query($into) !!}">+ Nota</a>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-content collapse show">
            <ul class="widget-timeline" id="timeline{{ $uid }}" style="height: 415px;overflow: auto;"></ul>
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
  <script>
  $(document).ready(function() {
    actualizar_timeline($('#timeline{{ $uid }}'), {!! json_encode($into) !!});
  });
</script>
@endsection

