<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;

class ContableController extends Controller {
  public function __construct() {
    $this->middleware('auth');
  }
  public function index(Request $request) {
    return view('contable.index');
  }
}
