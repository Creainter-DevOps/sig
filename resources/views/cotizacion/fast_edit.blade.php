<div class="card-body">
  <h5 class="card-title">Editar Cotización</h5>
  <form class="form" action="{{ route('cotizaciones.update', ['cotizacion' => $cotizacion->id ])}}" method="post">
    {!! method_field('PUT') !!}
    @include('cotizacion.form')
  </form>
</div>
