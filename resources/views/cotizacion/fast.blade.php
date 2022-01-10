<div class="card-body">
  <h5 class="card-title">Nueva Cotización</h5>
  <form class="form" action="{{ route('cotizaciones.store')}}" method="post">
    @include('cotizacion.form')
  </form>
</div>
