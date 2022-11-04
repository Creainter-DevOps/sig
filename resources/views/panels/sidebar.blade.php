{{-- vertical-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
            <img src="{{asset('images/logo/logo-dark.png')}}" class="logo" alt="">
          </div>
          </a>
      </li>
          <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
            <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i>
          </a>
          </li>
      </ul>
      <div style="margin-top: 10px;">
        <ul class="flex-row">
          <li style="display: inline-flex;background: #00adff;padding: 0px 10px;font-size: 20px;color: #fff;" onclick="$('.actphone').addClass('visible');">
            <a href="javascript:void(0);" style="color: inherit;">
              <i class="bx bx-phone"></i>
            </a>
          </li>
        </ul>
      </div>
      </div>
      <div>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
      <!-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
          @if(!empty($menuData[0]) && isset($menuData[0]))
          @foreach ($menuData[0]->menu as $menu)
              @if(isset($menu->navheader))
                  <li class="navigation-header"><span>{{$menu->navheader}}</span></li>
              @else
              <li class="nav-item {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
              <a href="@if(isset($menu->url)){{asset($menu->url)}} @endif" @if(isset($menu->newTab)){{"target=_blank"}}@endif>
                  @if(isset($menu->icon))
                      <i class="menu-livicon" data-icon="{{$menu->icon}}"></i>
                  @endif
                  @if(isset($menu->name))
                      <span class="menu-title">{{ __('locale.'.$menu->name)}}</span>
                  @endif
                  @if(isset($menu->tag))
                  <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
                  @endif
              </a>
              
              @if(isset($menu->submenu))
                  @include('panels.sidebar-submenu',['menu' => $menu->submenu])
              @endif
              </li>
              @endif
          @endforeach
          @endif
      </ul>-->
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
        <li class="navigation-header"><span>Inicio</span></li>
                            <li class="nav-item {{(request()->is('')) ? 'active' : '' }}">
                              <a href="/">
                                <i class="menu-livicon livicon-evo-holder" data-icon="desktop"></i>
                                <span class="menu-title">Dashboard</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('actividades/calendario')) ? 'active' : '' }}">
                              <a href="/actividades/calendario">
                                <i class="menu-livicon livicon-evo-holder" data-icon="calendar"></i>
                                <span class="menu-title">Mi Calendario</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('actividades/kanban')) ? 'active' : '' }}">
                              <a href="/actividades/kanban">
                                <i class="menu-livicon livicon-evo-holder" data-icon="check"></i>
                                <span class="menu-title">Mi Kanban</span>
                              </a>
                            </li>
                            <li class="navigation-header"><span>Negocios</span></li>
                            <li class="nav-item {{(request()->is('licitaciones/workspace')) ? 'active' : '' }}">
                              <a href="/licitaciones/workspace">
                                <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                <span class="menu-title">Panel de Trabajo</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('licitaciones/participaciones')) ? 'active' : '' }}">
                              <a href="/licitaciones/participaciones">
                                <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                <span class="menu-title">Participaciones</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('licitaciones/resultados')) ? 'active' : '' }}">
                              <a href="/licitaciones/resultados">
                                <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                <span class="menu-title">Resultados</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('licitaciones/nuevas')) ? 'active' : '' }}">
                              <a href="/licitaciones/nuevas">
                                <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                <span class="menu-title">Revisar Nuevas</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('licitaciones')) ? 'active' : '' }}">
                              <a href="/licitaciones/">
                                <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                <span class="menu-title">Licitaciones</span>
                              </a>
                            </li>
                            <li class="nav-item {{(request()->is('oportunidades')) ? 'active' : '' }}">
                              <a href="/oportunidades/">
                                <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                <span class="menu-title">Oportunidades</span>
                              </a>
                            </li>
                                                        <li class="navigation-header"><span>Gestión</span></li>
                                                    <li class="nav-item {{(request()->is('proyectos'.'*')) ? 'active' : '' }}   ">
              <a href="/proyectos">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="desktop"></i>
                                                          <span class="menu-title">Proyectos</span>
                                                  </a>
                            </li>
