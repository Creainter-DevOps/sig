@extends('expediente.theme')
@section('contenedor')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content mt-2">
          <div class="card-body">
            <div class="wizard-horizontal">
                <div class="row">
                      <div class="col-6" id="iframe_container" >
                      <iframe  class="doc" src='https://view.officeapps.live.com/op/embed.aspx?src=https://sig.creainter.com.pe/storage/{{ reset($workspace['paso02'])['root']  }}?t={{time()}}' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
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
                                {{ $cotizacion->empresa()->razon_social }}
                              </li>
                            </ul>
                          </div>
<form class="form" action="{{ route('expediente.paso02', ['cotizacion' => $cotizacion->id])}}" method="post">
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                              @foreach ($workspace['paso02'] as $key => $anexo)               
                              @csrf
                              <li class="widget-todo-item" data-id="anexo_1" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <span class="widget-todo-title ml-50">{{$anexo['rotulo'] }}</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1" onclick="visualizar(this)" style="cursor:pointer;" data-url="{{'https://sig.creainter.com.pe/storage/' . $anexo['root'] }}?t={{time()}}"><i class="bx bx-show"></i> </div>
                                    <a class="avatar bg-rgba-secondary  m-0 mr-50" href="https://sig.creainter.com.pe/storage/{{$anexo['root']}}" >
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bxs-download"></i>
                                      </div>
                                    </a>
                                    <input type="file" id="archivo-{{$anexo["generado_id"]}}" name="archivo-{{$anexo['generado_id'] }}" hidden style="display:none;" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" data-docid="{{ $anexo['generado_id'] }}" data-key="{{ $key }}" onchange="actualizar_archivo(this)" /> 
                                    
                                     <a class="avatar bg-rgba-primary m-0 mr-50" onclick="$('#archivo-{{$anexo['generado_id']}}').click();"  >
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary"></span>
                                          <i class="bx bx-upload"></i>
                                      </div>
                                    </a>
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
@endsection
