<div class="card-body">
  <h5 class="card-title">Nueva acta</h5>
  <form class="form" action="{{ route('actas.store')}}" method="POST">
    @include('acta.form')
  </form>
</div>
