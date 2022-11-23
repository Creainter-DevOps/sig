<?php 
  return [
    'app_url'       => env('APP_URL','localhost'),
    'ruta_storage'  => 'gs://creainter-peru/storage/',
    'ruta_temporal' => '/tmp/',
    'static_seace'  => '/static/seace/',
    'static_temp'   => '/static/temporal/',
    'static_cloud'  => '/static/cloud/',
    'ruta_cloud'    => env('APP_URL','localhost') . '/static/cloud/',
    'internal'      => env('DIR_INTERNAL','./'),
  ];
