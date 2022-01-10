<div class="card-body">
  <h5 class="card-title">Nuevo Gasto</h5>
  <form class="form" action="{{ route('gastos.store')}}" method="post">
    @include('gasto.form')
  </form>
</div>
