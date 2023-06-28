<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu @if(isset($configData['navbarType']) && ($configData['navbarType'] !== "navbar-hidden") ){{$configData['navbarType']}} @else {{'navbar-sticky'}}@endif 2-columns 
@if($configData['theme'] === 'dark'){{'dark-layout'}} @elseif($configData['theme'] === 'semi-dark'){{'semi-dark-layout'}} @else {{'light-layout'}} @endif
@if($configData['isContentSidebar']=== true) {{'content-left-sidebar'}} @endif 
@if(isset($configData['footerType'])) {{$configData['footerType']}} @endif {{$configData['bodyCustomClass']}} 
@if($configData['isCardShadow'] === false){{'no-card-shadow'}}@endif" 
data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
  <div id="sip_body"></div>
  <!-- BEGIN: Header-->
  {{--include('panels.horizontal-navbar')--}}
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
  <div class="buy-now">
    @include('pages.buy-now')
  </div>
  @endif
  <!-- demo chat-->
  {{--<div class="widget-chat-demo">
    @include('pages.widget-chat')
  </div>--}}

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  <!-- BEGIN: Footer-->
  @include('panels.footer')
  <!-- END: Footer-->

  @include('panels.scripts')
  <script>
    callReadyLoad();
  </script>
</body>
<!-- END: Body-->
