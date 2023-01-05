@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title',$empresa->razon_social )
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
@endsection
@section('content')
<!-- account setting page start -->
<section id="page-account-settings">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill"
                                href="#account-vertical-general" aria-expanded="true">
                                <i class="bx bx-cog"></i>
                                <span>General</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill"
                                href="#account-vertical-info" aria-expanded="false">
                                <i class="bx bx-info-circle"></i>
                                <span>Etiquetas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill"
                                href="#account-vertical-password" aria-expanded="false">
                                <i class="bx bx-lock"></i>
                                <span>Representante</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill" href="#recursos-graficos" aria-expanded="false">
                                <!--<i class="bx bx-lock"></i>-->
                                <i class='bx bxs-image-alt' ></i>
                                <span>Recursos Graficos</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="" data-toggle="pill" href="#sellos" aria-expanded="false">
                                <i class='bx bxs-image-alt' ></i>
                                <span>Sellos</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="" data-toggle="pill" href="#firmas" aria-expanded="false">
                                <!--<i class="bx bx-lock"></i>-->

                                <i class='bx bxs-edit-alt'></i>
                                <!--<i class='bx bxs-image-alt' ></i>-->
                                <span>Firmas</span>
                            </a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill"
                                href="#account-vertical-info" aria-expanded="false">
                                <i class="bx bx-info-circle"></i>
                                <span>Info</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-social" data-toggle="pill"
                                href="#account-vertical-social" aria-expanded="false">
                                <i class="bx bxl-twitch"></i>
                                <span>Social links</span>
                            </a>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-connections" data-toggle="pill"
                                href="#account-vertical-connections" aria-expanded="false">
                                <i class="bx bx-link"></i>
                                <span>Connections</span>
                            </a>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="account-pill-notifications" data-toggle="pill"
                                href="#account-vertical-notifications" aria-expanded="false">
                                <i class="bx bx-bell"></i>
                                <span>Notifications</span>
                            </a>
                        </li>-->
                    </ul>
                </div>
                <!-- right content section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                        aria-labelledby="account-pill-general" aria-expanded="true">
                                        <!--<div class="media">
                                            <a href="javascript: void(0);">
                                                @if (isset($emprea->logo_head ))
                                                <img src="{{asset('images/portrait/small/avatar-s-16.jpg')}}"
                                                    class="rounded mr-75" alt="profile image" height="64" width="64">
                                                @else
                                                <img src="/storage/{{$empresa->logo_head}}"
                                                    class="rounded mr-75" alt="profile image" height="64" >
                                                @endif
                                            </a>
                                            <div class="media-body mt-25">
                                                <div
                                                    class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                        <label for="select-files" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                                                          <span>Cargar Imagen</span>
                                                          <input id="select-files" accept="*.jpg,*.png" type="file" hidden>
                                                        </label>
                                                    <button class="btn btn-sm btn-light-secondary ml-50">Quitar</button>
                                                </div>
                                                <p class="text-muted ml-1 mt-50"><small>Solo imagenes JPG, GIF or PNG. Max tamaño maximo 8 mb </small></p>
                                            </div>>
                                        </div>
                                        <hr>-->
                                        <form novalidate id="form-empresa" >
                                            @csrf
                                            {!! method_field('PUT') !!}
                                            <div class="row">

                                                <!--<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Descripcion</label>
                                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                                            placeholder="Descripcion...">{{$empresa->descripcion}}</textarea>
                                                    </div>
                                                </div>-->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>RUC</label>
                                                            <input type="number" class="form-control" placeholder="RUC"
                                                                value="{{$empresa->ruc}}" name="ruc" required
                                                                data-validation-required-message="El ruc es requerido">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Razon Social</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Razon Social" value="{{$empresa->razon_social ?? ''}}" name="razon_social" required
                                                                data-validation-required-message="La razon social es requerida">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Sunarp Registro</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Sunarp Registro" value="{{ $empresa->sunarp_registro ?? '' }}" name="sunarp_registro" required
                                                                data-validation-required-message="El numero de registro sunarp es requerido">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Sector</label>
                                                            <select class="form-control" name="sector_id" data-value="{{$empresa->sector_id }}"  >
                                                            @foreach ($empresa::tipoSectores() as $k =>  $sector )
                                                              <option value="{{$k}}">{{$sector}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Categoria</label>
                                                            <select class="form-control" placeholder="Sector" name="categoria_id" data-value="{{ $empresa->categoria_id  }}" >
                                                            @foreach ($empresa::tipoCategorias() as $k =>  $categoria )
                                                              <option value="{{$k}}">{{$categoria}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Seudonimo</label>
                                                            <input type="text" class="form-control" placeholder="Seudonimo" name="seudonimo"
                                                                value="{{$empresa->seudonimo}}" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Correo</label>
                                                            <input type="email" class="form-control" name="correo_electronico" placeholder="Correo"
                                                                value="{{$empresa->correo_electronico ?? ''}}" required
                                                                >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Dominio Correo</label>
                                                            <input type="text" class="form-control" name="dominio_correo" placeholder="Dominio Correo" value="{{$empresa->dominio_correo ?? ''}}" 
                                                                >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Dirección</label>
                                                            <input type="text" class="form-control" name="direccion"
                                                                placeholder="Dirección" value="{{$empresa->direccion ?? ''}}" required
                                                                data-validation-required-message="This username field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Referencia</label>
                                                            <input type="text" class="form-control" placeholder="Referencia" name="referencia"
                                                                value="{{$empresa->referencia}}" required
                                                               >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Web</label>
                                                            <input type="text" class="form-control" placeholder="Web" name="web"
                                                                value="{{$empresa->web}}" required
                                                               >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Telefono</label>
                                                            <input type="text" class="form-control" placeholder="Telefono" name="telefono"
                                                                value="{{$empresa->telefono}}" required
                                                               >
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--<div class="col-12">
                                                    <div class="alert bg-rgba-warning alert-dismissible mb-2"
                                                        role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        <p class="mb-0">
                                                            Your email is not confirmed. Please check your inbox.
                                                        </p>
                                                        <a href="javascript: void(0);">Resend confirmation</a>
                                                    </div>
                                                </div>-->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Aniversario</label>
                                                        <input type="date" class="form-control" name="aniversario"
                                                            placeholder="Aniversario">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Color Primario</label>
                                                        <input type="color" class="form-control" value="{{ $empresa->color_primario ?? '' }}" name="color_primario" placeholder="Color Primario">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Agente retencion</label>
                                                        <input type="checkbox" class="" {{ $empresa->es_agente_retencion ? 'checked' : '' }}   placeholder="Aniversario" name="es_agente_retencion" >
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Guardar</button>
                                                    <button type="reset" class="btn btn-light mb-1">Cancelar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade " id="account-vertical-password" role="tabpanel"
                                        aria-labelledby="account-pill-password" aria-expanded="false">
                                        <form novalidate id="form-representante" >
                                            @csrf
                                            {!! method_field('PUT') !!}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Nombres</label>
                                                            <input type="text" class="form-control"name="representante_nombres" required
                                                                placeholder="nombre" value="{{$empresa->representante_nombres}}"
                                                                data-validation-required-message="This old password field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Documento</label>
                                                            <input type="text" name="representante_documento" class="form-control"
                                                                placeholder="Documento"value="{{$empresa->representante_documento}}" required
                                                                data-validation-required-message="The password field is required"
                                                                >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Ubigeo</label>
                                                            <input type="text" class="form-control" placeholder="Ubigeo" name="ubigeo_id"
                                                                value="{{$empresa->ubigeo_id}}"
                                                               >
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Retype new Password</label>
                                                            <input type="password" name="con-password"
                                                                class="form-control" required
                                                                data-validation-match-match="password"
                                                                placeholder="New Password"
                                                                data-validation-required-message="The Confirm password field is required"
                                                                minlength="6">
                                                        </div>
                                                    </div>
                                                </div>-->
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Guardar</button>
                                                    <button type="reset" class="btn btn-light mb-1">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade " id="sellos" role="tabpanel"
                                        aria-labelledby="account-pill-password" aria-expanded="false">
                                       <!--<form novalidate id="form-graficos" enctype="multipart/form-data" >-->
                                            @csrf
                                            {!! method_field('PUT') !!}
                                            <div class="row">
                                                
                                              <div class="col-12">
                                                 <div class="form-group">
                                                        <div class="controls">
                                                              <label>Sellos</label>
                                                              <p class="tex-muted description">Los sellos seran utilizados en los documentos, expedientes y anexos .</p>
                                                            <div style="" >
                                                              <p>Para ello debera realiza los siguientes pasos</p>
                                                              <ul>
                                                                 <li>Descargar la plantilla.<a href="/static/cloud/FORMATO_VISADO.pdf" target="_blank">Aqui</a></li>  
                                                                 <li>Cargar el documento escaneado con las firmas o sellos  en cada recuadro.</li>  
                                                                 <li>Procesar y guardar.</li>  
                                                              </ul>

                                                              <p class="text-muted ml-1 mt-50" ><small>Solo documentos  PDF. Tamaño maximo 4 mb </small></p>
                                                            </div>
                                                            <div class="media">
                                                              <div class="media-body mt-25">
                                                                  <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start" style="margin-bottom:15px;">
                                                                        <label for="select-files-sello" class="btn btn-sm btn-light-primary ml-50 mb-sm-0" style=";display: {{ empty($sellos)? 'block': 'none' }};" >
                                                                          <span>Cargar Sellos</span>
                                                                          <input id="select-files-sello" name="sellos"    accept="*.pdf" type="file" style=""  >
                                                                        </label>
                                                                        <input type="hidden" id="folder_sellos" name="folder_sellos"> 
                                                                        <button class="btn btn-sm btn-light-danger ml-50" style="display: {{ !empty( $sellos )? 'block' : 'none' }};"   onclick="removeFile('sellos')">Quitar</button>
                                                                        <button class="btn btn-sm btn-light-secondary ml-50" style="display: none "   id="btn_procesar_sellos"  >Procesar</button>
                                                                  </div>
                                                                  <div class="container-sellos" style=";display: {{ isset($sellos)? 'grid': 'none' }}; grid-template: repeat(5,1fr)/repeat(3,180px);grid-gap:15px;margin-bottom: 20px;width: 100%; ">
                                                                    @foreach ($sellos as $firma )        
                                                                        <div class="" style="display:grid;place-items:center;border: 1px solid var(--primary);width:100%; padding: 10px;">
                                                                          <img src="{{ config('constants.app_url') }}/static/cloud/{{$firma['archivo']}}" style="max-width:100%;"  class="rounded "  alt="profile image" height="64">
                                                                        </div>
                                                                    @endforeach    
</div>

                                                            </div>
                                                          </div>
                                                        </div>
                                                 </div>
                                              </div>
                                              <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" id="btn-sellos-firmas" class="btn btn-primary glow mr-sm-1 mb-1" onclick="guardar_sellos(event)" >Guardar</button>
                                                <button type="reset" class="btn btn-light mb-1">Cancelar</button>
                                              </div>
                                            </div>
                                       <!-- </form>-->
                                    </div>

                                    <div class="tab-pane fade " id="firmas" role="tabpanel"
                                        aria-labelledby="account-pill-password" aria-expanded="false">
                                       <!--<form novalidate id="form-graficos" enctype="multipart/form-data" >-->
                                            @csrf
                                            {!! method_field('PUT') !!}
                                            <div class="row">
                                                
                                              <div class="col-12">
                                                 <div class="form-group">
                                                        <div class="controls">
                                                            <label>Firmas</label>
                                                            <p class="tex-muted description">La firmas seran utilizados en los documentos, expedientes y anexos .</p>
                                                            <p>Para ello debera realiza los siguientes pasos</p>
                                                            <ul>
                                                               <li>Descargar la plantilla.<a href="/static/cloud/FORMATO_VISADO.pdf" target="_blank" > Aqui</a> </li>  
                                                               <li>Cargar el documento escaneado con las firmas o sellos  en cada recuadro.</li>  
                                                               <li>Procesar y guardar.</li>  
                                                            </ul>

                                                            <p class="text-muted ml-1 mt-50"><small>Solo documentos  PDF. Tamaño maximo 4 mb </small></p>

                                                            <div class="media">
                                                              <div class="media-body mt-25">
                                                                  <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start" style="margin-bottom:15px;" >

                                                                        <label for="select-files-firma" style="display: {{ empty($firmas)? 'block': 'none' }};"   class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                                                                          <span>Cargar firmas</span>
                                                                          <input id="select-files-firma" name="firmas" accept="*.pdf" type="file" >
                                                                        </label>
                                                                        <input type="hidden" id="folder_firmas" name="folder_firmas"> 
                                                                        <button class="btn btn-sm btn-light-danger ml-50" style="display: {{ !empty($firmas) ? 'block': 'none' }}"   onclick="removeFile('firmas')" >Quitar</button>
                                                                        <button class="btn btn-sm btn-light-secondary ml-50" style="display:none" id="btn_procesar">Procesar</button>
                                                                  </div>

                                                                  <div class="container-firmas" style="display: {{ isset($firmas)? 'grid': 'none' }}  ;
grid-template: repeat(5,1fr)/repeat(3,180px);grip-gap:10px;margin-bottom: 20px;
width: 100%;grid-gap: 15px;justify-items: start;  " >
                                                                    @foreach ($firmas as $firma )        
                                                                        <div class="" style="display:grid;place-items:center;border: 1px solid var(--primary);width:100%; padding: 10px;" ><img src="/static/cloud/{{ $firma['archivo'] }}" style="max-width: 100%;" class="rounded" alt="profile image" height="64"></div>
                                                                    @endforeach    
                                                                  </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                 </div>
                                              </div>
                                              <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" id="btn-sellos-firmas" class="btn btn-primary glow mr-sm-1 mb-1" onclick="guardar_firmas(event)">Guardar</button>
                                                <button type="reset" class="btn btn-light mb-1">Cancelar</button>
                                              </div>
                                            </div>
                                       <!-- </form>-->
                                    </div>
                                    <div class="tab-pane fade " id="recursos-graficos" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <form novalidate id="form-graficos" method="post" enctype="multipart/form-data" >
                                            @csrf
                                            {!! method_field('PUT') !!}
                                            <div class="row">
                                              <div class="col-12">
                                                 <div class="form-group">
                                                        <div class="controls">
                                                            <label>Logo</label>
                                                            <p class="tex-muted description">La imagen sera utilizada en los documentos, expedientes.</p>
                                                            <div class="media">
                                                              <a href="javascript: void(0);" style="display: {{ !empty($empresa->logo_head) ? 'block' : 'none' }}">

                                                              <img src="{{ config("constants.ruta_cloud") . $empresa->logo_head}}" class="rounded mr-75" alt="profile image" height="64"></a>
                                                              <div class="media-body mt-25">
                                                                  <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                      <label for="input-logo" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                                                                        <span>Cargar Imagen</span>
                                                                        <input id="input-logo"name="logo_head" data-campo="logo_head" accept="image/*" type="file" hidden="" onChange="cargar_imagen(event)" >
                                                                      </label>
                                                                      <button class="btn btn-sm btn-light-secondary ml-50" onClick="quitar(event)" data-tipo="logo_head" >Quitar</button>
                                                                  </div>
                                                                  <p class="text-muted ml-1 mt-50"><small>Solo imagenes JPG, GIF or PNG. Max tamaño maximo 8 mb </small></p>
                                                              </div>
                                                          </div>
                                                        </div>
                                                 </div>
                                              </div>
                                                
                                              <div class="col-12">
                                                 <div class="form-group">
                                                        <div class="controls">
                                                            <label>Logo Principal</label>
                                                            <p class="tex-muted description">La imagen sera utilizada como portada en los documentos, expedientes.Por ellos se recomienda contar con la siguientes medidas( 200 x 300  ) </p>
                                                            <div class="media">
                                                              <a href="javascript: void(0);" style="display:{{ !empty($empresa->logo_central) ? 'block' : 'none' }}">
                                                              <img src="{{ config("constants.ruta_cloud") . $empresa->logo_central }}" class="rounded mr-75" alt="profile image" height="64">
                                                                                             </a>
                                                              <div class="media-body mt-25">
                                                                  <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                    <label for="input-logo-principal" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">Cargar Imagen
                                                                    </label>

                                                                    <input type="file" id="input-logo-principal" name="logo_central" data-campo="logo_central" onChange="cargar_imagen(event)" accept="image/*" style="display: none;" >
                                                                   <button class="btn btn-sm btn-light-secondary ml-50" onClick="quitar(event)" data-tipo="logo_central"   >Quitar</button>
                                                                  </div>
                                                                  <p class="text-muted ml-1 mt-50"><small>Solo imagenes JPG, GIF or PNG. Max tamaño maximo 8 mb </small></p>
                                                              </div>
                                                          </div>
                                                        </div>
                                                 </div>
                                              </div>

                                             <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Guardar</button>
                                                <button type="reset" class="btn btn-light mb-1">Cancelar</button>
                                              </div>

                                            </div>

                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel"
                                        aria-labelledby="account-pill-info" aria-expanded="false">
                                            <div class="row">
                                              <div class="col-12">
                                                   <label>A favor</label>   
                                                   <div class="form-control" style="display:flex; flex-wrap:wrap; height:max-content;"> 
                                                   @foreach ($etiquetas as $etiqueta) 
                                                     @if ( $etiqueta->tipo == 1 && isset($etiqueta->etiqueta->aprobado_el) )
                                                       <span class="bg-primary text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"><?= $etiqueta->etiqueta->nombre?><i data-tag="<?= $etiqueta->etiqueta->id ?>" class='bx bx-x'style="color:white;cursor:pointer;" onclick="removeTag(this)" ></i></span>
                                                     @elseif ( $etiqueta->tipo == 1 && !isset($etiqueta->etiqueta->rechazado_el ))  
                                                       <span class="bg-secondary text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"><?= $etiqueta->etiqueta->nombre?><i data-tag="<?= $etiqueta->etiqueta->id ?>" class='bx bx-x'style="color:white;cursor:pointer;" onclick="removeTag(this)" ></i></span>
                                                     @endif
                                                   @endforeach
                                                      <form id="frmFavor"> 
                                                       {!! csrf_field() !!}
                                                      <input type="hidden" value="1" name="tipo"> 
                                                      <input type="hidden" value="<?= $empresa->id; ?>" name="empresa_id"> 
                                                      <input type="text" name="nombre" id="favor"  style="padding:4px; margin-left:2px; margin-top:4px; min-width: 50px; outline:none; overflow: auto; outline: none;border:none; border-radius: 0; box-shadow: none; box-sizing:content-box;text-transform: uppercase; "    contenteditable="true"> 
                                                      </form>
                                                    </div>
                                              </div>  

                                              <div class="col-12">
                                                    <label>En contra </label>
                                                    <div class="form-control" style="display:flex; flex-wrap:wrap; height:max-content;" >
                                                      @foreach ($etiquetas as $etiqueta)
                                                        @if( $etiqueta->tipo == 2 )
                                                        <span class="bg-danger text-white"style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"> <?= $etiqueta->etiqueta->nombre?><i class='bx bx-x' data-tag="<?= $etiqueta->etiqueta->id ?>" style="color:white;cursor:pointer;" onclick="removeTag(this)"  ></i></span>
                                                        @endif
                                                      @endforeach
                                                      <form id="frmContra">
                                                       {!! csrf_field() !!}
                                                      <input type="hidden" value="2" name="tipo"> 
                                                      <input type="hidden" value="<?= $empresa->id ?>" name="empresa_id"> 
                                                      <input type="text"name="nombre"  id="contra" style="padding:4px; margin-left:2px; margin-top:4px; min-width:50px; outline:none; overflow: auto; outline: none;border:none; border-radius: 0; box-shadow: none; box-sizing:content-box;text-transform: uppercase;" contenteditable="true"   > 
                                                      </form>
                                                    </div>
                                                </div>

                                                <!--<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Bio</label>
                                                        <textarea class="form-control" id="accountTextarea" rows="3"
                                                            placeholder="Your Bio data here..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Birth date</label>
                                                            <input type="text" class="form-control birthdate-picker"
                                                                required placeholder="Birth date"
                                                                data-validation-required-message="This birthdate field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select class="form-control" id="accountSelect">
                                                            <option>USA</option>
                                                            <option>India</option>
                                                            <option>Canada</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Languages</label>
                                                        <select class="form-control" id="languageselect2"
                                                            multiple="multiple">
                                                            <option value="English" selected>English</option>
                                                            <option value="Spanish">Spanish</option>
                                                            <option value="French">French</option>
                                                            <option value="Russian">Russian</option>
                                                            <option value="German">German</option>
                                                            <option value="Arabic" selected>Arabic</option>
                                                            <option value="Sanskrit">Sanskrit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Phone</label>
                                                            <input type="text" class="form-control" required
                                                                placeholder="Phone number" value="(+656) 254 2568"
                                                                data-validation-required-message="This phone number field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Website</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Website address">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Favourite Music</label>
                                                        <select class="form-control" id="musicselect2"
                                                            multiple="multiple">
                                                            <option value="Rock">Rock</option>
                                                            <option value="Jazz" selected>Jazz</option>
                                                            <option value="Disco">Disco</option>
                                                            <option value="Pop">Pop</option>
                                                            <option value="Techno">Techno</option>
                                                            <option value="Folk" selected>Folk</option>
                                                            <option value="Hip hop">Hip hop</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Favourite movies</label>
                                                        <select class="form-control" id="moviesselect2"
                                                            multiple="multiple">
                                                            <option value="The Dark Knight" selected>The Dark Knight
                                                            </option>
                                                            <option value="Harry Potter" selected>Harry Potter</option>
                                                            <option value="Airplane!">Airplane!</option>
                                                            <option value="Perl Harbour">Perl Harbour</option>
                                                            <option value="Spider Man">Spider Man</option>
                                                            <option value="Iron Man" selected>Iron Man</option>
                                                            <option value="Avatar">Avatar</option>
                                                        </select>
                                                    </div>
                                                </div>-->
                                                <!--<div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1 ">Guardar</button>
                                                    <button type="reset" class="btn btn-light mb-1">Cancelar</button>
                                                </div>-->
                                            </div>
                                    </div>
                                    <div class="tab-pane fade " id="account-vertical-social" role="tabpanel" aria-labelledby="account-pill-social" aria-expanded="false">
                                        <form>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Twitter</label>
                                                        <input type="text" class="form-control" placeholder="Add link"
                                                            value="https://www.twitter.com">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Facebook</label>
                                                        <input type="text" class="form-control" placeholder="Add link">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Google+</label>
                                                        <input type="text" class="form-control" placeholder="Add link">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>LinkedIn</label>
                                                        <input type="text" class="form-control" placeholder="Add link"
                                                            value="https://www.linkedin.com">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Instagram</label>
                                                        <input type="text" class="form-control" placeholder="Add link">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Quora</label>
                                                        <input type="text" class="form-control" placeholder="Add link">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                        changes</button>
                                                    <button type="reset" class="btn btn-light mb-1">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-connections" role="tabpanel"
                                        aria-labelledby="account-pill-connections" aria-expanded="false">
                                        <div class="row">
                                            <div class="col-12 my-2">
                                                <a href="javascript: void(0);" class="btn btn-info">Connect to
                                                    <strong>Twitter</strong></a>
                                            </div>
                                            <hr>
                                            <div class="col-12 my-2">
                                                <button
                                                    class=" btn btn-sm btn-light-secondary float-right">edit</button>
                                                <h6>You are connected to facebook.</h6>
                                                <p>Johndoe@gmail.com</p>
                                            </div>
                                            <hr>
                                            <div class="col-12 my-2">
                                                <a href="javascript: void(0);" class="btn btn-danger">Connect to
                                                    <strong>Google</strong>
                                                </a>
                                            </div>
                                            <hr>
                                            <div class="col-12 my-2">
                                                <button
                                                    class=" btn btn-sm btn-light-secondary float-right">edit</button>
                                                <h6>You are connected to Instagram.</h6>
                                                <p>Johndoe@gmail.com</p>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                    changes</button>
                                                <button type="reset" class="btn btn-light mb-1">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-vertical-notifications" role="tabpanel"
                                        aria-labelledby="account-pill-notifications" aria-expanded="false">
                                        <div class="row">
                                            <h6 class="m-1">Activity</h6>
                                            <div class="col-12 mb-1">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="accountSwitch1">
                                                    <label class="custom-control-label mr-1"
                                                        for="accountSwitch1"></label>
                                                    <span class="switch-label w-100">Email me when someone comments
                                                        onmy
                                                        article</span>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-1">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="accountSwitch2">
                                                    <label class="custom-control-label mr-1"
                                                        for="accountSwitch2"></label>
                                                    <span class="switch-label w-100">Email me when someone answers on
                                                        my
                                                        form</span>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-1">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="accountSwitch3">
                                                    <label class="custom-control-label mr-1"
                                                        for="accountSwitch3"></label>
                                                    <span class="switch-label w-100">Email me hen someone follows
                                                        me</span>
                                                </div>
                                            </div>
                                            <h6 class="m-1">Application</h6>
                                            <div class="col-12 mb-1">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="accountSwitch4">
                                                    <label class="custom-control-label mr-1"
                                                        for="accountSwitch4"></label>
                                                    <span class="switch-label w-100">News and announcements</span>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-1">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="accountSwitch5">
                                                    <label class="custom-control-label mr-1"
                                                        for="accountSwitch5"></label>
                                                    <span class="switch-label w-100">Weekly product updates</span>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-1">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" checked
                                                        id="accountSwitch6">
                                                    <label class="custom-control-label mr-1"
                                                        for="accountSwitch6"></label>
                                                    <span class="switch-label w-100">Weekly blog digest</span>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save changes</button>
                                                <button type="reset" class="btn btn-light mb-1">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<form id="form"   enctype='multipart/form-data' >
   {!! method_field('PUT') !!}
</form>
<!-- account setting page ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-account-settings.js')}}"></script>

<script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
  <script>

    const tagFavor = document.getElementById('favor');   
    const tagContra = document.getElementById('contra');
    const frmFavor = document.getElementById('frmFavor');
    const frmContra = document.getElementById('frmContra');
    const formEmpresa = document.getElementById('form-empresa');
    const formRepresentante = document.getElementById('form-representante');
    const formGraficos = document.getElementById('form-graficos');
    const btnSellosFirmas = document.getElementById("btn-sellos-firmas");

    let file_firma = document.getElementById("select-files-firma");
    let file_sello = document.getElementById("select-files-sello");

    let containerImgFirmas = document.querySelector(".container-firmas")
    let containerImgSellos = document.querySelector(".container-sellos")

    file_sello.addEventListener("change", function(e){
      console.log("change");
      btn_procesar_sellos.style.display = "block"; 
    })

    file_firma.addEventListener("change", function(e){
      console.log("change");
      btn_procesar.style.display = 'block'; 
    })

    function quitar(e){
      e.preventDefault();  
      e.stopPropagation(); 
      //let url = "/empresas/" + {{ $empresa->id }};       

      let url = `/empresas/{{$empresa->id}}?_delete=${e.target.dataset.tipo}`
      
      let formdata = new FormData();

      formdata.append("_method", "PUT")

      Fetchx({
              title: "Guardando",
              url: url,
              type: "POST",
              processData: false,
              contentType: false,
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formdata, 
              success: function(response){

                e.target.closest(".media").querySelector("a").style.display = 'none'  
                console.log(console);
              }
      })
    }
    formGraficos.addEventListener("submit",function (e){
      e.preventDefault();
      let formdata = new FormData(formGraficos);
      let url = "/empresas/" + {{ $empresa->id }};       
      Fetchx({
              title: "Guardando",
              url: url,
              type: "POST",
              processData: false,
              contentType: false,
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formdata, 
              success: function(response){
                console.log();
              }
        })
    })

    btn_procesar.addEventListener("click", function (e) {

      let file = document.getElementById("select-files-firma").files[0];
      let url = "/empresas/" + {{ $empresa->id }}+ "/firmas/procesar"
      let formData = new FormData();
      formData.append("file",file);
      formData.append("MAX_FILE_SIZE", "8388608");
      var title = "Cargando...";

      Fetchx({
              title: title,
              url: url,
              type: "POST",
              processData: false,
              contentType: false,
              headers : {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formData, 
              success: function(response) {
               console.log(response);

               containerImgFirmas.innerHTML = '';

               response.files.forEach((image) => {
                  containerImgFirmas.insertAdjacentHTML('beforeend',`
                  <div class="" style="display:grid;place-items:center;border: 1px solid var(--primary);width:100%; padding: 10px;" ><img src="/static/temporal/${image}" class="rounded " style="max-width:100%;"  alt="profile image" height="64"> </div>
                  `)
                })  

               let folder_firmas = document.querySelector("#folder_firmas");
               folder_firmas.value = response.folder;

               containerImgFirmas.style.display = "grid"; 
               //containerImgFirmas.slideDown() 
              }
            })
    })
    function removeFile(tipo){

      let formdata = new FormData();
      toastr.info("<br/><button type='button' id='confirmationButtonYes' class='btn btn-secondary clear'>Si</button> <button type='button' id='confirmationButtonCancel' class='btn btn-primary clear'>Cancelar</button> ",'¿ Esta seguro de eliminar los sellos y registros guardados ?',
        {
            closeButton: false,
            preventDuplicates: true,
            allowHtml: true,
            onShown: function (toast) {
                $("#confirmationButtonYes").click(function(){

                  console.log('clicked yes');

                  let url = "/empresas/" + {{ $empresa->id }} + "/" + tipo + "/eliminar?tipo=" + tipo ;
                    Fetchx({
                        title: "Guardando",
                        url: url,
                        type: "get",
                        processData: false,
                        contentType: false,
                        headers : {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        success: function (response) {
                          console.log("Tipo", tipo);
                          if (tipo == "sellos" ){
                            containerImgSellos.innerHTML = ''; 
                            containerImgSellos.style.display = 'none';
                            file_sello.closest('.btn').style.display = 'block';

                          } else if( tipo == "firmas" ){
                            containerImgFirmas.innerHTML = ''; 
                            containerImgFirmas.style.display = 'none';
                            file_firma.closest('.btn').style.display = 'block';
                          }

                          //containerImgFirmas.slideDown() 
                        }
                      })
                  })
                }
              })
        }

      //let containerImgFirmas  = document.querySelector(".container-firmas")
      //container.style.display = 'none';
      //let containerImgSellos  = document.querySelector(".container-sellos")

      function guardar_firmas(e) {
        let formdata = new FormData();
        let folder_firmas = document.querySelector("#folder_firmas");
        let file_firma = document.getElementById("select-files-firma").files[0];

        formdata.append("folder_firmas", folder_firmas.value )
        formdata.append("archivo_firmas", file_firma )

        formdata.append("_method", "PUT")

        let url = "/empresas/" + {{$empresa->id }};

        Fetchx({
              title: "Guardando",
              url: url,
              type: "post",
              processData: false,
              contentType: false,
              headers : {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formdata, 
              success: function (response) {
               //containerImgFirmas.slideDown() 
                file_firma.closest(".btn").style.display = 'none';
                btn_procesar.style.display = 'none';
              }
            })
    }

    function guardar_sellos(e){
      let formdata = new FormData() ;
      let folder_sellos = document.querySelector("#folder_sellos");
      let file_sello = document.getElementById("select-files-sello").files[0];
      formdata.append("folder_sellos", folder_sellos.value )
      formdata.append("archivo_sellos", file_sello )

      formdata.append("_method", "PUT")

      let url = "/empresas/" + {{$empresa->id }};

      Fetchx({
            title: "Guardando",
            url: url,
            type: "post",
            processData: false,
            contentType: false,
            headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            data: formdata, 
            success: function (response) {
              file_firma.closest(".btn").style.display = 'none';
              btn_procesar_sellos.style.display = 'none';
             //containerImgFirmas.slideDown() 
            }
          })
  }
  btn_procesar_sellos.addEventListener('click',function(e){
    e.preventDefault() 
    let file = document.getElementById("select-files-sello").files[0];
    let url = "/empresas/" + {{ $empresa->id }}+ "/sellos/procesar"
    let formData = new FormData();
    formData.append("file",file);
    formData.append("MAX_FILE_SIZE", "8388608");
    var title = "Cargando...";

    Fetchx({
            title: title,
            url: url,
            type: "POST",
            processData: false,
            contentType: false,
            headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            data: formData, 
            success: function (response) {
             console.log(response);
             containerImgSellos.innerHTML = '';
             response.files.forEach((image) => {
                containerImgSellos.insertAdjacentHTML('beforeend',`<div class=""  data-filename="" data-folder=""  style="border: 1px solid var(--primary) ;padding: 10px; display:grid;place-items:center; width: 100%; gap: 15px; justify-items: start;" ><img src="{{ config('constants.app_url') }}/static/temporal/${image}" class="rounded mr-75" style="max-width:100%; " alt="profile image" height="64"></div>`)
             })  
             let folder_sellos = document.querySelector("#folder_sellos");
             folder_sellos.value = response.folder;
             containerImgSellos.style.display = "grid"; 
             //containerImgFirmas.slideDown() 
            }
          })
    })

    function cargar_imagen(evt){
      console.log("IMAGEN", evt.target.files[0].name);
      var file =  evt.target.files[0];
      if(file){
        var reader = new FileReader();
        reader.onload = function() {
          //evt.target.closest(".media").querySelector("a > img.rounded").src = reader.result  
          //evt.target.closest(".media").querySelector("a").style.display = 'block'  

          let url = `/empresas/{{$empresa->id}}?_update=${evt.target.dataset.campo}`
          let formdata = new FormData();
          formdata.append( "value", file )
          formdata.append("_method", "PUT")

          Fetchx({
                  title: "Guardando",
                  url: url,
                  type: "post",
                  processData: false,
                  contentType: false,
                  headers : {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                  },
                  data: formdata, 
                  success: function (response) {
                   //containerImgFirmas.slideDown() 
                   console.log(response)
                  }
                })
            }
            reader.readAsDataURL(file)
          }
        }

    formEmpresa.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData  = new FormData(formEmpresa);
        let url = `/empresas/{{$empresa->id}}` 
        Fetchx({
                  title: "Guardando",
                  url: url,
                  type: "post",
                  processData: false,
                  contentType: false,
                  headers : {
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                  },
                  data: formData, 
                  success: function (response) {
                   //containerImgFirmas.slideDown() 
                   console.log(response)
                  }
                })
    }) 
    
    formRepresentante.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData  = new FormData(formRepresentante);
        let url = `/empresas/{{$empresa->id}}` 
        Fetchx({
                title: "Guardando",
                url: url,
                type: "post",
                processData: false,
                contentType: false,
                headers : {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                data: formData,
                success: function (response) {
                 //containerImgFirmas.slideDown()
                 console.log(response)
                }
              })
    }) 

    frmFavor.addEventListener('submit',(e) => {
      e.preventDefault();
      let formData = new FormData(frmFavor); 

      if (tagFavor.value  == "" ){
        return "";
      }

      Fetchx({
              url: "/etiquetas" ,
              type: "post",
              processData: false,
              contentType: false,
              headers : {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formData,
              success: function (data) {
                 if(data.status) {
                   toastr.success(data.message);
                   addTagFavor(tagFavor.value.toUpperCase(), data.id);
                   tagFavor.value = '';
                 } else {
                   toastr.warning(data.message);
                   tagFavor.value = '';
                 }
              }
            })
    })
    
    frmContra.addEventListener('submit',(e) => {
      e.preventDefault();
      let formData = new FormData(frmContra);
      
      Fetchx({
              url: "/etiquetas",
              type: "post",
              processData: false,
              contentType: false,
              headers : {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formData,
              success: function (data) {
                if(data.status) {
                   toastr.success(data.message);
                   addTagContra(tagContra.value.toUpperCase(), data.id);
                   tagContra.value = '';
                 } else {
                   toastr.warning(data.message);
                   tagContra.value = '';
                 }
              }
            });

    })
    
    function addTagFavor( tag, id ){
      var html = `<span class="bg-primary text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"> ${tag.toUpperCase()}<i class='bx bx-x' style="color:white;cursor:pointer;" data-tag="${id}"></i></span>`;
      frmFavor.insertAdjacentHTML('beforeBegin', html);
    }

    function addTagContra( tag, id  ){
      var html = `<span class="bg-danger text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;">${ tag.toUpperCase()}<i class='bx bx-x' data-tag="${id}" style="color:white;cursor:pointer;" onclick="removeTag(this)"  ></i></span>`;
      frmContra.insertAdjacentHTML( 'beforeBegin', html );
    }
    
    function removeTag(element) {

      let formData = new FormData();
      formData.append('etiqueta_id', element.dataset.tag );
      formData.append('empresa_id', <?= $empresa->id ?> );   
      formData.append("_method", "DELETE")

      Fetchx({
              title: "Guardando",
              url: "/etiquetas/" + element.dataset.tag  ,
              type: "post",
              processData: false,
              contentType: false,
              headers : {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
              data: formData,
              success: function (data) {
               
               if( data.success ) {
                 element.parentElement.remove();
                 //toastSuccess()
               }
              }
            })
    }
          
  </script>
@endsection
