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
        <li class="nav-item has-sub {{(request()->is('#'.'*')) ? 'active' : '' }}"    >
          <a href="#"  >
            <i class="menu-livicon livicon-evo-holder" data-icon="desktop" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">

		<g class="lievo-lineicon">
			<polygon fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="37,51 23,51 25,45 35,45" style=""></polygon>
			<line fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="21" y1="51" x2="39" y2="51" style=""></line>
			<circle class="lievo-likestroke lievo-altstroke" fill="#8494a7" cx="30" cy="41" r="2" stroke="none" style="stroke-width: 0;"></circle>
			<defs>
				<clipPath id="livicon_desktop_l_3">
					<path class="lievo-donotdraw lievo-nohovercolor lievo-nohoverstroke" d="M7,37V11c0-1.1,0.9-2,2-2h42c1.1,0,2,0.9,2,2v26H7z" stroke="none" fill="none" style="stroke-width: 0;"></path>
				</clipPath>
			</defs>
			<g clip-path="url(#livicon_desktop_l_3)">
				<g opacity="0">
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="6" y="8" opacity="0.5" fill="#8494a7" width="48" height="30" stroke="none" style="stroke-width: 0;"></rect>
				</g>
			</g>
			<line fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="7" y1="37" x2="53" y2="37" style=""></line>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M51,45H9c-1.1,0-2-0.9-2-2V11c0-1.1,0.9-2,2-2h42c1.1,0,2,0.9,2,2v32C53,44.1,52.1,45,51,45z" style=""></path>
		</g>

		<g class="lievo-common" opacity="0" style="opacity: 0;">
			<rect class="lievo-donotdraw lievo-likestroke" x="10" y="12" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
			<rect class="lievo-donotdraw lievo-likestroke" x="10" y="18" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
			<rect class="lievo-donotdraw lievo-likestroke" x="10" y="24" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
			<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="10" y="30" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg>
