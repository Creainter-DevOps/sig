<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Helpers\Chartjs;
use App\User;
use App\Cuota;

class DashboardController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }
  public function index(Request $request)
  {
    $cliente = new Cliente;

    $actividades = Oportunidad::actividades();

    $chartjs['usuario'] = User::estadisticas();
    $chartjs['barras'] = Oportunidad::estadistica_barra_cantidades();
    $chartjs['barras'] = Chartjs::line($chartjs['barras'], [
      'APROBADAS' => array(
        'rotulo'     => 'APROBADAS',
        'color'      => '#ffc800',
      ),
      'PARTICIPACIÓN' => array(
        'rotulo'     => 'PARTICIPACIÓN',
        'color'      => '#5A8DEE',
      ),
      'PROPUESTA' => array(
        'rotulo'     => 'PROPUESTAS',
        'color'      => '#56DF9B',
      ),
      'TIMEOUT/PARTICIPACIÓN' => array(
        'rotulo'     => 'TIMEOUT/PARTICIPACIÓN',
        'color'      => '#DF8F28',
      ),
      'TIMEOUT/PROPUESTA' => array(
        'rotulo'     => 'TIMEOUT/PROPUESTA',
        'color'      => '#DF2001',
      ),
      'RECHAZADAS' => array(
        'rotulo'     => 'RECHAZADAS',
        'color'      => '#7824ff',
      ),
    ]);

    $chartjs['barras2'] = Oportunidad::estadistica_cantidad_mensual();
    $chartjs['barras2'] = Chartjs::line($chartjs['barras2'], [
      'PARTICIPACION' => array(
        'rotulo'     => 'PARTICIPACION',
        'color'      => '#ffc800',
      ),
      'PROPUESTA' => array(
        'rotulo'     => 'PROPUESTA',
        'color'      => '#5A8DEE',
      ),
      'BUENA PRO' => array(
        'rotulo'     => 'BUENA PRO',
        'color'      => '#3ad385',
      ),
    ]);
    $oportunidades = Cuota::oportunidades();
    $etiquetas     = Cuota::etiquetas();
    $empresas      = Cuota::empresas();

    return view('dashboard', compact('cliente','chartjs','actividades','oportunidades','etiquetas','empresas'));
  }
    //ecommerce
  public function dashboardEcommerce(){
    return view('pages.dashboard-ecommerce');
  }
    // analystic
  public function dashboardAnalytics(){
    return view('pages.dashboard-analytics');
  }
}
