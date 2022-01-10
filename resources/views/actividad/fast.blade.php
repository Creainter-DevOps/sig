<div class="card-body">
@if(!empty($actividad->id))
  <form class="form" action="{{ route('actividades.update', ['actividad' => $actividad->id]) }}" method="post">
  @method('PUT')
@else
  <form class="form" action="{{ route('actividades.store') }}" method="post">
@endif
    <input type="hidden" name="proyecto_id" value="{{ $actividad->proyecto_id }}">
    <input type="hidden" name="tipo" value="{{ $actividad->tipo }}">
    @if($tipo == 'LLAMADA')
      @include('actividad.form-llamada')
    @elseif($tipo == 'NOTA')
      @include('actividad.form-nota')
    @else
      @include('actividad.form-reunion')
    @endif
  </form>
</div>
