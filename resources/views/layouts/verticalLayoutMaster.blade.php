<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 2-columns 
@if($configData['isMenuCollapsed'] == true){{'menu-collapsed'}}@endif 
@if($configData['theme'] === 'dark'){{'dark-layout'}} @elseif($configData['theme'] === 'semi-dark'){{'semi-dark-layout'}} @else {{'light-layout'}} @endif
@if($configData['isContentSidebar'] === true) {{'content-left-sidebar'}} @endif @if(isset($configData['navbarType'])){{$configData['navbarType']}}@endif 
@if(isset($configData['footerType'])) {{$configData['footerType']}} @endif 
{{$configData['bodyCustomClass']}} 
@if($configData['mainLayoutType'] === 'vertical-menu-boxicons'){{'boxicon-layout'}}@endif 
@if($configData['isCardShadow'] === false){{'no-card-shadow'}}@endif" 
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<style>
html .content.app-content {
  overflow: unset!important;
}
html .navbar-static .content {
  min-height: calc(100% - 190px)!important;
  margin-top: 10px!important;
}
.app-content.content {
  margin-top: 70px;
}
.app-content.content .content-wrapper {
/*  position: absolute; */
}
html .navbar-static .app-content .content-wrapper {
  padding: 20px!important;
}
.header-navbar .navbar-container ul.nav li.dropdown-user .dropdown-menu-right {
  z-index: 999;
}
footer.footer {
  padding: 2px 10px!important;
  font-size: 11px!important;
}
.app-content-second {
  border: 2px solid #84a4ff;
  border-radius: 5px;
  margin: 15px;
  position: absolute;
  bottom: 0;
  top: 0;
  left: 0;
  right: 0;
  margin-bottom: 0;
}
.app-content.content .x-page {
  position: absolute;
  bottom: 0;
  top: 0;
  left: 0;
  right: 0;
}
.app-content.content .x-page > .x-page-overlay {
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  position: relative;
  background: rgb(0 0 0 / 48%);
  position: absolute;
  z-index: 99;
  cursor:pointer;
}
.app-content.content .x-page > .x-page-overlay:hover {
  background: rgb(123 194 255 / 45%);
}
.app-content.content .x-page > .x-page-body {
  background: #f2f4f4;
  position: relative;
  z-index: 99;
  overflow: auto;
  max-height: 100%;
  min-height: 100%;
}
.app-content.content .x-page > .x-page-body.x-page-loading {
  height: 800px;
  background: #8089ff;
}
.app-content.content .x-page > .x-page-body.x-page-loading:before {
  content: 'En breve...';
  color: #fff;
  text-align: center;
  vertical-align: middle;
  position: absolute;
  left: 0;
  right: 0;
  top: 50px;
  font-size: 60px;
  font-family: 'Rubik';
}
.app-content.content .x-page > .x-page-body > .content-wrapper {
  margin-top: 0;  
}
.app-content.content .x-page > .x-page-nav {
  position: absolute;
  top: 0;
  bottom: 0;
  margin-left: 100px;
  width: 100%;
  max-width: 95%;
  max-width: calc(100% - 100px);
}
.app-content.content .x-page > .x-page-nav > .x-page > .x-page-overlay {
  left: -100px;
}
</style>
  <div id="sip_body"></div>
  <!-- BEGIN: Header-->
  @include('panels.navbar')
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->
  @include('panels.sidebar')
  <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="app-content-second">
    <div class="x-page">
      <div class="x-page-body">
      @include('layouts.contentLayoutCenter')
      </div>
      <div class="x-page-nav"></div>
    </div>
    </div>
  </div>
  <!-- END: Content-->
  @if(false && $configData['isCustomizer'] === true && isset($configData['isCustomizer']))
  <!-- BEGIN: Customizer-->
  <div class="customizer d-none d-md-block">
    <a class="customizer-close" href="#"><i class="bx bx-x"></i></a>
    <a class="customizer-toggle" href="#"><i class="bx bx-cog bx bx-spin white"></i></a>
    @include('pages.customizer-content')
  </div>
  <!-- End: Customizer-->

  <!-- Buynow Button-->
  @endif
  <!-- demo chat-->

<!--  <div class="sidenav-overlay"></div> -->
<!--  <div class="drag-target"></div> -->

  <!-- BEGIN: Footer-->
    @include('panels.footer')
  <!-- END: Footer-->

    <!-- Start: Modals-->
    @yield('modals')
    <!-- END: Modals-->
  @include('panels.scripts')
</body>
<!-- END: Body-->
