<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;

class StaticController extends Controller {

  protected $viewBag = [];
  public function __construct(){
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/contactos", "name" => "Contactos" ]
    ];
  }
   
  public function seace(Request $request, $hash) {
    $output = '/tmp/seace/';
   echo $hash;
   exit;
  }
}
