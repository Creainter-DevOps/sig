<div class="card-body">
  <h5 class="card-title">Editar Entregable</h5>
  <form class="form" action="{{ route('entregables.update', compact('entregable')) }}" method="POST">
    {!! method_field('PUT') !!}
    @include('entregable.form')
  </form>
</div>
