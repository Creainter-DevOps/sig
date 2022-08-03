@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Mis empresas')
{{-- page-styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-knowledge-base.css')}}">
@endsection
@section('content')
<!-- Knowledge base Jumbotron start -->
<section class="kb-search">
  <div class="row">
    <div class="col-12">
      <div class="card bg-transparent shadow-none kb-header">
        <div class="card-content">
          <div class="card-body text-center">
            <h1 class=" mb-2 kb-title">Mis empresas</h1>
            <!--<p class=" mb-3">
              Algolia helps businesses across industries quickly create relevant, scalable, and lightning fast search
              and discovery experiences.
            </p>
            <form>
              <fieldset class="form-group position-relative w-50 mx-auto kb-search-width">
                <input type="text" class="form-control form-control-lg round pl-2" id="searchbar"
                  placeholder="Find from talk..">
                <button class="btn btn-primary round position-absolute d-none d-sm-block" type="button">Search</button>
                <button class="btn btn-primary round position-absolute d-block d-sm-none" type="button"><i
                    class="bx bx-search"></i></button>
              </fieldset>
            </form>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Knowledge base Jumbotron ends -->
<!-- Knowledge base start -->
<section class="kb-content">
  <div class="row kb-search-content-info mx-1 mx-md-2 mx-lg-5">
    <div class="col-12">
      <div class="row match-height">
        @foreach ( $empresas as $empresa )
        <div class="col-md-4 col-sm-6 kb-search-content">
          <div class="card kb-hover-1">
            <div class="card-content">
              <div class="card-body text-center">
                <a href="/misempresas/{{$empresa->id}}">
                  <div class=" mb-1">
                   @if (!isset($empresa->logo_head)) 
                    <i class="livicon-evo"
                      data-options="name: users.svg; size: 50px; strokeColorAlt: #FDAC41; strokeColor: #5A8DEE; style: lines-alt; eventOn: .kb-hover-1;"></i>
                   @else 
                      <img src="{{ config('constants.ruta_cloud') .  $empresa->logo_head }}" style="max-width:100%; max-height:60px; "/>
                   @endif   
                  </div>
                  <h5>{{ $empresa->razon_social }}</h5>
             <!--     <p class=" text-muted">But students more often neglect fact it is much more</p>-->
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<!-- Knowledge base ends -->
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-knowledge-base.js')}}"></script>
@endsection
