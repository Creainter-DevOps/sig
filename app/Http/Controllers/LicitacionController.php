<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad;
use App\OportunidadLog;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\CandidatoOportunidad;
use App\Licitacion;
use App\Helpers\Chartjs;
use App\Helpers\Helper;

class LicitacionController extends Controller {
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
  public function index(Request $request ) {
    if (!empty( $request->input("search") )){
      $query = strtolower($request->input("search")); 
      $list = Oportunidad::search($query)->take(20)->get();
      //dd($list);
      return view('licitacion.index', compact("list"));
    } 
    $participaciones_por_vencer = Oportunidad::listado_participanes_por_vencer();
    $propuestas_por_vencer = Oportunidad::listado_propuestas_por_vencer();
    $propuestas_en_pro = Oportunidad::listado_propuestas_buenas_pro();
    $chartjs['barras'] = Oportunidad::estadistica_barra_cantidades();
    $chartjs['barras'] = Chartjs::line($chartjs['barras'], [
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
    ]);
    return view('licitacion.dashboard', compact('participaciones_por_vencer','propuestas_por_vencer','propuestas_en_pro','chartjs'));
  }

  public function listNuevas(){
    $list = Oportunidad::listado_nuevas();
    return view('licitacion.nuevas', compact('list'));
  }
  public function listAprobadas(){
    $list = Oportunidad::listado_aprobadas();
    return view('licitacion.aprobadas', compact('list'));
  }
  public function listArchivadas(){
    $list = Oportunidad::listado_archivadas();
    return view('licitacion.aprobadas', compact('list'));
  }
  public function listEliminadas(){
    $list = Oportunidad::listado_eliminados();
    return view('licitacion.aprobadas', compact('list'));
  }
  public function calendario(){
    return view('licitacion.calendar');
  }
  public function detalles(Request $request, Licitacion $licitacion) {
    $oportunidad = $licitacion->oportunidad();
    return view('licitacion.detalle', compact('licitacion','oportunidad'));
  }
  public function observacion( Request $request, Licitacion $licitacion) {
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
    return redirect('/licitaciones/' . $licitacion->id . '/detalles');
  } else {
    return redirect('/licitaciones/');
  }
}
public function interes(Request $request, Licitacion $licitacion, Empresa $empresa) {
  $oportunidad = $licitacion->oportunidad();
  $oportunidad->registrar_interes($empresa);
  return redirect('/licitaciones/' . $licitacion->id . '/detalles');
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
    return redirect('/licitaciones');
  }
}

/*public function update(Request $request, Oportunidad $oportunidad){
  $oportunidad->update($request->all());
  if(is_numeric($oportunidad-> )
  return response()->json(['status' => true ]);
}*/

public function update(Request $request, Oportunidad $oportunidad) {
  $dato =  $request->input("field");
  $value = $request->input($dato);
  $oportunidad->update($request->all());
  $oportunidad->log($dato,$value);
  if(is_numeric($value)) {
    $value = Helper::money($value);
  } 
  return response()->json(['status' => true , 'value' => $value ]);
}

public function covertirproyecto($id){
  $oportunidad = Oportunidad::find($id);
  $proyecto = new Proyecto();
  $proyecto->oportunidad_id = $oportunidad->id;
  $proyecto->empresa_id    = $oportunidad->id;
  $proyecto->oportunidad_id = $oportunidad->id;
  $proyecto->oportunidad_id = $oportunidad->id;

  
}
public function archivar(Request $request, Licitacion $licitacion) {
  $oportunidad = $licitacion->oportunidad();
    $oportunidad->archivar();
    return redirect('/licitaciones');
  }
public function registrarParticipacion(Request $request, Licitacion $licitacion, CandidatoOportunidad $candidato) {
  $oportunidad = $licitacion->oportunidad();
    $candidato->registrar_participacion();
    return redirect('/licitaciones/' . $licitacion->id . '/detalles');
  }
public function registrarPropuesta(Request $request, Licitacion $licitacion, CandidatoOportunidad $candidato) {
    $oportunidad = $licitacion->oportunidad();
    $candidato->registrar_propuesta();
    return redirect('/licitaciones/' . $licitacion->id . '/detalles');
  }
public function autocomplete(Request $request ){
    $query = $request->input('query');
    $list = Oportunidad::search( $query )->selectRaw("oportunidad.id,  CONCAT_WS( ':', licitacion.procedimiento_id , licitacion.rotulo) as value " )->get();
     return response()->json($list); 
  }

}
