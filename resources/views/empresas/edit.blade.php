@extends('layouts.contentLayoutMaster')

@section('content')

<div class="col-12">
  <div class="card">
    <div class="card-content">
        @if(session()->has('message'))
      <div class="card-header">
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
      </div>
        @endif
      <div class="card-body">
          <div class="block-header block-header-default">
              <h3 class="block-title">Datos Personales</h3>
          </div>
          <div class="block-content">
              <form action="/empresas/{{ $empresa->id }}" method="POST" class="form-horizontal">
                  {!! method_field('PUT') !!}
                  @include('empresas.form')
              </form>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- TODO: Current Tasks -->
@endsection
