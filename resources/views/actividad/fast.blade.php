<div class="card-body">
  <form class="form" action="{{ route('actividades.store') }}" method="post">
    @if($tipo == 'LLAMADA')
      @include('actividad.form-llamada')
    @else
      @include('actividad.form-reunion')
    @endif
  </form>
</div>