</div></i>
                                                          <span class="menu-title">Dashboard</span>
                                                      <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">2</span>
                                </a>
                                <ul class="menu-content">
                        <li>
            <a href=" https://sig.creainter.com.pe/ ">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">eCommerce</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/dashboard-analytics ">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Analytics</span>
            </a>
                      </li>
                </ul>



                            </li>
                                                        <li class="navigation-header"><span>Licitaciones</span></li>
                                                    <li class="nav-item {{(request()->is('licitaciones')) ? 'active' : '' }}">
              <a href="https://sig.creainter.com.pe/licitaciones ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="line-chart" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-solidshift="xy" data-animoptions="{'duration':'1.4', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.203125px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<polyline class="lievo-altstroke" fill="none" stroke="#5a8dee" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="7,37.2 7,37 21,25 37,33 51,15" style=""></polyline>

			<line fill="none" stroke="#5a8dee" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="7" y1="47" x2="53" y2="47" style=""></line>

			<line fill="none" stroke="#5a8dee" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="7" y1="47" x2="7" y2="11" style=""></line>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#5a8dee" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Dashboard</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('licitaciones/nuevas'.'*')) ? 'active' : '' }} ">
              <a href="https://sig.creainter.com.pe/licitaciones/nuevas ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="search" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1.2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.203125px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<defs>
				<mask id="livicon_search_1">
					<path class="lievo-donotdraw lievo-nohovercolor lievo-savefill" fill="#ffffff" stroke="none" d="M13.69,13.69C16.58,10.79,20.58,9,25,9c8.83,0,16,7.16,16,16c0,8.83-7.17,16-16,16c-8.84,0-16-7.17-16-16C9,20.58,10.79,16.58,13.69,13.69z"></path>
				</mask>
			</defs>

			<path fill="none" stroke="#8494a7" stroke-width="0px" d="M13.69,13.69C16.58,10.79,20.58,9,25,9c8.83,0,16,7.16,16,16c0,8.83-7.17,16-16,16c-8.84,0-16-7.17-16-16C9,20.58,10.79,16.58,13.69,13.69z" style=""></path>

			<g mask="url(#livicon_search_1)">
				<path class="lievo-donotdraw lievo-likestroke lievo-altstroke lievo-solidbg" fill="#8494a7" stroke="none" d="M64.39,34h-3.63v-3.6h-10.9V34h-3.63V21.4c0-3.6,1.81-5.4,5.45-5.4h7.26c3.63,0,5.45,1.8,5.45,5.4V34z M60.76,26.8v-5.4c0-1.2-0.6-1.8-1.81-1.8h-7.26c-1.21,0-1.82,0.6-1.82,1.8v5.4H60.76z M84.37,28.6c0,3.6-1.82,5.4-5.45,5.4H66.21V16h12.71c3.61,0,5.43,1.79,5.45,5.37c0,1.66-0.38,2.86-1.15,3.6C83.98,25.75,84.37,26.96,84.37,28.6z M80.73,21.4c0-1.2-0.6-1.8-1.81-1.8h-9.08v3.6h9.08C80.13,23.2,80.73,22.6,80.73,21.4zM80.73,28.6c0-1.2-0.6-1.8-1.81-1.8h-9.08v3.6h9.08C80.13,30.4,80.73,29.8,80.73,28.6z M104.35,34H91.63c-3.63,0-5.45-1.8-5.45-5.4v-7.2c0-3.6,1.82-5.4,5.45-5.4h12.71v3.6H91.63c-1.21,0-1.82,0.6-1.82,1.8v7.2c0,1.2,0.61,1.8,1.82,1.8h12.71V34z" style="" data-svg-origin="46.22999954223633 16" transform="matrix(1,0,0,1,0,0)"></path>
			</g>
		</g>
		<g class="lievo-filledicon lievo-lineicon">
			<g>
				<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="36.31" y1="36.31" x2="52" y2="52" style=""></line>
				<path class="lievo-savelinecap" fill="none" stroke-linecap="butt" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M13.69,13.69C16.58,10.79,20.58,9,25,9c8.83,0,16,7.16,16,16c0,8.83-7.17,16-16,16c-8.84,0-16-7.17-16-16C9,20.58,10.79,16.58,13.69,13.69z" style=""></path>
			</g>
		</g>

	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Nuevas</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{  (request()->is('licitaciones/archivadas'.'*')) ? 'active' : '' }}">
              <a href="https://sig.creainter.com.pe/licitaciones/archivadas ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="box" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.203125px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<g>
				<defs>
					<clipPath id="livicon_box_line_6">
						<rect class="lievo-donotdraw lievo-nohovercolor" fill="none" stroke="none" x="10" y="-17" width="40" height="40" style=""></rect>
					</clipPath>
				</defs>
				<g clip-path="url(#livicon_box_line_6)">
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="16" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="0.8" style=""></rect>
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="14" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="0.9" style=""></rect>
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="12" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="1" style=""></rect>
				</g>
			</g>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,23h21v23c0,1.66-1.34,3-3,3H12c-1.66,0-3-1.34-3-3V23H30" style=""></path>
			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="35" y1="29" x2="25" y2="29" style=""></line>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,11h20c1.66,0,3,1.34,3,3v9H7v-9c0-1.66,1.34-3,3-3H30" style="" data-svg-origin="7 23" transform="matrix(1,0,0,1,0,0)"></path>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Archivadas</span>
                                                  </a>
                            </li>
                                                        <li class="navigation-header"><span>Apps</span></li>
                                                    <li class="nav-item {{(request()->is('proyectos'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/proyectos ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="desktop" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<polygon fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="37,51 23,51 25,45 35,45" style=""></polygon>
			<line fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="21" y1="51" x2="39" y2="51" style=""></line>
			<circle class="lievo-likestroke lievo-altstroke" fill="#8494a7" cx="30" cy="41" r="2" stroke="none" style="stroke-width: 0;"></circle>
			<defs>
				<clipPath id="livicon_desktop_l_9">
					<path class="lievo-donotdraw lievo-nohovercolor lievo-nohoverstroke" d="M7,37V11c0-1.1,0.9-2,2-2h42c1.1,0,2,0.9,2,2v26H7z" stroke="none" fill="none" style="stroke-width: 0;"></path>
				</clipPath>
			</defs>
			<g clip-path="url(#livicon_desktop_l_9)">
				<g opacity="0">
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="6" y="8" opacity="0.5" fill="#8494a7" width="48" height="30" stroke="none" style="stroke-width: 0;"></rect>
				</g>
			</g>
			<line fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="7" y1="37" x2="53" y2="37" style=""></line>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M51,45H9c-1.1,0-2-0.9-2-2V11c0-1.1,0.9-2,2-2h42c1.1,0,2,0.9,2,2v32C53,44.1,52.1,45,51,45z" style=""></path>
		</g>



		<g class="lievo-common" opacity="0" style="opacity: 0;">
			<rect class="lievo-donotdraw lievo-likestroke" x="10" y="12" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
			<rect class="lievo-donotdraw lievo-likestroke" x="10" y="18" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
			<rect class="lievo-donotdraw lievo-likestroke" x="10" y="24" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
			<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="10" y="30" fill="#8494a7" width="4" height="4" stroke="none" style="stroke-width: 0;"></rect>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Proyectos</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(  request()->is('oportunidades'.'*')) ? 'active' : '' }}">
              <a href="https://sig.creainter.com.pe/oportunidades ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="bulb" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'0.7', 'repeat':'2', 'repeatDelay':'0'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,45h5v2c0,2.21-2,3-3,4h-4c-1-1-3-1.79-3-4v-2H30" style=""></path>

			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-linejoin="round" stroke-miterlimit="10" d="M25,41c0-4.58-6-8.92-6-15c0-6.07,4.93-11,11-11c6.08,0,11,4.93,11,11c0,6.08-6,10.42-6,15" style=""></path>

			<path class="lievo-savelinecap lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M30,37l-5-12l3,2l2-2l2,2l3-2L30,37" style=""></path>
		</g>



		<g class="lievo-common" style="" data-svg-origin="9.260000228881836 5">
			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="17.37" y1="37.38" x2="14.39" y2="40.05" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="13.21" y1="28.66" x2="9.26" y2="29.28" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="14.47" y1="19.08" x2="10.82" y2="17.46" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="20.74" y1="11.74" x2="18.56" y2="8.39" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="30" y1="9" x2="30" y2="5" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="39.26" y1="11.74" x2="41.44" y2="8.39" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="45.53" y1="19.08" x2="49.18" y2="17.46" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="46.79" y1="28.66" x2="50.74" y2="29.29" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>

			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="42.63" y1="37.37" x2="45.61" y2="40.05" style="stroke-dashoffset: 0; stroke-dasharray: none;"></line>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Oportunidades</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('clientes'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/clientes ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="building" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<defs>
				<clipPath id="livicon_building_f_l_11">
					<rect class="lievo-donotdraw lievo-nohovercolor lievo-nohoverstroke" x="40" width="20" height="60" stroke="none" fill="none" style="stroke-width: 0;"></rect>
				</clipPath>
			</defs>
			<g style="" data-svg-origin="9 7" transform="matrix(1,0,0,1,0,0)">
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="23,7 37,7 37,53 27,53 27,41 19,41 19,53 9,53 9,7 23,7" style=""></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="17,25 21,25 21,35 13,35 13,25 17,25" style="opacity: 1;"></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="29,25 33,25 33,35 25,35 25,25 29,25" style="opacity: 1;"></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="17,11 21,11 21,21 13,21 13,11 17,11" style="opacity: 1;"></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="29,11 33,11 33,21 25,21 25,11 29,11" style="opacity: 1;"></polyline>
			</g>
			<g clip-path="url(#livicon_building_f_l_11)">
				<g style="" data-svg-origin="37 11" transform="matrix(1,0,0,1,0,0)">
					<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="40,11 51,11 51,53 43,53 43,43 37,43 37,11 40,11" style=""></polyline>
					<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="45,15 47,15 47,23 43,23 43,15 45,15" style="opacity: 1;"></polyline>
					<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="45,27 47,27 47,35 43,35 43,27 45,27" style="opacity: 1;"></polyline>
				</g>
			</g>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Clientes</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('proveedores'.'*')) ? 'active' : '' }}  ">
              <a href="https://sig.creainter.com.pe/proveedores ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="box" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<g>
				<defs>
					<clipPath id="livicon_box_line_14">
						<rect class="lievo-donotdraw lievo-nohovercolor" fill="none" stroke="none" x="10" y="-17" width="40" height="40" style=""></rect>
					</clipPath>
				</defs>
				<g clip-path="url(#livicon_box_line_14)">
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="16" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="0.8" style=""></rect>
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="14" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="0.9" style=""></rect>
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="12" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="1" style=""></rect>
				</g>
			</g>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,23h21v23c0,1.66-1.34,3-3,3H12c-1.66,0-3-1.34-3-3V23H30" style=""></path>
			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="35" y1="29" x2="25" y2="29" style=""></line>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,11h20c1.66,0,3,1.34,3,3v9H7v-9c0-1.66,1.34-3,3-3H30" style=""></path>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Proveedores</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('productos'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/productos ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="box" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<g>
				<defs>
					<clipPath id="livicon_box_line_17">
						<rect class="lievo-donotdraw lievo-nohovercolor" fill="none" stroke="none" x="10" y="-17" width="40" height="40" style=""></rect>
					</clipPath>
				</defs>
				<g clip-path="url(#livicon_box_line_17)">
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="16" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="0.8" style=""></rect>
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="14" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="0.9" style=""></rect>
					<rect class="lievo-donotdraw lievo-likestroke lievo-altstroke" x="12" y="23" fill="#8494a7" stroke="none" width="32" height="26" opacity="1" style=""></rect>
				</g>
			</g>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,23h21v23c0,1.66-1.34,3-3,3H12c-1.66,0-3-1.34-3-3V23H30" style=""></path>
			<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="35" y1="29" x2="25" y2="29" style=""></line>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,11h20c1.66,0,3,1.34,3,3v9H7v-9c0-1.66,1.34-3,3-3H30" style=""></path>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Productos</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('empresas'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/empresas ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="diagram" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<g>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,29h13c1.1,0,2,0.9,2,2v8" style=""></path>
				<rect x="41" y="39" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="10" height="10" style=""></rect>
			</g>
			<g>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,29H17c-1.1,0-2,0.9-2,2v8" style=""></path>
				<rect x="9" y="39" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="10" height="10" style=""></rect>
			</g>
			<g>
				<line fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="30" y1="21" x2="30" y2="39" style=""></line>
				<rect class="lievo-altstroke" x="25" y="39" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="10" height="10" style=""></rect>
			</g>

			<rect x="25" y="11" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="10" height="10" style=""></rect>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Empresas</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('callerids'.'*')) ? 'active' : '' }} ">
              <a href="https://sig.creainter.com.pe/callerids ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="phone" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'0.6', 'repeat':'3', 'repeatDelay':'0'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M19.35,40.65C30.53,51.83,39.32,52.96,42.22,53c0.56,0.01,1.35-0.37,1.74-0.77l6.52-6.51c0.8-0.8,0.67-1.93-0.29-2.53l-8.11-5.07c-0.96-0.6-2.38-0.44-3.18,0.36l-2.49,2.49c-0.8,0.8-2.26,1.02-3.22,0.42c-2.35-1.46-5.06-3.54-8.05-6.53c-2.98-2.98-5.07-5.7-6.53-8.04c-0.6-0.96-0.38-2.42,0.42-3.22l2.49-2.49c0.8-0.8,0.96-2.22,0.36-3.18l-5.07-8.11c-0.6-0.96-1.73-1.09-2.53-0.29l-6.52,6.52c-0.4,0.4-0.77,1.18-0.77,1.75C7.03,20.68,8.17,29.47,19.35,40.65z" style=""></path>

			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,28c1.1,0,2,0.9,2,2" opacity="0" style=""></path>

			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,21c4.97,0,9,4.03,9,9" style=""></path>

			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,15c8.28,0,15,6.72,15,15" style=""></path>

			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,9c11.6,0,21,9.4,21,21" style=""></path>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Callerids</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('contactos'.'*')) ? 'active' : '' }}    ">
              <a href="https://sig.creainter.com.pe/contactos ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="users" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,49h4c0-1.9,0-7.18,0-7.18c-1.52-1.59-11.73-3.89-11.92-6.82v-3.37c1.66-0.94,1.94-3.74,2.16-4.75c1.93-0.21,2.28-3.93,0.95-4.74c0.6-1.74,1.25-6.47,0.43-8.32c-0.74-1.67-2.27-4.33-6.4-4.82H38" style=""></path>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M26,7c-2.15,0.04-4.17,0.25-4.8,2c-2.63-0.06-3.25,1.44-4.2,3.58s-0.39,7.72,0.3,9.73c-1.54,0.94-1.04,5.44,1.2,5.58c0.26,1.17,0.48,4.22,2.4,5.3v3.9C20.83,40.5,8.76,43.16,7,45c0,0,0,3.55,0,6h38c0-2.2,0-6,0-6c-1.76-1.84-13.58-4.5-13.8-7.9v-3.9c1.92-1.08,2.25-4.33,2.5-5.5c2.24-0.25,2.64-4.55,1.1-5.48c0.69-2.02,1.45-7.49,0.5-9.63S32,7,26,7z" style=""></path>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Contactos</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('documentos'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/documentos ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="file-export" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<g>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,7h9l10,10v36H13V7H30z" style=""></path>
				<polyline class="lievo-savelinecap" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" points="39,7.5 39,17 48.5,17" style=""></polyline>
			</g>
			<g>
				<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="31" y1="24.7" x2="31" y2="41" style=""></line>
				<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="23,31 31,23 39,31" style=""></polyline>
			</g>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Documentos</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('empresas/misempresas'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/misempresas ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="building" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<defs>
				<clipPath id="livicon_building_f_l_19">
					<rect class="lievo-donotdraw lievo-nohovercolor lievo-nohoverstroke" x="40" width="20" height="60" stroke="none" fill="none" style="stroke-width: 0;"></rect>
				</clipPath>
			</defs>
			<g>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="23,7 37,7 37,53 27,53 27,41 19,41 19,53 9,53 9,7 23,7" style=""></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="17,25 21,25 21,35 13,35 13,25 17,25" style=""></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="29,25 33,25 33,35 25,35 25,25 29,25" style=""></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="17,11 21,11 21,21 13,21 13,11 17,11" style=""></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="29,11 33,11 33,21 25,21 25,11 29,11" style=""></polyline>
			</g>
			<g clip-path="url(#livicon_building_f_l_19)">
				<g>
					<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="40,11 51,11 51,53 43,53 43,43 37,43 37,11 40,11" style=""></polyline>
					<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="45,15 47,15 47,23 43,23 43,15 45,15" style=""></polyline>
					<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="45,27 47,27 47,35 43,35 43,27 45,27" style=""></polyline>
				</g>
			</g>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Mis Empresas</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('app-email'.'*')) ? 'active' : '' }}">
              <a href="https://sig.creainter.com.pe/actividades ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="check" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'0.6', 'repeat':'0', 'repeatDelay':'0.4'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<polyline class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="14,30 25,41 47,19" style=""></polyline>
		</g>

	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Actividades</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item  ">
              <a href="https://sig.creainter.com.pe/app-email ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="envelope-pull" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<defs>
				<mask id="livicon_envelope_pull_filled_21">
					<polygon class="lievo-donotdraw lievo-nohovercolor lievo-savefill" fill="#ffffff" stroke="none" points="56,12 38,30 22,30 4,12 4,-12 56,-12"></polygon>
				</mask>
			</defs>
			<g>
				<path fill="none" stroke="#8494a7" stroke-width="0px" d="M53,43c0,1.1-0.9,2-2,2H9c-1.1,0-2-0.9-2-2V17c0-1.1,0.9-2,2-2h42c1.1,0,2,0.9,2,2V43z" style=""></path>

				<g>
					<line class="lievo-savelinecap lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="22" y1="30" x2="7.59" y2="44.41" style=""></line>
					<line class="lievo-savelinecap lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="52.41" y1="44.41" x2="38" y2="30" style=""></line>
				</g>
				<g opacity="0">
					<line class="lievo-donotdraw lievo-savelinecap lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="22" y1="30" x2="7.59" y2="15.59" style=""></line>
					<line class="lievo-donotdraw lievo-savelinecap lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="38" y1="30" x2="52.41" y2="15.59" style=""></line>
				</g>

				<line class="lievo-donotdraw lievo-savelinecap lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="22" y1="30" x2="38" y2="30" opacity="0" style=""></line>

				<path class="lievo-savelinecap" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M30,15h21c0.81,0,1.41,0.59,1.41,0.59L33.54,34.46c-1.95,1.95-5.12,1.95-7.07,0L7.59,15.59c0,0,0.59-0.59,1.41-0.59H30z" style=""></path>

				<path fill="none" stroke="#8494a7" stroke-width="3.25px" d="M30,15h21c1.1,0,2,0.9,2,2v26c0,1.1-0.9,2-2,2H9c-1.1,0-2-0.9-2-2V17c0-1.1,0.9-2,2-2H30z" style=""></path>

				<g mask="url(#livicon_envelope_pull_filled_21)">
					<g opacity="0">
						<rect class="lievo-donotdraw lievo-nohovercolor lievo-savefill" fill="#ECF0F1" x="10" y="30" width="40" height="26" stroke="none" style="stroke-width: 0;"></rect>
					</g>
				</g>
			</g>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Email</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('app-calendar'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/app-calendar ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="calendar" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1.6', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-filledicon lievo-lineicon">
			<g>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,51H11c-1.1,0-2-0.9-2-2V23h42v26C51,50.1,50.1,51,49,51z" style=""></path>
				<path class="lievo-likestroke lievo-altstroke" fill="#8494a7" d="M22.17,41.67c0.52,0.33,1.73,0.85,3,0.85c2.35,0,3.08-1.5,3.06-2.62c-0.02-1.9-1.73-2.71-3.5-2.71h-1.02v-1.37h1.02c1.33,0,3.02-0.69,3.02-2.29c0-1.08-0.69-2.04-2.38-2.04c-1.08,0-2.12,0.48-2.71,0.9l-0.48-1.33C22.9,30.52,24.27,30,25.73,30c2.67,0,3.88,1.58,3.88,3.23c0,1.4-0.83,2.58-2.5,3.19v0.04c1.67,0.33,3.02,1.58,3.02,3.48c0,2.17-1.69,4.06-4.94,4.06c-1.52,0-2.85-0.48-3.52-0.92L22.17,41.67z" stroke="none" style="stroke-width: 0;"></path>
				<path class="lievo-likestroke lievo-altstroke" fill="#8494a7" d="M36.17,31.77h-0.04l-2.43,1.31l-0.37-1.44L36.38,30H38v14h-1.83V31.77z" stroke="none" style="stroke-width: 0;"></path>
			</g>
			<g opacity="0">
				<path class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,51H11c-1.1,0-2-0.9-2-2V23h42v26C51,50.1,50.1,51,49,51z" style=""></path>
				<path class="lievo-donotdraw lievo-likestroke lievo-altstroke" fill="#8494a7" d="M30.17,31.77h-0.04l-2.43,1.31l-0.37-1.44L30.38,30H32v14h-1.83V31.77z" stroke="none" style="stroke-width: 0;"></path>
			</g>
			<g opacity="0">
				<path class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,51H11c-1.1,0-2-0.9-2-2V23h42v26C51,50.1,50.1,51,49,51z" style=""></path>
				<path class="lievo-donotdraw lievo-likestroke lievo-altstroke" fill="#8494a7" d="M25.61,44v-1.14l1.46-1.42c3.52-3.34,5.1-5.12,5.13-7.2c0-1.4-0.68-2.69-2.73-2.69c-1.25,0-2.29,0.63-2.92,1.16l-0.59-1.31c0.95-0.81,2.31-1.4,3.9-1.4c2.97,0,4.21,2.03,4.21,4c0,2.54-1.84,4.6-4.74,7.39l-1.1,1.02v0.04h6.18V44H25.61z" stroke="none" style="stroke-width: 0;"></path>
			</g>
			<g opacity="0">
				<path class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,51H11c-1.1,0-2-0.9-2-2V23h42v26C51,50.1,50.1,51,49,51z" style=""></path>
				<path class="lievo-donotdraw lievo-likestroke lievo-altstroke" fill="#8494a7" d="M26.27,41.67c0.52,0.33,1.73,0.85,3,0.85c2.35,0,3.08-1.5,3.06-2.62c-0.02-1.9-1.73-2.71-3.5-2.71h-1.02v-1.37h1.02c1.33,0,3.02-0.69,3.02-2.29c0-1.08-0.69-2.04-2.37-2.04c-1.08,0-2.12,0.48-2.71,0.9l-0.48-1.33C27,30.52,28.38,30,29.83,30c2.67,0,3.88,1.58,3.88,3.23c0,1.4-0.83,2.58-2.5,3.19v0.04c1.67,0.33,3.02,1.58,3.02,3.48c0,2.17-1.69,4.06-4.94,4.06c-1.52,0-2.85-0.48-3.52-0.92L26.27,41.67z" stroke="none" style="stroke-width: 0;"></path>
			</g>
			<g>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="19,13 19,9 15,9 15,13" style=""></polyline>
				<polyline fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" points="45,13 45,9 41,9 41,13" style=""></polyline>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,13h-4v4h-4v-4H19v4h-4v-4h-4c-1.1,0-2,0.9-2,2v8h42v-8C51,13.9,50.1,13,49,13z" style=""></path>
			</g>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Calendar</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('usuarios'.'*')) ? 'active' : '' }}  ">
              <a href="https://sig.creainter.com.pe/usuarios ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="user" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: 0.40625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M30,7c-2.15,0.04-4.17,0.25-4.8,2c-2.63-0.06-3.25,1.44-4.2,3.58s-0.39,7.72,0.3,9.73c-1.54,0.94-1.04,5.44,1.2,5.58c0.26,1.17,0.48,4.22,2.4,5.3v3.9C24.83,40.5,12.76,43.16,11,45s-2.08,3.75-2,6h42c0.08-2.25-0.24-4.16-2-6s-13.58-4.5-13.8-7.9v-3.9c1.92-1.08,2.25-4.33,2.5-5.5c2.24-0.25,2.64-4.55,1.1-5.48c0.69-2.02,1.45-7.49,0.5-9.63S36,7,30,7z" style=""></path>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Usuarios</span>
                                                  </a>
                            </li>
                                                        <li class="navigation-header"><span>Pages</span></li>
                                                    <li class="nav-item {{(request()->is('page-user-profile'.'*')) ? 'active' : '' }}   ">
              <a href="https://sig.creainter.com.pe/page-user-profile ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="user" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M30,7c-2.15,0.04-4.17,0.25-4.8,2c-2.63-0.06-3.25,1.44-4.2,3.58s-0.39,7.72,0.3,9.73c-1.54,0.94-1.04,5.44,1.2,5.58c0.26,1.17,0.48,4.22,2.4,5.3v3.9C24.83,40.5,12.76,43.16,11,45s-2.08,3.75-2,6h42c0.08-2.25-0.24-4.16-2-6s-13.58-4.5-13.8-7.9v-3.9c1.92-1.08,2.25-4.33,2.5-5.5c2.24-0.25,2.64-4.55,1.1-5.48c0.69-2.02,1.45-7.49,0.5-9.63S36,7,30,7z" style=""></path>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">User Profile</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('page-faq'.'*')) ? 'active' : '' }}  ">
              <a href="https://sig.creainter.com.pe/page-faq ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="question-alt" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-shift="x" data-animoptions="{'duration':'0.6', 'repeat':'1', 'repeatDelay':'0.2'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="31.625 30" transform="matrix(1,0,0,1,-1.6250000000000009,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="common">
			<g>
				<circle transform="rotate(-90, 30, 30)" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" cx="30" cy="30" r="23" style=""></circle>
				<rect class="lievo-likestroke lievo-altstroke lievo-solidbg" x="29.95" y="42.95" fill="#8494a7" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="0.1" height="0.1" style=""></rect>
				<path class="lievo-altstroke lievo-solidbg" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,37v-1.71c0.07-1.13,0.4-2.11,1.71-3.43C33.43,30.14,36,27.57,36,25c0-3.79-2.57-6-6-6c-3.43,0-6,2.5-6,5.92L24,25" style=""></path>
				<g opacity="0">
					<rect class="lievo-likestroke lievo-altstroke lievo-solidbg" x="29.95" y="42.95" fill="#8494a7" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="0.1" height="0.1" style=""></rect>
					<path class="lievo-altstroke lievo-solidbg" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,37v-1.71c0.07-1.13,0.4-2.11,1.71-3.43C33.43,30.14,36,27.57,36,25c0-3.79-2.57-6-6-6c-3.43,0-6,2.5-6,5.92L24,25" style=""></path>
				</g>
			</g>
		</g>
	<rect x="-20" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">FAQ</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('page-knowledge-base'.'*')) ? 'active' : '' }} ">
              <a href="https://sig.creainter.com.pe/page-knowledge-base ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="info-alt" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-shift="x" data-animoptions="{'duration':'0.6', 'repeat':'1', 'repeatDelay':'0.2'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="31.625 30" transform="matrix(1,0,0,1,-1.6250000000000009,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="common">
			<g>
				<circle transform="rotate(-90, 30, 30)" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" cx="30" cy="30" r="23" style=""></circle>
				<line class="lievo-altstroke lievo-solidbg" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="30" y1="27" x2="30" y2="39" style=""></line>
				<rect class="lievo-likestroke lievo-altstroke lievo-solidbg" x="29.95" y="20.95" fill="#8494a7" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="0.1" height="0.1" style=""></rect>
				<g opacity="0">
					<line class="lievo-altstroke lievo-solidbg" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="30" y1="27" x2="30" y2="39" style=""></line>
					<rect class="lievo-likestroke lievo-altstroke lievo-solidbg" x="29.95" y="20.95" fill="#8494a7" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" width="0.1" height="0.1" style=""></rect>
				</g>
			</g>
		</g>
	<rect x="-20" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Knowledge Base</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('page-search'.'*')) ? 'active' : '' }}  ">
              <a href="https://sig.creainter.com.pe/page-search ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="search" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1.2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<defs>
				<mask id="livicon_search_24">
					<path class="lievo-donotdraw lievo-nohovercolor lievo-savefill" fill="#ffffff" stroke="none" d="M13.69,13.69C16.58,10.79,20.58,9,25,9c8.83,0,16,7.16,16,16c0,8.83-7.17,16-16,16c-8.84,0-16-7.17-16-16C9,20.58,10.79,16.58,13.69,13.69z"></path>
				</mask>
			</defs>

			<path fill="none" stroke="#8494a7" stroke-width="0px" d="M13.69,13.69C16.58,10.79,20.58,9,25,9c8.83,0,16,7.16,16,16c0,8.83-7.17,16-16,16c-8.84,0-16-7.17-16-16C9,20.58,10.79,16.58,13.69,13.69z" style=""></path>

			<g mask="url(#livicon_search_24)">
				<path class="lievo-donotdraw lievo-likestroke lievo-altstroke lievo-solidbg" fill="#8494a7" stroke="none" d="M64.39,34h-3.63v-3.6h-10.9V34h-3.63V21.4c0-3.6,1.81-5.4,5.45-5.4h7.26c3.63,0,5.45,1.8,5.45,5.4V34z M60.76,26.8v-5.4c0-1.2-0.6-1.8-1.81-1.8h-7.26c-1.21,0-1.82,0.6-1.82,1.8v5.4H60.76z M84.37,28.6c0,3.6-1.82,5.4-5.45,5.4H66.21V16h12.71c3.61,0,5.43,1.79,5.45,5.37c0,1.66-0.38,2.86-1.15,3.6C83.98,25.75,84.37,26.96,84.37,28.6z M80.73,21.4c0-1.2-0.6-1.8-1.81-1.8h-9.08v3.6h9.08C80.13,23.2,80.73,22.6,80.73,21.4zM80.73,28.6c0-1.2-0.6-1.8-1.81-1.8h-9.08v3.6h9.08C80.13,30.4,80.73,29.8,80.73,28.6z M104.35,34H91.63c-3.63,0-5.45-1.8-5.45-5.4v-7.2c0-3.6,1.82-5.4,5.45-5.4h12.71v3.6H91.63c-1.21,0-1.82,0.6-1.82,1.8v7.2c0,1.2,0.61,1.8,1.82,1.8h12.71V34z" style=""></path>
			</g>
		</g>
		<g class="lievo-filledicon lievo-lineicon">
			<g>
				<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="36.31" y1="36.31" x2="52" y2="52" style=""></line>
				<path class="lievo-savelinecap" fill="none" stroke-linecap="butt" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M13.69,13.69C16.58,10.79,20.58,9,25,9c8.83,0,16,7.16,16,16c0,8.83-7.17,16-16,16c-8.84,0-16-7.17-16-16C9,20.58,10.79,16.58,13.69,13.69z" style=""></path>
			</g>
		</g>

	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Search</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item {{(request()->is('page-account-settings'.'*')) ? 'active' : '' }}">
              <a href="https://sig.creainter.com.pe/page-account-settings ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="wrench" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<path class="lievo-donotdraw lievo-likestroke" fill="#8494a7" d="M42.16,17.84L41,13.34L44.35,10l4.5,1.16l1.16,4.5L46.65,19L42.16,17.84z M46.91,13.09c-0.78-0.78-2.05-0.78-2.83,0c-0.78,0.78-0.78,2.05,0,2.83c0.78,0.78,2.05,0.78,2.83,0S47.7,13.87,46.91,13.09z" opacity="0" stroke="none" style="stroke-width: 0;"></path>
			<g>
				<path class="lievo-savelinecap" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M38.42,25.8L16.55,50.36c-0.73,0.83-1.96,0.86-2.74,0.08l-4.24-4.24c-0.78-0.78-0.75-2.01,0.08-2.74l24.53-21.89" style=""></path>
				<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M40,20l6.9,2.1l4.7-4.71c0.78-0.78,1.5-0.52,1.39,0.58c-0.23,2.2-1.19,4.34-2.87,6.03c-3.9,3.91-10.24,3.91-14.14,0c-3.9-3.91-3.9-10.24,0-14.14c1.68-1.68,3.81-2.62,6.01-2.85c1.1-0.11,1.36,0.62,0.58,1.4l-4.66,4.66L40,20z" style=""></path>
			</g>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Account Settings</span>
                                                  </a>
                            </li>
                                                    <li class="nav-item has-sub   ">
              <a href="# ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="users" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1', 'repeat':'0', 'repeatDelay':'0.5'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">


		<g class="lievo-lineicon">
			<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M49,49h4c0-1.9,0-7.18,0-7.18c-1.52-1.59-11.73-3.89-11.92-6.82v-3.37c1.66-0.94,1.94-3.74,2.16-4.75c1.93-0.21,2.28-3.93,0.95-4.74c0.6-1.74,1.25-6.47,0.43-8.32c-0.74-1.67-2.27-4.33-6.4-4.82H38" style=""></path>
			<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M26,7c-2.15,0.04-4.17,0.25-4.8,2c-2.63-0.06-3.25,1.44-4.2,3.58s-0.39,7.72,0.3,9.73c-1.54,0.94-1.04,5.44,1.2,5.58c0.26,1.17,0.48,4.22,2.4,5.3v3.9C20.83,40.5,8.76,43.16,7,45c0,0,0,3.55,0,6h38c0-2.2,0-6,0-6c-1.76-1.84-13.58-4.5-13.8-7.9v-3.9c1.92-1.08,2.25-4.33,2.5-5.5c2.24-0.25,2.64-4.55,1.1-5.48c0.69-2.02,1.45-7.49,0.5-9.63S32,7,26,7z" style=""></path>
		</g>


	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">User</span>
                                                  </a>
                                <ul class="menu-content">
                        <li>
            <a href=" https://sig.creainter.com.pe/page-users-list ">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">List</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/page-users-view ">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">View</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/page-users-edit ">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Edit</span>
            </a>
                      </li>
                </ul>



                            </li>
                                                    <li class="nav-item has-sub">
              <a href="# ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="unlock" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'1.4', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g>
			<g class="lievo-common">
				<defs>
					<clipPath id="livicon_unlock_23">
						<rect class="lievo-donotdraw lievo-savefill" x="15" y="-15" width="30" height="40" stroke="none" fill="none" style="stroke-width: 0;"></rect>
					</clipPath>
				</defs>
			</g>


			<g class="lievo-lineicon">
				<g clip-path="url(#livicon_unlock_23)">
					<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M21,17v-1c0-4.97,4.03-9,9-9c4.97,0,9,4.03,9,9v22" style=""></path>
				</g>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,25h13.13c1.03,0,1.88,0.9,1.88,2v22c0,1.1-0.84,2-1.88,2H16.88C15.84,51,15,50.1,15,49V27c0-1.1,0.84-2,1.88-2H30z" style=""></path>
				<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" d="M30,33c3.31,0,6,2.69,6,6s-2.69,6-6,6s-6-2.69-6-6S26.69,33,30,33z" style=""></path>
				<line class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="square" stroke-miterlimit="10" x1="28" y1="39" x2="32" y2="39" style=""></line>
			</g>


		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc></svg></div></i>
                                                          <span class="menu-title">Authentication</span>
                                                  </a>
                                <ul class="menu-content">
                        <li>
            <a href=" https://sig.creainter.com.pe/auth-login " target="_blank">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Login</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/auth-register " target="_blank">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Register</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/auth-forgot-password " target="_blank">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Forgot Password</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/auth-reset-password " target="_blank">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Reset Password</span>
            </a>
                      </li>
                  <li>
            <a href=" https://sig.creainter.com.pe/auth-lock-screen " target="_blank">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Lock Screen</span>
            </a>
                      </li>
                </ul>



                            </li>
                                                    <li class="nav-item has-sub">
              <a href="# ">
                                        <i class="menu-livicon livicon-evo-holder" data-icon="share" style="visibility: visible; width: 60px;"><div class="lievo-svg-wrapper"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve" data-animoptions="{'duration':'2', 'repeat':'0', 'repeatDelay':'0.7'}" preserveAspectRatio="xMinYMin meet" style="left: 0px; top: -0.390625px;"><g class="lievo-setrotation"><g class="lievo-setsharp" style="transform-origin: 0px 0px 0px;" data-svg-origin="30.625 30" transform="matrix(1,0,0,1,-0.625,-0.625)"><g class="lievo-setflip"><g class="lievo-main">
		<g class="lievo-common">
			<g>
				<line class="lievo-savelinecap" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="20.37" y1="27.33" x2="39.68" y2="17.77" style=""></line>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M51,15c0,3.31-2.69,6-6,6c-3.31,0-6-2.69-6-6s2.69-6,6-6C48.31,9,51,11.69,51,15z" style=""></path>
				<line class="lievo-savelinecap" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="20.37" y1="32.67" x2="39.68" y2="42.23" style=""></line>
				<path fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M51,45c0,3.31-2.69,6-6,6c-3.31,0-6-2.69-6-6c0-3.31,2.69-6,6-6C48.31,39,51,41.69,51,45z" style=""></path>
				<path class="lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M21,30c0,3.31-2.69,6-6,6c-3.31,0-6-2.69-6-6c0-3.31,2.69-6,6-6C18.31,24,21,26.69,21,30z" style=""></path>
			</g>
			<g opacity="0">
				<g>
					<line class="lievo-savelinecap lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" x1="32" y1="26.54" x2="37.5" y2="17.01" style=""></line>
					<circle class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" cx="39.5" cy="13.55" r="4" style=""></circle>
				</g>

				<g>
					<line class="lievo-savelinecap lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" x1="28" y1="26.54" x2="22.5" y2="17.01" style=""></line>
					<circle class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" cx="20.5" cy="13.55" r="4" style=""></circle>
				</g>

				<g>
					<line class="lievo-savelinecap lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" x1="26" y1="30" x2="15" y2="30" style=""></line>
					<circle class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" cx="11" cy="30" r="4" style=""></circle>
				</g>

				<g>
					<line class="lievo-savelinecap lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" x1="28" y1="33.46" x2="22.5" y2="42.99" style=""></line>
					<circle class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" cx="20.5" cy="46.46" r="4" style=""></circle>
				</g>

				<g>
					<line class="lievo-savelinecap lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" x1="32" y1="33.46" x2="37.5" y2="42.99" style=""></line>
					<circle class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" cx="39.5" cy="46.45" r="4" style=""></circle>
				</g>

				<g>
					<line class="lievo-savelinecap lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-linecap="round" stroke-miterlimit="10" x1="34" y1="30" x2="45" y2="30" style=""></line>
					<circle class="lievo-donotdraw" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" cx="49" cy="30" r="4" style=""></circle>
				</g>

				<path class="lievo-donotdraw lievo-altstroke" fill="none" stroke="#8494a7" stroke-width="3.25px" stroke-miterlimit="10" d="M34,30c0,2.21-1.79,4-4,4c-2.21,0-4-1.79-4-4c0-2.21,1.79-4,4-4C32.21,26,34,27.79,34,30z" style=""></path>
			</g>
		</g>
	<rect x="-19" y="-19" width="4" height="4" fill="none" stroke="#8494a7" style="stroke-width: 2; stroke-linecap: butt; stroke-linejoin: round; opacity: 0;" class="lievo-checkshift lievo-donotdraw lievo-nohoverstroke lievo-nohovercolor" stroke-width="3.25px"></rect></g></g></g></g>

