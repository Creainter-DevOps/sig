<!DOCTYPE html>
@isset($pageConfigs)
  {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
  $configData = Helper::applClasses();
@endphp

@if(!empty($_SERVER['HTTP_X_THEME_TOKEN']))
  @include('panels.styles')
  @include('layouts.contentLayoutCenter')
  @yield('vendor-scripts')
  @yield('page-scripts')
@else
<html class="loading" 
 {{--lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif" --}}
lang="es"
 data-textdirection="{{$configData['direction'] == 'rtl' ? 'rtl' : 'ltr' }}">

    <head>
    <meta  charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Adjudica - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('css/sip.css')}}" />

    @include('panels.styles')
    </head>

     @if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
     @include(($configData['mainLayoutType'] === 'horizontal-menu') ? 'layouts.horizontalLayoutMaster':'layouts.verticalLayoutMaster')
     @else
     <h1>{{'mainLayoutType Option is empty in config custom.php file.'}}</h1>
     @endif
</html>
@endif
