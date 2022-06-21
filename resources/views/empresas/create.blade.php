
@extends('layouts.contentLayoutMaster')
@section('title','Nueva empresa')
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
              <!--<div class="block-header block-header-default">
                  <h3 class="block-title">Nueva empresa</h3>
              </div>-->
              <div class="block-content">
                  <form action="/empresas" method="POST" class="form-horizontal form-data" id="" >
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
@section('page-scripts')
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
@endsection
