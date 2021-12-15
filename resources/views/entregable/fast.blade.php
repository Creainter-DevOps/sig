<div class="card-body">
  <h5 class="card-title">Nuevo Entregable</h5>
  <form class="form" action="{{ route('entregables.store')}}" method="POST">
    @include('entregable.form')
  </form>
</div>
