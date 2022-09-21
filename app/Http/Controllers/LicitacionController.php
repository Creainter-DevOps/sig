<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad;
use App\OportunidadLog;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\Cotizacion;
use App\Licitacion;
use App\Helpers\Chartjs;
use App\Helpers\Helper;


class LicitacionController extends Controller {
  public $fieldsPublic = [
    'rotulo'     => '¿Qué solicita?',
    'monto_base' => 'Monto Base',
    'instalacion_dias' => 'Instalación (días)',
    'duracion_dias' => 'Servicio (días)',
    'garantia_dias' => 'Garantía (días)',
    'texto'         => 'Observación',
  ];
  public function __construct() {
    $this->middleware('auth');
  }
  public function part_avance_expedientes(Request $request) {
    return view('licitacion.part_avance_expedientes');
  }
  public function index(Request $request ) {
    if (!empty( $request->input("search") )){
      $query = strtolower($request->input("search")); 
      $list = Licitacion::search($query)->take(200)->orderBy('fecha_participacion_hasta', 'DESC')->get();
      return view('licitacion.index', compact("list"));
    } 
    $participaciones_por_vencer = Oportunidad::listado_participanes_por_vencer();
    $propuestas_por_vencer = Oportunidad::listado_propuestas_por_vencer();
    $propuestas_en_pro = Oportunidad::listado_propuestas_buenas_pro();

    $chartjs['resumen'] = Oportunidad::estadistica_enviado_diario();
    
    return view('licitacion.dashboard', compact('participaciones_por_vencer','propuestas_por_vencer','propuestas_en_pro','chartjs','actividades'));
  }

  public function listNuevas(){
    $list = Licitacion::listado_nuevas($parametros);
    return view('licitacion.nuevas', compact('list','parametros'));
  }
  public function listNuevasMas(Request $request) {
    $params = $request->input('value');
    $params = explode('-', $params);
    $max    = $params[0];
    $min    = $params[1];
    $rp = Licitacion::borrar_tentativas($min, $max);
     return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Extrayendo...',
        'message'  => 'Borrando los anteriores '  .$min . '-' . $max,
        'refresh'  => true,
        'class'    => 'success',
        'data'     => $rp
      ]);
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

  public function movil(){
    return view('licitacion.movil');  
  }

  public function show(Request $request, Licitacion $licitacion) {
    $oportunidad = $licitacion->oportunidad();
    if(!empty($oportunidad->id)) {
      return redirect('/oportunidades/' . $oportunidad->id);
    }
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
  public function actualizar(Request $request, Licitacion $licitacion) {
    $licitacion->buenapro_revision = false;
    $licitacion->save();
    exec("/usr/bin/php /var/www/html/interno.creainter.com.pe/util/seace/actualizar_id.php " . $licitacion->id);
    if(!$request->ajax()) {
      return redirect('/licitaciones/' . $licitacion->id . '/detalles');
    } else {
      return response()->json([
        'status'  => 'success',
        'message' => 'Se ha realizado la actualización con éxito.',
      ]);
    }
  }
public function aprobar(Request $request, Licitacion $licitacion)
{
  $oportunidad = $licitacion->oportunidad();
  if(empty($oportunidad)) {
    $licitacion->aprobar();
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Oportunidad Aprobada!',
      'message'  => 'Oportunidad ha sido registrada como aprobada',
      'refresh'  => false,
      'class'    => 'success',
    ]);
  } else {
    if(empty($oportunidad->aprobado_el)) {
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Oportunidad Aprobada!',
        'message'  => 'Oportunidad ha sido registrada como aprobada',
        'refresh'  => false,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Oportunidad ya aprobado',
        'message'  => 'Ya fue aprobado anteriormente.',
        'refresh'  => false,
        'class'    => 'warning',
      ]);
    }
  }
}
public function rechazar(Request $request, Licitacion $licitacion)
{
  $oportunidad = $licitacion->oportunidad();
  $motivo = $request->input('value');

  if(empty($motivo)) {
    return response()->json([
        'status'  => false,
        'message' => 'Debe indicar el motivo',
    ]);
  }

  $licitacion->rechazar($motivo);
  if(empty($oportunidad)) {
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Rechazado',
        'message'  => 'Se ha realizado registro con éxito.',
      ]);
  } else {
    if(empty($oportunidad->rechazado_el)) {
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Oportunidad Rechazada!',
        'message'  => 'Oportunidad ha sido registrada como rechazada',
        'refresh'  => false,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Oportunidad ya rechazada',
        'message'  => 'Ya fue rechazada anteriormente.',
        'refresh'  => false,
        'class'    => 'warning',
      ]);
    }
  }
}

public function update(Request $request, Licitacion $licitacion ) {

  //$dato =  $request->input("field");
  //$value = $request->input($dato);
  $data = $request->all();
  $value = 0;
  if(!empty($data['_update'])){
    $data[$data['_update']] = $data['value'];
    $value = $data['value'];
    unset($data['value']);
    unset($data['_update']);
  }
  
  //$value = Helper::money($value);
  //$oportunidad->log($dato,$value)
  if(is_numeric($value)) {
    $value = Helper::money($value);
  } 
  $licitacion->update($data);
  return response()->json(['status' => true , 'value' => $value ]);
}

public function autocomplete(Request $request ){
    $query = $request->input('query');
    $list = Oportunidad::search( $query )->selectRaw("oportunidad.id,  CONCAT_WS( ':', licitacion.procedimiento_id , licitacion.rotulo) as value " )->get();
     return response()->json($list); 
  }

}
