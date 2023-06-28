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
      <div class="fell"></div>
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
  <script>
    callReadyLoad();
  </script>
</body>
<!-- END: Body-->
