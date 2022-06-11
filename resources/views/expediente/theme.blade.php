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

 .widget-more {
    display: none;
    background: #d8d3ff;
    margin-left: 30px;
    padding: 2px 10px;
    border-radius: 4px;
    margin-bottom: 5px;
    font-size: 12px;
    text-align: center;
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
  <div class="col-6">
    <div class="row">
      <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('licitacion.table', ['licitacion' => $cotizacion->oportunidad()->licitacion()])
        </div>
      </div>
    </div>
      </div>
      <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('licitacion.cronograma', ['licitacion'=> $cotizacion->oportunidad()->licitacion()])
        </div>
      </div>
    </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="row">
      <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('oportunidad.table', ['oportunidad' => $cotizacion->oportunidad()])
        </div>
      </div>
    </div>
      </div>
      <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        @include('cotizacion.table', ['cotizacion'=> $cotizacion])
        </div>
      </div>
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
function verify_check_widget() {
  if ($(this).is(':checked')) {
    $(this).closest('.widget-todo-item').find('.widget-more').stop().slideDown();
  } else {
    $(this).closest('.widget-todo-item').find('.widget-more').stop().slideUp();
  }
}
$(".checkbox__input").each(verify_check_widget);
$(".checkbox__input").on('click', verify_check_widget);

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

  function actualizar_archivo(file){
    let  url = "/expediente/{{ $cotizacion->id }}/archivo/actualizar"; 
    let formdata = new FormData();
    formdata.append('archivo', file.files[0] )
    formdata.append('documento_id', file.dataset.docid);  
    formdata.append('key', file.dataset.key)

    fetch( url , {
      headers: {
         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },  
      method: 'post',
      body:formdata,   
    }).then(response=> response.json())
      .then( data => {
      file.parentNode.insertAdjacentHTML('afterbegin',`
                                    <div class="avatar bg-rgba-warning m-0 mr-50">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bx-loader-circle"></i>
                                        </div>
                                      </div>
        `);       
        console.log(data); 
      })
  }

</script>
@endsection