<desc>LivIcons Evolution</desc><defs></defs></svg></div></i>
                                                          <span class="menu-title">Miscellaneous</span>
                                                  </a>
         <ul class="menu-content">
           <li>
            <a href=" https://sig.creainter.com.pe/page-coming-soon " target="_blank">
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">Coming Soon</span>
            </a>
           </li>
              <li class="has-sub">
                <a href=" # ">
                  <i class="bx bx-right-arrow-alt"></i>
                <span class="menu-item">Error</span>
                </a>
                <ul class="menu-content">
                  <li>
                    <a href=" https://sig.creainter.com.pe/error-404 " target="_blank">
                      <i class="bx bx-right-arrow-alt"></i>
                    <span class="menu-item">404</span>
                    </a>
                  </li>
                  <li>
                    <a href=" https://sig.creainter.com.pe/error-500 " target="_blank">
                      <i class="bx bx-right-arrow-alt"></i>
                    <span class="menu-item">500</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a href=" https://sig.creainter.com.pe/page-not-authorized " target="_blank">
                  <i class="bx bx-right-arrow-alt"></i>
                <span class="menu-item">Not Authorized</span>
                </a>
              </li>
              <li>
                <a href=" https://sig.creainter.com.pe/page-maintenance " target="_blank">
                  <i class="bx bx-right-arrow-alt"></i>
                <span class="menu-item">Maintenance</span>
                </a>
              </li>
            </ul>
          </li>
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
