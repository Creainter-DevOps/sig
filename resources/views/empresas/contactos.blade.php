@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Contactos')
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<section class="users-view">
  <div class="row">
    <div class="col-12 col-sm-7">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h4 class="media-heading"><span>{{ $empresa->razon_social }}</span></h4>
          <span>RUC:</span>
          <span class="users-view-id">{{ $empresa->ruc }}</span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
  @foreach($empresa->contactos() as $c)
    <div class="col-3 col-sm-3">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
          <div><b>{{ $c->nombres }} {{ $c->apellidos }}</b></div>
          <div>{{ $c->area }}</div>
          <div>{{ $c->celular }}</div>
          <div>{{ $c->llamadas }} llamadas registradas.</div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  </div>
  </div>
</section>
@endsection
@section('page-scripts')
@endsection
