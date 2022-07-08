@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Expediente')
{{-- vendor scripts --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Bucket.css') }}">

<style>
  .SortAnimation{
    width:100%;
  }

  .BlockLayout{
    display:grid;
    grid-template-columns: 1fr  1fr 1fr;
    grid-gap:10px;
  }

  .file{
    background-color: white;
    border: 1px solid red;
    min-height: 120px;
    width: 150px;
    display:flex;
    align-items:end;
    justify-content:center;
  }

  .file p{
    text-align:center;
  }

  img.background_image{
    position: absolute;
    height: auto;
    top: 0;
    width: 100%;
  }

  #ContainerOne .StackedListItem .StackedListContent{
    z-index:9;
  }
  #ContainerOne .StackedListItem{
    list-style :none;
    min-height:180px;
    border:1px solid red;
    cursor:pointer;
    border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    cursor: move;
    overflow:hidden;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: #fff;
    border-radius: 4px;
    margin-right: 25px;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    padding: 10px;
    transition: box-shadow 200ms cubic-bezier(0, 0, 0.2, 1);
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
display:flex;
    align-items:end;
  }

  #ContainerTwo .StackedListItem{
    list-style :none;
    height:160px;
    border:1px solid red;
    min-height: 140px;
    cursor:pointer;
border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    cursor: move;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: #fff;
    border-radius: 4px;
    margin-right: 25px;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    padding: 10px;
    transition: box-shadow 200ms cubic-bezier(0, 0, 0.2, 1);
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
    display:flex;
    align-items:end;
  }
  #ContainerTwo .StackedListItem h4 {
    font-size:15px;
  }

  #MultipleContainers{
    width:100%;
    display:grid;
    grid-template-columns: 1fr 300px;
    min-height: 500px;
  }

  #ContainerTwo .StackedList{
    display:flex;
    flex-direction: column;
    align-items: center;
    grid-gap:15px;
    padding: 0;
  }

  .doc {
    width: 100%;
    height: 100% ;
    max-height: 750px;
  }

  #ContainerOne .StackedList {
    display:grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-gap:15px;
    min-height: 200px;
    padding: 0;
    border: 1px dashed #5030ff;
    margin: 15px;
    padding: 10px;
    border-radius: 10px;
    border-width: 3px;
    padding-bottom: 217px;
  }
  #ContainerTwo .StackedList {
    display:grid;
    grid-template-columns: 1fr;
    border: 1px dashed #0689f9;
    padding: 10px;
    border-radius: 10px;
    border-width: 3px;
    padding-bottom: 50px;
    overflow: auto;
    max-height: 650px;
  }

  #ContainerOne .StackedListContent .Heading {
    color: #dfe3e7;
    background-color: #1a233a;
    width: 100%;
    padding: 1px 4px;
    border-radius: 5px;
    margin-top: 2px;
  }
  .BloqueBusqueda {
    max-height: 100%;
    overflow: auto;
  }
  .BloqueBusqueda > .StackedListItem {
     max-height: 60px;
  }
.boxDraggable {
    list-style: none;
    cursor: pointer;
    position: relative;
    border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    border-radius: 4px;
    padding: 5px;
    background: #fff;
    transition: box-shadow 200ms cubic-bezier(0, 0, 0.2, 1);
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
    padding-bottom: 15px;
}
.boxDraggable .tools {
    position: absolute;
    top: 3px;
    right: 3px;
    background: rgb(0 0 0 / 32%);
    border-radius: 3px;
    padding: 2px 10px;
    font-size: 11px;
    color: #fff;
}
.boxDraggable[data-plantilla='true'] {
    background-color: #ffebd0;
    color: #000;
    border: 1px solid #ffd49a;
}
.boxDraggable[data-tipo='CONTRATO'] {
}
.boxDraggable[data-tipo='CONTRATO'] .CardContentTitulo {
    font-size: 11px;
    text-align: center;
}

.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc01 {
    text-align: center;
    font-size: 12px;
}
.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc01 {
    text-align: center;
    font-size: 12px;
}

.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc02 {
position: absolute;
    bottom: 0;
    left: 0;
    font-size: 11px;
    padding-left: 20px;
    padding-bottom: 2px;
}
.boxDraggable[data-tipo='CONTRATO'] .CardContentDesc03 {
position: absolute;
    bottom: 0;
    right: 0;
    font-size: 11px;
    padding-right: 20px;
    padding-bottom: 2px;
}
.draggable-container--is-dragging {
  background: #fbf4ff;
}
.draggable-source--is-dragging {
    background: #ffffff !important;
    border: 1px dashed #00cd07 !important;
    border-width: 2px !important;
}
.draggable-source--is-dragging > * {
  display: none;
}
[data-tools] , [data-remove] {
    cursor: pointer;
    display: inline-block;
    padding: 5px 20px;
    margin: 2px 5px;
    background: #fff;
    color: black;
    text-align: center;
    border-radius: 5px;
}

.contentPoint {
  position:relative;
}
.contentPoint.activePoint .puntero {
  display:block!important;
}
.contentPoint .puntero {
  display: none;
  position: absolute;
  z-index: 999;
  top: 0;
  left: 0;
  width: 25px;
  height: 25px;
  background: #00e707;
}
.contentPoint .estampado[data-tipo='firma'] {
  position: absolute;
  z-index: 999;
  width: 50px;
  height: 50px;
  background: #ff7600;
}
.contentPoint .estampado[data-tipo='visado'] {
  position: absolute;
  z-index: 999;
  width: 50px;
  height: 50px;
  background: #188aff;
}
.folio {
  padding: 2px 6px ;
  width:max-content;
  color:white;
  font-size: 15px;
  border-radius: 5px;
  background-color: orange ;
}

.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/widgets.css')}}">
@endsection
@section('content')
<!-- Form wizard with number tabs section end -->
<!-- Form wizard with icon tabs section start -->
<section id="icon-tabs">
  <div class="row">
    @if(!empty($cotizacion->oportunidad()->licitacion_id))
    <div class="col-6">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @include('licitacion.table', ['licitacion' => $cotizacion->oportunidad()->licitacion()])
          </div>
        </div>
      </div>
      </div>
      <div class="col-6">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                @include('licitacion.cronograma', ['licitacion'=> $cotizacion->oportunidad()->licitacion()])
              </div>
            </div>
          </div>
      </div>
      @endif
      <div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('oportunidad.table', ['oportunidad' => $cotizacion->oportunidad()])
        </div>
      </div>
    </div>
      </div>
      <div class="col-6">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('cotizacion.table', ['cotizacion'=> $cotizacion])
        </div>
      </div>
    </div>
      </div>
    </div>

@yield('contenedor')
</section>
  </div>
  </div>
</section>
<!-- Widgets Charts End -->
@endsection
@section('page-scripts')
  <script src="{{ asset('js/Bucket.js') }}"></script>
@endsection
