
@extends('layouts.contentLayoutMaster')
@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
          @if(session()->has('message'))
          <div class="alert alert-success">
              {{ session()->get('message') }}
          </div>
          @endif
          <div class="block">
              <div class="block-header block-header-default">
                  <h3 class="block-title">Nueva empresa</h3>
              </div>
              <div class="block-content">
                  <form action="/clientes" method="POST" class="form-horizontal">
                      @include('empresas.form')
                  </form>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- TODO: Current Tasks -->
@endsection
