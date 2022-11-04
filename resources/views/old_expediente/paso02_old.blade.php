@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Widgets')
{{-- vendor scripts --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<style>
  .SortAnimation{
    width:100%;
  }
  .BlockLayout{
    display:grid;
    grid-template-columns: 150px 150px 150px;
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
  .StackedList{
    
  }
  .StackedListItem{
    width:150px;
    list-style :none;
    height:160px;
    border:1px solid red;
    cursor:pointer;
border: solid 1px #ccc;
    color: rgba(0, 0, 0, 0.87);
    cursor: move;
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
  }
  #MultipleContainers{
    width:100%;
    display:grid;
    grid-template-columns: 1fr 200px; 
    min-height: 500px;
  }
  #ContainerTwo .StackedList{
    display:flex;
    flex-direction: column;
    align-items: center;
    grid-gap:15px;
    padding: 0;
    height: 90%;
  }

  .doc {
    width: 100%;
    height: 100% ;
    min-height: 550px; 
  }

  #ContainerOne .StackedList {
    display:grid;
    grid-template-columns: 150px 150px 150px 150px 150px;  
    grid-gap:15px;
    min-height: 200px;
    padding: 0;
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
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$oportunidad->licitacion()->rotulo}} : {{$entidad->razon_social}} </h4>
        </div>
        <div class="card-content mt-2">
          <div class="card-body">
            <div class="wizard-horizontal">
                <div class="row">
                      <div class="col-6" id="iframe_container" >
                      <iframe  class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src={{$url_document}}' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
                      </div>
                      <div class="col-6">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex">
                              <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Documentos
                            </h4>
                            <ul class="list-inline d-flex mb-0">
                              <li class="d-flex align-items-center">
                                <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                                <div class="dropdown">
                                  <div class="dropdown-toggle mr-1" role="button" id="dropdownMenuButton" data-empresa_id=""  data-toggle="dropdown"
                                     aria-expanded="false"> {{ $empresa->razon_social }} </div>
                                </div>
                              </li>
                            </ul>
                          </div>
<form class="form" action="{{ route('expediente.paso02', ['cotizacion' => $cotizacion->id])}}" method="post">
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                              @foreach ($workspace['paso02'] as $anexo)               
                              @csrf
                              <li class="widget-todo-item" data-id="anexo_1" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <span class="widget-todo-title ml-50">{{$anexo['rotulo'] }}</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1" onclick="visualizar(this)" style="cursor:pointer;" data-url="{{'https://sig.creainter.com.pe/temporales/' . $anexo['ruta'] }}">Word</div>
                                    <div class="avatar bg-rgba-primary m-0 mr-50">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary">RA</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              @endforeach
                            </ul>
                          </div>
                          <button class="btn btn-primary text-white" type="submit" href=""  id="save">Generar</button>
                        </div>
                      </div>
                </div>
              </fieldset>   
              <!-- body content of Step 3 end-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- Form wizard with number tabs section end -->
  <!-- Task App Widget Ends -->
  </div>
  </div>
</section>
<!-- Widgets Charts End -->
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')

<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.12/draggable.bundle.js" integrity="sha512-CY+c7SEffH9ZOj1B9SmTrJa/ulG0I6K/6cr45tCcLh8/jYqsNZ6kqvTFbc8VQA/rl9c2r4QBOx2Eur+2vkVWsA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  const Classes = {
    draggable: 'StackedListItem--isDraggable',
    capacity: 'draggable-container-parent--capacity',
  };

  const containers = document.querySelectorAll('#MultipleContainers .StackedList');

  if (containers.length === 0) {
    //return false;
     console.log("sin contenedores");
  }

  const sortable = new Draggable.Sortable(containers, {
    draggable: `.${Classes.draggable}`,
    mirror: {
      constrainDimensions: true,
    },
    plugins: [Draggable.Plugins.ResizeMirror],
  });

  const containerTwoCapacity = 3;
  const containerTwoParent = sortable.containers[1].parentNode;
  let currentMediumChildren;
  let capacityReached;
  let lastOverContainer;

/*const containers = document.querySelectorAll('#SortAnimation .BlockLayout');
 const sortable  = new Draggable.Sortable( containers, {
        draggable: '.Block--isDraggable',
        mirror: {
          constrainDimensions: true,
        },
        plugins: [Draggable.Plugins.SortAnimation],
        swapAnimation: {
          duration: 300,
          easingFunction: 'ease-in-out',
        },
    })
  //draggable.on('drag:start', () => console.log('drag:start'));
  //draggable.on('drag:move', () => console.log('drag:move'));
  //draggable.on('drag:stop', () => console.log('drag:stop'));
  sortable.on('snap:in', () => console.log('snap:in'));
 sortable.on('snap:out', () => console.log('snap:out'));*/
 
</script>
<script>
function visualizar(e){
   let url = e.dataset.url 
   let contairner_iframe= document.getElementById('iframe_container');
   contairner_iframe.innerHTML = '';
   let html = `<iframe class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src=${url}' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>`;
   contairner_iframe.insertAdjacentHTML('beforeend', html ); 
} 
$("#save").click( function() {
  const data = $('#list-anexos > li.completed').map(function() {
    if ( $(this).find(':input[type=checkbox]').val() == 'on' ) {
      return $(this).attr('data-id')
    }
  }).get()
  let empresa_id = document.getElementById('dropdownMenuButton').dataset.empresa_id; 
  let formdata = new FormData();
  formdata.append('cotizacion_id', {{$cotizacion->id }} );
  formdata.append('anexos',data);
  
  fetch( '/expediente/', {
      headers:{
       "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      method: 'post',
      body:formdata
  }).then(response => response.json()
  ).then(data => {
    console.log(data);
  }) 
})
</script>
@endsection
