<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;
use App\Voip;

class VoipController extends Controller {

  protected $viewBag = [];
  public function __construct(){
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/contactos", "name" => "Contactos" ]
    ];
  }   
  public function llamadas(Request $request) {
    return view('voip.llamadas', $this->viewBag);
  }
  public function audios(Request $request) {
    $aid = $request->input('aid');
    $res = Voip::audios($aid);
    return response()->json($res);
  }
  public function render_audios(Request $request) {
    $aid = $request->input('aid');
    $audios = Voip::audios($aid);
    $this->viewBag['audios'] = $audios->data;
    return view('voip.render_audios', $this->viewBag);
  }
}
