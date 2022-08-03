<div class="card-body">
  <h5 class="card-title">Editar orden</h5>
  <form class="form" action="{{ route('ordenes.update', compact('orden')) }}" method="POST">
    {!! method_field('PUT') !!}
    @include('orden.form')
  </form>
</div>
