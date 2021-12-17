<div class="card-body">
  <h5 class="card-title">Editar carta </h5>
  <form class="form" action="{{ route('cartas.update', compact('carta')) }}" method="POST">
    {!! method_field('PUT') !!}
    @include('carta.form')
  </form>
</div>
