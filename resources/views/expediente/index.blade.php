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
              <!-- Step 1 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:morph-doc.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>
              <!-- Step 1 end-->
              <!-- body content step 1 -->
              <fieldset>
                <div class="row">
                      <div class="col-6">
                      <ul>
                      @foreach($documents as $a )
                        <li>
                      <a target="_blank" href="{{ config('constants.static_seace') . $a->codigoAlfresco }}">
                        {{ $a->tipoDocumento }}
                      </a>
                    </li>
                    @endforeach                       
                    </ul>
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
                          <form class="form" action="{{ route('documentos.paso01', ['cotizacion' => $cotizacion->id])}}" method="post">
                            @csrf
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="list-anexos">
                              @foreach($anexos as $anexo) 
                              <li class="widget-todo-item" data-id="{{$anexo->id }}" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo{{$anexo->id}}" name="anexos[{{$anexo->id}}]">
                                      <label for="check_anexo{{$anexo->id}}"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">{{$anexo->rotulo}}</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1">Word</div>
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
                          <button class="btn btn-primary text-white" type="submit"  id="save">Generar</button>
                          </form>
                        </div>
                      </div>
                </div>
              </fieldset>
              <!-- body content step 1 end-->
              <!-- Step 2 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:truck.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>
              <fieldset>
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
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                              @foreach ($workspace['paso02'] as $anexo)               
                              <li class="widget-todo-item" data-id="anexo_1" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <span class="widget-todo-title ml-50">{{$anexo['rotulo'] }}</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1" onclick="visualizar(this)" style="cursor:pointer; " data-url="{{'https://sig.creainter.com.pe/temporales/'. $anexo['key'] }}">Word</div>
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
                          <span class="btn btn-primary text-white"href=""  id="save">Generar</span>
                        </div>
                      </div>
                </div>
              </fieldset>   
              <!-- Step 2 end-->
              <!-- body content of step 2 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:truck.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>

              <fieldset>
                <div class="row">
                  <section id="MultipleContainers" >
                    <article id="ContainerOne" class="StackedListWrapper StackedListWrapper--sizeLarge StackedListWrapper--axisHorizontal Container">
                      <header class="StackedListHeader">
                        <h3 class="Heading Heading--size3 Heading--colorWhite">Ordenar PDF</h3>
                      </header>

                      <ul class="StackedList">
                      <li class="StackedListItem StackedListItem--item3"><div class="StackedListContent">
                        <h4 class="Heading Heading--size4 text-no-select">baboon</h4><div class="NopeHandle"></div></div></li>
                      </li>
                      <li class="StackedListItem StackedListItem--isDraggable StackedListItem--item1" tabindex="1" style="">
        <div class="StackedListContent"><h4 class="Heading Heading--size4 text-no-select">zebra</h4><div class="DragHandle"></div><div class="Pattern Pattern--typeHalftone"></div><div class="Pattern Pattern--typePlaced"></div></div></li>
                    </article>
                    <article id="ContainerTwo" class="StackedListWrapper StackedListWrapper--sizeMedium StackedListWrapper--hasScrollIndicator Container">
                      <header class="StackedListHeader">
                         <h3 class="Heading Heading--size3 Heading--colorWhite">Documentos</h3>
                    </header>
                    <ul class="StackedList StackedList--hasScroll">
                      <li class="StackedListItem StackedListItem--isDraggable StackedListItem--item4" tabindex="1" style="">
                        <div class="StackedListContent">
                        <h4 class="Heading Heading--size4 text-no-select">elephant</h4>
                          <div class="DragHandle"></div>
                          <div class="Pattern Pattern--typeHalftone"></div>
                          <div class="Pattern Pattern--typePlaced"></div>
                        </div>
                      </li>
                      <li class="StackedListItem StackedListItem--isDraggable StackedListItem--item4" tabindex="1" style="">
                        <div class="StackedListContent">
                        <h4 class="Heading Heading--size4 text-no-select">elephant</h4>
                          <div class="DragHandle"></div>
                          <div class="Pattern Pattern--typeHalftone"></div>
                          <div class="Pattern Pattern--typePlaced"></div>
                        </div>
                      </li>
                      
                      <li class="StackedListItem StackedListItem--isDraggable StackedListItem--item4" tabindex="1" style="">
                        <div class="StackedListContent">
                        <h4 class="Heading Heading--size4 text-no-select">Anexo1</h4>
                          <div class="DragHandle"></div>
                          <div class="Pattern Pattern--typeHalftone"></div>
                          <div class="Pattern Pattern--typePlaced"></div>
                        </div>
                      </li>

                      <li class="StackedListItem StackedListItem--isDraggable StackedListItem--item4" tabindex="1" style="">
                        <div class="StackedListContent">
                        <h4 class="Heading Heading--size4 text-no-select">Anexo2</h4>
                          <div class="DragHandle"></div>
                          <div class="Pattern Pattern--typeHalftone"></div>
                          <div class="Pattern Pattern--typePlaced"></div>
                        </div>
                      </li>

                    </ul>
                  </article>

                  </section>
                </div>
              </fieldset>
              <!-- body content of step 2 end-->
              <!-- Step 3 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:home.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>
              <!-- Step 3 end-->
              <!-- body content of Step 3 -->
              <fieldset>
                <div class="row">
                  <div class="col-12">
                    <h6 class="py-50">Enter Your Payment Methods</h6>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <div class="d-flex justify-content-between flex-wrap align-items-center">
                        <div class="vs-radio-con vs-radio-primary">
                          <img src="{{asset('images/pages/bank.png')}}" alt="img-placeholder" height="40">
                          <span>Card 12XX XXXX XXXX 0000</span>
                        </div>
                        <div class="card-holder-name">
                          John Doe
                        </div>
                        <div class="card-expiration-date">
                          11/2020
                        </div>
                        <div>
                          <label>Enter CVV</label>
                          <input type="password" class="form-control" placeholder="Enter Your CVV no.">
                        </div>
                      </div>
                    </div>
                    <hr>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <ul class="other-payment-options list-unstyled">
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio6" checked="">
                            <label for="radio6">Credit / Debit / ATM Card</label>
                          </div>
                        </li>
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio7" checked="">
                            <label for="radio7">Net Banking</label>
                          </div>
                        </li>
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio8" checked="">
                            <label for="radio8"> EMI (Easy Installment)</label>
                          </div>
                        </li>
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio9" checked="">
                            <label for="radio9"> Cash On Delivery</label>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <hr>
                  </div>
                  <div class="col-12 d-flex">
                    <div class="paypal cursor-pointer d-flex align-items-center">
                      <div class="radio">
                        <input type="radio" name="onlportal" id="paypal" checked="">
                        <label for="paypal"></label>
                      </div>
                      <img src="{{asset('images/pages/PayPal_logo.png')}}" alt="PayPal Logo">
                    </div>
                    <div class="googlepay cursor-pointer pl-1 d-flex align-items-center">
                      <div class="radio">
                        <input type="radio" name="onlportal" id="googlepay" checked="">
                        <label for="googlepay"></label>
                      </div>
                      <img src="{{asset('images/pages/google-pay.png')}}" height="30" alt="google Logo">
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <hr>
                    <div class="form-group">
                      <label>Enter Your Promocode</label>
                      <input type="text" class="form-control" placeholder="Enter Your Promocode">
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
  
  fetch( '/documentos/', {
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
