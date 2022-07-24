<div class="card-body">
  <h5 class="card-title">Editar Gasto</h5>
  <form class="form" action="{{ route('gastos.update', compact('gasto')) }}" method="POST">
    {!! method_field('PUT') !!}
    @include('gasto.form')
  </form>
</div>