<?php /*                                                    <li class="nav-item {{(  request()->is('oportunidades'.'*')) ? 'active' : '' }}">
              <a href="/oportunidades ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="bulb"></i>
                                                          <span class="menu-title">Oportunidades</span>
                                                  </a>
                            </li>
                            <li class="navigation-header"><span>CRM</span></li>
                                                    <li class="nav-item {{(request()->is('clientes'.'*')) ? 'active' : '' }}   ">
              <a href="/clientes ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="building"></i>
                                                          <span class="menu-title">Clientes</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('proveedores'.'*')) ? 'active' : '' }}  ">
              <a href="/proveedores ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="box"></i>
                                                          <span class="menu-title">Proveedores</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('productos'.'*')) ? 'active' : '' }}   ">
              <a href="/productos ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="box"></i>
                                                          <span class="menu-title">Productos</span>
                                                  </a>
                            </li> */ ?>
                                                    <li class="nav-item {{(request()->is('empresas'.'*')) ? 'active' : '' }}   ">
                                                        <a href="/empresas">
                                                    <i class="menu-livicon livicon-evo-holder" data-icon="diagram"></i>
                                                          <span class="menu-title">Empresas</span>
                                                  </a>
                            </li>
                            <li class="nav-item {{(request()->is('callcenter/llamadas')) ? 'active' : '' }}   ">
             <a href="/callcenter/llamadas">

                                        <i class="menu-livicon livicon-evo-holder" data-icon="phone"></i>
                                                          <span class="menu-title">Llamadas</span>
                                                  </a>
                            </li>
                            <li class="nav-item {{(request()->is('contactos')) ? 'active' : '' }}   ">
                                                  <a href="/contactos">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="user"></i>
                                                          <span class="menu-title">Contactos</span>
                                                  </a>

                            </li>
                            <?php /* 
                            <li class="navigation-header"><span>Redes</span></li>
                                                    <li class="nav-item {{(request()->is('callerids'.'*')) ? 'active' : '' }} ">
              <a href="/callerids ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="phone"></i>
                                                          <span class="menu-title">Callerids</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('contactos'.'*')) ? 'active' : '' }}    ">
              <a href="/contactos ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="users"></i>
                                                          <span class="menu-title">Contactos</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('app-email'.'*')) ? 'active' : '' }}">
              <a href="/actividades ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="check"></i>
                                                          <span class="menu-title">Actividades</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('usuarios'.'*')) ? 'active' : '' }}  ">
              <a href="/usuarios ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="user"></i>
                                                          <span class="menu-title">Usuarios</span>
                                                  </a>
                            </li> */ ?>
                            <li class="navigation-header"><span>Analisis de Datos</span></li>
                            <li class="nav-item {{(request()->is('reportes')) ? 'active' : '' }}  ">
              <a href="/reportes">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                                          <span class="menu-title">Reportes</span>
                                                  </a>
                            </li>

                            <li class="navigation-header"><span>Configuraciones</span></li>
                                
                            <li class="nav-item {{(request()->is('misempresas'.'*')) ? 'active' : '' }}   ">
                                <a href="/misempresas">
                            <i class="menu-livicon livicon-evo-holder" data-icon="diagram"></i>
                                  <span class="menu-title">Empresas</span>
                          </a>
                            </li>
                            <?php
                            /*<li class="navigation-header"><span>Acceso directo</span></li>
                            <li class="nav-item {{(request()->is('reportes')) ? 'active' : '' }}  ">
              <a href="/reportes">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                                          <span class="menu-title">RastreaPerú</span>
                                                  </a>
                            </li>
                            <li class="nav-item {{(request()->is('reportes')) ? 'active' : '' }}  ">
              <a href="/reportes">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                                          <span class="menu-title">Datos Abiertos</span>
                                                  </a>
                            </li>
                            <li class="nav-item {{(request()->is('reportes')) ? 'active' : '' }}  ">
              <a href="https://srt.sutran.gob.pe">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                                                          <span class="menu-title">SRT</span>
                                                  </a>
                            </li>
                            <li class="nav-item {{(request()->is('reportes')) ? 'active' : '' }}  ">
              <a href="https://interno.creainter.com.pe/tecnicos/unidades/">
                               <i class="menu-livicon livicon-evo-holder" data-icon="line-chart"></i>
                               <span class="menu-title">Mantenimiento</span>
                                         </a>
                            </li>*/
                            ?>  
                </ul>
        </ul>
      </div>
  </div>
@endif
{{-- horizontal-menu --}}
@if($configData['mainLayoutType'] == 'horizontal-menu')
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-light navbar-without-dd-arrow
@if($configData['navbarType'] === 'navbar-static') {{'navbar-sticky'}} @endif" role="navigation" data-menu="menu-wrapper">
  <div class="navbar-header d-xl-none d-block">
      <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
            <img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">
          </div>
          <h2 class="brand-text mb-0">
            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
            {{$configData['templateTitle']}}
            @else
            Frest
            @endif
          </h2>
          </a>
      </li>
      <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
          </a>
      </li>
      </ul>
  </div>
  <div class="shadow-bottom"></div>
  <!-- Horizontal menu content-->
  <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
      @if(!empty($menuData[1]) && isset($menuData[1]))
          @foreach ($menuData[1]->menu as $menu)
          <li class="@if(isset($menu->submenu)){{'dropdown'}} @endif nav-item" data-menu="dropdown">
          <a class="@if(isset($menu->submenu)){{'dropdown-toggle'}} @endif nav-link" href="{{asset($menu->url)}}"
            @if(isset($menu->submenu)){{'data-toggle=dropdown'}} @endif @if(isset($menu->newTab)){{"target=_blank"}}@endif>
              <i class="menu-livicon" data-icon="{{$menu->icon}}"></i>
              <span>{{ __('locale.'.$menu->name)}}</span>
          </a>
          @if(isset($menu->submenu))
              @include('panels.sidebar-submenu',['menu'=>$menu->submenu])
          @endif
          </li>
          @endforeach
      @endif
      </ul>
  </div>
  <!-- /horizontal menu content-->
  </div>
@endif

{{-- vertical-box-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu-boxicons')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
    <li class="nav-item mr-auto">
      <a class="navbar-brand" href="{{asset('/')}}">
        <div class="brand-logo">
          <img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">
        </div>
        <h2 class="brand-text mb-0">
          @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
          {{$configData['templateTitle']}}
          @else
          Frest
          @endif
        </h2>
      </a>
    </li>
    <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i></a></li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
      @if(!empty($menuData[2]) && isset($menuData[2]))
      @foreach ($menuData[2]->menu as $menu)
          @if(isset($menu->navheader))
              <li class="navigation-header"><span>{{$menu->navheader}}</span></li>
          @else
          <li class="nav-item {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
            <a href="@if(isset($menu->url)){{asset($menu->url)}} @endif" @if(isset($menu->newTab)){{"target=_blank"}}@endif>
            @if(isset($menu->icon))
              <i class="{{$menu->icon}}"></i>
            @endif
            @if(isset($menu->name))
              <span class="menu-title"> * {{ __('locale.'.$menu->name)}}</span>
            @endif
            @if(isset($menu->tag))
              <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
            @endif
           </a>
          @if(isset($menu->submenu))
            @include('panels.sidebar-submenu',['menu' => $menu->submenu])
          @endif
          </li>
          @endif
      @endforeach
      @endif
  </ul>
  </div>
</div>
@endif
