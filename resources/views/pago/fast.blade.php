<div class="card-body">
  <h5 class="card-title">Nuevo Pago</h5>
  <form class="form" action="{{ route('pagos.store')}}" method="post">
    @include('pago.form')
  </form>
</div>
