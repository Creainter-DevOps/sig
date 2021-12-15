<div class="card-body">
  <h5 class="card-title">Editar Pago</h5>
  <form class="form" action="{{ route('pagos.update', compact('pago')) }}" method="POST">
    {!! method_field('PUT') !!}
    @include('pago.form')
  </form>
</div>
