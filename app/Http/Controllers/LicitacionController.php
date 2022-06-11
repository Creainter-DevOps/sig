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
  public function index(Request $request ) {
    if (!empty( $request->input("search") )){
      $query = strtolower($request->input("search")); 
      $list = Licitacion::search($query)->take(200)->orderBy('fecha_participacion_hasta', 'DESC')->get();
      return view('licitacion.index', compact("list"));
    } 
    $participaciones_por_vencer = Oportunidad::listado_participanes_por_vencer();
    $propuestas_por_vencer = Oportunidad::listado_propuestas_por_vencer();
    $propuestas_en_pro = Oportunidad::listado_propuestas_buenas_pro();
    $actividades = Oportunidad::actividades(); 

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
    return view('licitacion.dashboard', compact('participaciones_por_vencer','propuestas_por_vencer','propuestas_en_pro','chartjs','actividades'));
  }

  public function listNuevas(){
    $list = Licitacion::listado_nuevas();
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
  public function show(Request $request, Licitacion $licitacion) {
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
  public function documento(){
    
    return view('licitacion.documentos');

   $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(__DIR__ . '/../../../resources/files/Borrador.docx');
   $templateProcessor->setValue(array('{{usuario}}'), array('07 Sep 2017'));
   header("Content-Disposition: attachment; filename=Plantilla.docx");
   $templateProcessor->saveAs("php://output");
   //$templateProcessor->saveAs('Plantilla.docx');

    /*$phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    // Adding Text element to the Section having font styled by default...
    $section->addText(
        '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
    );

    /*
     * Note: it's possible to customize font style of the Text element you add in three ways:
     * - inline;
     * - using named font style (new font style object will be implicitly created);
     * - using explicitly created font style object.
     */

    // Adding Text element with font customized inline...
    /*$section->addText(
        '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
        array('name' => 'Tahoma', 'size' => 10)
      );*/

    // Adding Text element with font customized using named font style...
    /*$fontStyleName = 'oneUserDefinedStyle';
    $phpWord->addFontStyle(
        $fontStyleName,
        array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
    );
    $section->addText(
        '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
        $fontStyleName
      );*/

    // Adding Text element with font customized using explicitly created font style object...
    /*$fontStyle = new \PhpOffice\PhpWord\Style\Font();
    $fontStyle->setBold(true);
    $fontStyle->setName('Tahoma');
    $fontStyle->setSize(13);
    $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
    $myTextElement->setFontStyle($fontStyle);*/

    // Saving the document as OOXML file...
    /*$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007',true);
    header("Content-Disposition: attachment; filename=File.docx");
    $objWriter->save("php://output" );*/
    //header("Content-Disposition: attachment; filename='helloWorld.docx'");
    //readfile($temp_file); // or echo file_get_contents($temp_file);
    //unlink($temp_file);  // remove temp file
    //echo "documento guardado";
   // echo write($phpWord, basename(__FILE__, '.php'), $writers );
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
  $licitacion->aprobar();
  $oportunidad = $licitacion->oportunidad();
  if(!$request->ajax()) {
    return redirect('/licitaciones/' . $licitacion->id . '/detalles');
  } else {
      return response()->json([
        'status'  => 'success',
        'message' => 'Se ha realizado registro con éxito.',
        'data' => $oportunidad
      ]);
  }
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
public function rechazar(Request $request, Licitacion $licitacion)
{
  $licitacion->rechazar();
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
public function interes(Request $request, Licitacion $licitacion, Empresa $empresa) {
  $oportunidad = $licitacion->oportunidad();
  $oportunidad->registrar_interes($empresa);
  return redirect('/licitaciones/' . $licitacion->id . '/detalles');
}
public function registrarParticipacion(Request $request, Licitacion $licitacion, Cotizacion $cotizacion) {
    $oportunidad = $licitacion->oportunidad();
    $cotizacion->registrar_participacion();
    return redirect('/licitaciones/' . $licitacion->id . '/detalles');
  }
public function registrarPropuesta(Request $request, Licitacion $licitacion, Cotizacion $cotizacion) {
    $oportunidad = $licitacion->oportunidad();
    $cotizacion->registrar_propuesta();
    return redirect('/licitaciones/' . $licitacion->id . '/detalles');
  }
public function autocomplete(Request $request ){
    $query = $request->input('query');
    $list = Oportunidad::search( $query )->selectRaw("oportunidad.id,  CONCAT_WS( ':', licitacion.procedimiento_id , licitacion.rotulo) as value " )->get();
     return response()->json($list); 
  }

}
