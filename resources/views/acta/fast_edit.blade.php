<div class="card-body">
  <h5 class="card-title">Editar acta </h5>
  <form class="form" action="{{ route('actas.update', compact('acta')) }}" method="POST">
    {!! method_field('PUT') !!}
    @include('acta.form')
  </form>
</div>
