<!DOCTYPE html>
<!--
Template Name: Frest HTML Admin Template
Author: :Pixinvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/pixinvent_portfolio
Renew Support: https://1.envato.market/pixinvent_portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
  {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
//confiData variable layoutClasses array in Helper.php file.
  $configData = Helper::applClasses();
@endphp

<html class="loading" lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
 data-textdirection="{{$configData['direction'] == 'rtl' ? 'rtl' : 'ltr' }}">
  <!-- BEGIN: Head-->

    <head>
    <meta  charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Creainter - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('css/sip.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}}">
    {{-- Include core + vendor Styles --}}
    {{-- @include('panels.styles') --}}
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-extended.css')}}">
    @yield('page-styles')
    </head>
    <!-- END: Head-->
    @section('content')
     {{--  
     @if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
     @include(($configData['mainLayoutType'] === 'horizontal-menu') ? 'layouts.horizontalLayoutMaster':'layouts.verticalLayoutMaster')
     @else --}}
     {{-- if mainLaoutType is empty or not set then its print below line --}}
     {{-- <h1>{{'mainLayoutType Option is empty in config custom.php file.'}}</h1>
     @endif
      --}}
      
<body class="horizontal-layout horizontal-menu @if(isset($configData['navbarType']) && ($configData['navbarType'] !== "navbar-hidden") ){{$configData['navbarType']}} @else {{'navbar-sticky'}}@endif 2-columns 
@if($configData['theme'] === 'dark'){{'dark-layout'}} @elseif($configData['theme'] === 'semi-dark'){{'semi-dark-layout'}} @else {{'light-layout'}} @endif
@if($configData['isContentSidebar']=== true) {{'content-left-sidebar'}} @endif 
@if(isset($configData['footerType'])) {{$configData['footerType']}} @endif {{$configData['bodyCustomClass']}} 
@if($configData['isCardShadow'] === false){{'no-card-shadow'}}@endif" 
data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

  <!-- BEGIN: Header-->
  {{-- @include('panels.horizontal-navbar')--}}
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->
  {{-- @include('panels.sidebar')--}}
  <!-- END: Main Menu-->
<div class="collapse" id="navbarToggleExternalContent">
  <div class="bg-dark p-4">
    <h5 class="text-white h4">Collapsed content</h5>
    <span class="text-muted">Toggleable via the navbar brand.</span>
  </div>
</div>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" onclick="window.location.href= '/mini'" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class='bx bxs-home'></i>
      </button> 
     <h3 class="text-white"> {{ $titulo ?? 'Menu' }}</h3>
  </div>
</nav>
  <!-- BEGIN: Content-->
<div class="content-body">
 @yield('content')
</div>
 <!-- BEGIN: Footer-->
  {{-- @include('panels.footer') --}}
 <!-- END: Footer-->
  @yield('page-scripts')
</body>
</html>
