<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad;
use App\OportunidadLog;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\CandidatoOportunidad;
use App\Licitacion;

class OportunidadController extends Controller {
  public $fieldsPublic = [
    'que_es'     => '¿Qué solicita?',
    'monto_base' => 'Monto Base',
    'instalacion_dias' => 'Instalación (días)',
    'duracion_dias' => 'Servicio (días)',
    'garantia_dias' => 'Garantía (días)',
    'texto'         => 'Observación',
  ];
  public function __construct() {
    $this->middleware('auth');
  }
  public function dashboard() {
    $participaciones_por_vencer = Oportunidad::listado_participanes_por_vencer();
    $propuestas_por_vencer = Oportunidad::listado_propuestas_por_vencer();
    $propuestas_en_pro = Oportunidad::listado_propuestas_buenas_pro();
    return view('oportunidad.dashboard', compact('participaciones_por_vencer','propuestas_por_vencer','propuestas_en_pro'));
  }

    public function listNuevas(){
      $list = Oportunidad::listado_nuevas();
      return view('oportunidad.nuevas', compact('list'));
    }
    public function listAprobadas(){
      $list = Oportunidad::listado_aprobadas();
      return view('oportunidad.aprobadas', compact('list'));
    }
    public function listArchivadas(){
      $list = Oportunidad::listado_archivadas();
      return view('oportunidad.aprobadas', compact('list'));
    }
    public function listEliminadas(){
      $list = Oportunidad::listado_eliminados();
      return view('oportunidad.aprobadas', compact('list'));
    }
    public function calendario(){
      return view('oportunidad.calendar');
    }
    public function detalles(Request $request, Licitacion $licitacion) {
      $oportunidad = $licitacion->oportunidad();
      return view('oportunidad.detalle', compact('licitacion','oportunidad'));
    }
    public function observacion(Request $request, Licitacion $licitacion) {
      $oportunidad = $licitacion->oportunidad();
      foreach($this->fieldsPublic as $k => $v) {
        $texto = $request->input($k);
        if(!empty($texto)) {
          $oportunidad->update([$k => $texto]);
          $oportunidad->log($k, $texto);
        }
      }
      return back();
    }
public function aprobar(Request $request, Licitacion $licitacion)
{
  $oportunidad = $licitacion->oportunidad();
  $oportunidad->aprobar();
      return response()->json([
        'status'  => 'success',
        'message' => 'Se ha realizado registro con éxito.',
        'data' => $oportunidad
      ]);
}
public function revisar(Request $request, Licitacion $licitacion)
{
  $oportunidad = $licitacion->oportunidad();
  if(empty($oportunidad->revisado_el)) {
    $oportunidad->revisar();
    return redirect('/oportunidad/' . $licitacion->id . '/detalles');
  } else {
    return redirect('/oportunidad/');
  }
}
public function interes(Request $request, Licitacion $licitacion, Empresa $empresa) {
  $oportunidad = $licitacion->oportunidad();
  $oportunidad->registrar_interes($empresa);
  return redirect('/oportunidad/' . $licitacion->id . '/detalles');
}
public function rechazar(Request $request, Licitacion $licitacion)
{
  $oportunidad = $licitacion->oportunidad();
  $oportunidad->rechazar();
  if($request->ajax()) {
      return response()->json([
        'status'  => 'success',
        'message' => 'Se ha realizado registro con éxito.',
        'data' => $oportunidad
      ]);
  } else {
    return redirect('/oportunidad');
  }
}
public function archivar(Request $request, Licitacion $licitacion) {
  $oportunidad = $licitacion->oportunidad();
    $oportunidad->archivar();
    return redirect('/oportunidad');
  }
public function registrarParticipacion(Request $request, Licitacion $licitacion, CandidatoOportunidad $candidato) {
  $oportunidad = $licitacion->oportunidad();
    $candidato->registrar_participacion();
    return redirect('/oportunidad/' . $licitacion->id . '/detalles');
  }
public function registrarPropuesta(Request $request, Licitacion $licitacion, CandidatoOportunidad $candidato) {
  $oportunidad = $licitacion->oportunidad();
    $candidato->registrar_propuesta();
    return redirect('/oportunidad/' . $licitacion->id . '/detalles');
  }
}
