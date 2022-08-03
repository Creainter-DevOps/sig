<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;
use App\Helpers\Helper;

class ContableController extends Controller {
  public function __construct() {
    $this->middleware('auth');
  }
  public function index(Request $request) {
    return view('contable.index');
  }
  public function financiero(Request $request, Proyecto $proyecto) {
     $empresa = $proyecto->cotizacion()->empresa();
     return Helper::pdf('proyectos.financiero', compact('proyecto','empresa'), 'L')->stream('demo.pdf');
  }
  public function facturas_por_cobrar() {
    return Helper::pdf('contable.reporte_facturas_por_cobrar', [])->stream('exportado.pdf');
  }
  public function licitaciones_semanal() {
    return Helper::pdf('contable.reporte_licitaciones_semanal', [])->stream('exportado.pdf');
  }
  public function proyectos_activos() {
    return Helper::pdf('contable.reporte_proyectos', [])->stream('exportado.pdf');
  }
  public function licitaciones_fechas() {
    return Helper::pdf('contable.reporte_licitaciones_fechas', [])->stream('exportado.pdf');
  }
}
