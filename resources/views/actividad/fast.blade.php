<div class="card-body">
  <form class="form" action="{{ route('actividades.store') }}" method="post">
    <input type="hidden" name="proyecto_id" value="{{ $actividad->proyecto_id }}">
    <input type="hidden" name="tipo" value="{{ $actividad->tipo }}">
    @if($tipo == 'LLAMADA')
      @include('actividad.form-llamada')
    @else
      @include('actividad.form-reunion')
    @endif
  </form>
</div>
