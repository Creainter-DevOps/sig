<div class="card-body">
  <h5 class="card-title">Nueva Orden</h5>
  <form class="form" action="{{ route('ordenes.store')}}" method="post">
    @include('orden.form')
  </form>
</div>
