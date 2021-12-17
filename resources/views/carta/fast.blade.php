<div class="card-body">
  <h5 class="card-title">Nueva carta</h5>
  <form class="form" action="{{ route('cartas.store')}}" method="POST">
    @include('carta.form')
  </form>
</div>
