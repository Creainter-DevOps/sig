<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;
use App\Cotizacion;
use App\CotizacionDetalle;
use App\Proyecto;
use App\Documento;
use App\Helpers\Helper;
use Auth;
use App\User;
use Illuminate\Support\Facades\DB;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Http\GraphRequest;
use Microsoft\Graph\Http\GraphResponse;
use Microsoft\Graph\Exception\GraphException;

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

class CotizacionController extends Controller {

  protected $viewBag = [];

  public function __construct(){
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/cotizaciones", "name" => "Cotizaciones" ]
    ];
  }
   
  public function index(Request $request) {
    $search = $request->input('search');
    if(!empty($search)) {
      $listado = Cotizacion::search($search)->selectRaw('cotizacion.*')->paginate(15)->appends(request()->input('query'));
    } else {
      $listado = Cotizacion::visible()->orderBy('id', 'desc')->paginate(15)->appends(request()->query());
    }
    $this->viewBag['listado'] = $listado;
    return view('cotizacion.index', $this->viewBag );
  }

  public function show(Request $resquest, Cotizacion $cotizacion) {
    $cotizacion->codigo = '';
    $cliente  = isset( $cotizacion->cliente_id ) ? $cotizacion->cliente() : null;
    $timeline = $cotizacion->timeline();
    $contacto = isset($cotizacion->contacto_id) ? $cotizacion->contacto() : null; 
    return view ('cotizacion.show', compact('cotizacion', 'listado', 'breadcrumbs', 'cliente', 'timeline','contacto' )); 
  }
  public function create(Request $request) {
    
    $cotizacion = new Cotizacion;
    $cotizacion->monto = 0;
    $cotizacion->nomenclatura = '';
    $cotizacion->rotulo = '';

    if(!empty($_GET['oportunidad_id'])) {
      $cotizacion->oportunidad_id = $_GET['oportunidad_id'];
    }

    $this->viewBag['breadcrumbs'][] = [ 'name' => 'Nueva cotizacion' ];

    $this->viewBag['cotizacion'] = $cotizacion;

    return view($request->ajax() ? 'cotizacion.fast' : 'cotizacion.create', $this->viewBag );

  }

  public function store(Request $request){
    $cotizacion = Cotizacion::create($request->all());
    //    $cotizacion->log("creado", null );
    if($request->ajax()) {
      return response()->json(['status' => true , 'refresh' => true ]);
    } else {
      return redirect()->route('oportunidades.show', [ 'oportunidad' => $cotizacion->oportunidad_id ]);
    }
    return back();
    return response()->json([
        'status' => true,
        'redirect' => '/cotizaciones'
      ]); 
  }

  public function edit(Request $request, Cotizacion $cotizacion) {
    return view($request->ajax() ? 'cotizacion.fast_edit' : 'cotizacion.edit', compact('cotizacion'));    
  }

  public function update(Request $request, Cotizacion $cotizacion) {
    if($cotizacion->oportunidad()->estado == 3) {
//      return response()->json(['status' => false , 'message' => 'Oportunidad cerrada']);
    }
    $data = $request->all();
    if(!empty($data['_update'])) {
      if($data['value'] == '') {
        return response()->json([
          'status'  => false,
          'message' => '¿Debes colocar algo?'
        ]);
      }
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
    $data['updated_by'] = Auth::user()->id;
    $cotizacion->update($data);
    return response()->json([
      'status'  => true,
      'refresh' => true
    ]);
  }
  public function destroy(Cotizacion $cotizacion) {
    if($cotizacion->oportunidad()->estado == 3) {
      return response()->json(['status' => false , 'message' => 'Oportunidad cerrada']);
    }
    $cotizacion->delete();
    return response()->json(['status'=> true , 'refresh' => true ]);
  }
  public function autocomplete(Request $request ){
    $query = $request->input("query");
    $data = Cotizacion::search($query)->selectRaw(" cotizacion.id, CONCAT(oportunidad.codigo,':',licitacion.id, ' ', cotizacion.descripcion) as value ")->get() ; 
    return Response()->json($data); 
  }
  public function observacion(Request $request, Cotizacion $cotizacion ) {
    $cotizacion->log('texto',$request->input('texto'));
    return back();
  }
  public function proyecto(Request $request, Cotizacion $cotizacion) {
    $id = $cotizacion->migrateProyecto();
    return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Proyecto!',
        'message'  => 'Proyecto registrado',
        'refresh'  => false,
        'class'    => 'success',
        'redirect' => '/proyectos/' . $id,
      ]);
  }
  public function expediente(Request $request, Cotizacion $cotizacion) {
      if(empty($cotizacion->documento_id)) {
        $documento = Documento::nuevo([
          'cotizacion_id'   => $cotizacion->id,
          'oportunidad_id'  => $cotizacion->oportunidad_id,
          'licitacion_id'   => $cotizacion->oportunidad()->licitacion_id,
          'es_plantilla'    => false,
          'es_ordenable'    => false,
          'es_reusable'     => false,
          'tipo'            => 'EXPEDIENTE',
          'folio'           => 0,
          'rotulo'          => $cotizacion->oportunidad()->codigo,
          'filename'        => 'Propuesta_Seace.pdf',
          'formato'         => 'PDF',
          'directorio'      => trim($cotizacion->folder(true), '/'),
          'filesize'        => 0,
          'es_mesa'         => true,
          'elaborado_por'   => Auth::user()->id,
          'respaldado_el'   => null,
          'archivo'         => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf'),
          'original'        => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf')
        ]);
        $cotizacion->documento_id = $documento->id;
        $cotizacion->elaborado_por   = Auth::user()->id;
        $cotizacion->elaborado_step  = 1;
        $cotizacion->save();
        
        return redirect('/documentos/'. $documento->id . '/expediente/inicio');
      } else {
        return redirect('/documentos/'. $cotizacion->documento_id . '/expediente/inicio');
      }
  }
  public function subsanaciones(Request $request, Cotizacion $cotizacion) {
    return view('cotizacion.subsanaciones', compact('cotizacion'));
  }
  public function exportar(Request $request, Cotizacion $cotizacion) {
    $empresa = $cotizacion->empresa();
    if(count($cotizacion->items()) == 0) {
      $cotizacion->igv = $cotizacion->monto * 0.18;
      $cotizacion->subtotal = $cotizacion->monto - $cotizacion->igv;
    }
    return Helper::pdf('cotizacion.pdf', compact('cotizacion','empresa'), 'P')->stream($cotizacion->nomenclatura() . '.pdf');
  }

  public function detalle( $id ){
    $cotizacion = Cotizacion::find($id);
    $detalle = CotizacionDetalle::with('producto')
                                  ->where('eliminado',false)   
                                  ->where('cotizacion_id', $id )->get(); 
    return response()->json( [ 'cotizacion' =>  $cotizacion, 'detalle' => $detalle ]);
  }
  public function registrarParticipacion(Request $request, Cotizacion $cotizacion) {
    if(empty($cotizacion->participacion_el)) {
      $cotizacion->registrar_participacion();
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Participando!',
        'message'  => 'Participación registrada',
        'refresh'  => false,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Ya participando!',
        'message'  => 'Participación ya se encuentra registrada',
        'refresh'  => false,
        'class'    => 'warning',
      ]);
    }
//    return redirect('/oportunidades/' . $cotizacion->oportunidad_id . '/');
  }
  public function registrarPropuesta(Request $request, Cotizacion $cotizacion) {
    $documento = $cotizacion->documento();
    if(!empty($documento) && !empty($documento->id)) {
      if(empty($documento->revisado_por) || empty($documento->revisado_status)) {
        return response()->json([
          'status'   => false,
          'disabled' => true,
          'label'    => 'Requiere Aprobación',
          'message'  => 'Es necesario la aprobación del expediente.',
          'refresh'  => false,
          'class'    => 'warning',
        ]);
      }
    }
    if(empty($cotizacion->propuesta_el)) {
      $cotizacion->registrar_propuesta();
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Propuesta Enviada!',
        'message'  => 'Propuesta ha sido registrada como enviada',
        'refresh'  => false,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Propuesta ya existe',
        'message'  => 'Propuesta ya fue enviada',
        'refresh'  => false,
        'class'    => 'warning',
      ]);
    }
    //return redirect('/oportunidades/' . $cotizacion->oportunidad_id . '/');
  }
  public function registrarSubsanacion(Cotizacion $cotizacion, Request $request) {
    $proc = $cotizacion->solicitudSubsanacion();
    if($proc->estado == 200) {
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Solicitud Registrada!',
      'message'  => $proc->mensaje,
      'refresh'  => true,
      'class'    => 'success',
    ]);
  } else if($proc->estado == 500) {
    return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ya existe',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ops! Un problema',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  }
  }
  public function enviarPorCorreo(Cotizacion $cotizacion, Request $request) {
    $perfil_id = $request->input('value');

    if(empty($perfil_id)) {
      return response()->json([
        'status'   => false,
        'message'  => 'Debe seleccionar una empresa',
      ]);
    }
    $perfil = User::perfil($perfil_id, $cotizacion->oportunidad()->correo_id);
    if(empty($perfil)) {
      return response()->json([
        'status'   => false,
        'message'  => 'Perfil incorrecto',
      ]);
    }
    if(empty($cotizacion->documento()->revisado_por) || empty($cotizacion->documento()->revisado_status)) {
        return response()->json([
          'status'   => false,
          'disabled' => true,
          'label'    => 'Requiere Aprobación',
          'message'  => 'Es necesario la aprobación del expediente.',
          'refresh'  => false,
          'class'    => 'warning',
        ]);
    }
    $m = '<p>Estimado:</p>';
    $m .= '<p>Es un placer atender su solicitud de cotización y adjunto encontrará el archivo PDF con la cotización detallada para “<b>' . mb_strtoupper($cotizacion->oportunidad()->rotulo, 'utf-8') . '</b>”, con código interno ' . $cotizacion->codigo() . '.</p>';
    $m .= '<p>Hemos realizado un exhaustivo análisis de sus requerimientos y hemos elaborado una propuesta que creemos se ajusta a sus necesidades.</p>';
    $m .= '<p>Agradecemos sinceramente la oportunidad de presentarle nuestra propuesta y estamos seguros de que nuestra empresa puede brindarle soluciones confiables y de calidad. Si tiene alguna pregunta o desea realizar alguna modificación en la cotización, no dude en ponerse en contacto con nuestro equipo de ventas. Estaremos encantados de asistirlo en todo lo que necesite.</p>';
    $m .= '<p>Esperamos contar con su confianza y colaboración. Agradecemos su atención a este asunto y esperamos tener la oportunidad de servirle en un futuro cercano.</p>';
    $m .= '<p>Atentamente,</p>';

    $f  = '<br><table><tr><td style="width:200px;">';
    $f .= "<img src=\"cid:logo\" style=\"width:170px;\">";
    $f .= '</td><td style="width:400px;font-size:11px;">';
    $f .= '<b>' . $perfil->cargo . '</b><br>';
    $f .= 'Tel. ' . $perfil->linea . ' Anexo ' . $perfil->anexo . '<br/>';
    $f .= 'Mail: ' . $perfil->correo . '<br/>';
    $f .= '</td></tr></table>';

    $archivo = gs(config('constants.ruta_storage') . $cotizacion->documento()->archivo);
    
    if(!empty($perfil->logo)) {
      $archivo_logo = gs(config('constants.ruta_storage') . $perfil->logo);
    }
    $graph = new Graph();
    $graph->setAccessToken($perfil->ex_access_token);

    $replyMessage = array(
    "message" => array(
    "from" => array(
        "emailAddress" => array(
          "address" => $perfil->correo,
        )
    ),
    "toRecipients" => array(
      array(
        "emailAddress" => array(
          "address" => $cotizacion->oportunidad()->correo()->correo_desde,
        )
      )
    ),
    "subject" => "RE: " . $perfil->correo_asunto,
    "body" => array(
      "contentType" => "html",
      "content" => $m . $f,
    ),
    "attachments" => array(
      array(
        "@odata.type" => "#microsoft.graph.fileAttachment",
        "name" => $cotizacion->codigo() . '.pdf',
        "contentBytes" => base64_encode(file_get_contents($archivo))
      )
    )
  ),
    "saveToSentItems" => true
  );
    if(!empty($archivo_logo)) {
      $replyMessage['message']['attachments'][] = array(
        "@odata.type" => "#microsoft.graph.fileAttachment",
        "name" => "logo.png",
        "contentBytes" => base64_encode(file_get_contents($archivo_logo)),
        "isInline" => true,
        "contentId" => "logo"
      );
    }
  try {
     $response = $graph->createRequest('POST', '/users/' . $perfil->ex_user_id . '/messages/' . $perfil->correo_cid . '/reply')
      ->attachBody($replyMessage)
      ->execute();
  } catch (ClientException | ServerException $err) {
    $response = false;
  }

  if(!$response) {
    try {
      $response = $graph->createRequest('POST', '/users/' . $perfil->ex_user_id . '/sendMail')
        ->attachBody($replyMessage)
        ->execute();
    } catch (ClientException | ServerException $err) {
      $response = false;
    }
  }

  if(!empty($response)) {
    $cotizacion->registrar_propuesta();
    $cotizacion->log('CORREO', 'Se ha enviado la propuesta por Correo a ' . $cotizacion->oportunidad()->correo()->correo_desde);
  }

  if($request->ajax()) {
      return response()->json([
        'status'   => !empty($response),
        'refresh'  => false,
        'disabled' => true,
        'label'    => !empty($response) ? 'Correo enviado correctamente!' : 'No fue posible enviar el correo.',
      ]);
  }
    return redirect()->route('oportunidades.show', ['oportunidad' => $cotizacion->oportunidad_id]);
  }

  public function detalleSave( Request $request , $id){
    $oportunidad = $request->all();
    $cotizacion = Cotizacion::find($id);
    $cotizacion->monto = $oportunidad['cotizacion']['monto']; 
    $cotizacion->save();
    
    $detalle = $oportunidad['detalle']; 
    foreach($detalle as $key =>  $producto) {
      if ( !empty( $producto['id'] )){
        $cot = CotizacionDetalle::find($producto['id']);
        $cot->update($producto);
      } else {
        $prod = [
          'producto_id'=> $producto['producto_id'] ,
          'monto'      => $producto['monto'] ,
          'cantidad'   => $producto['cantidad'] ,
          'cotizacion_id'=> $producto['cotizacion_id'],
        ];
        CotizacionDetalle::create($prod);
      }
    }
    return response()->json( [ 'status' => true ]);
  } 

  public function registrar( Request $request, Cotizacion $cotizacion) {
    return view('cotizacion.registrar', compact('cotizacion'));
  }

  public function registrar_store(Request $request, Cotizacion $cotizacion) {
    $data  = $request->input();
    $items = $request->input('item');
    $cotizacion->saveItems($items, $cotizacion->empresa_id);
    $cotizacion->update($data);
    return response()->json([
      'status'  => true,
      'message' => 'Se ha registrado correctamente.',
    ]);
  }

  public function exportar_repositorio(Request $request, Cotizacion $cotizacion) {
    $empresa = $cotizacion->empresa();
    $pdf = Helper::pdf('cotizacion.pdf', compact('cotizacion','empresa'), 'P');
    $temporal = gs_file('pdf');
    $filename = 'COT-' . $cotizacion->codigo() . '-' . date('H') . '.pdf';
    $destino  = 'tenant-' . Auth::user()->tenant_id . '/' . $temporal;
    $pdf->save($temporal);

    $meta = Helper::metadata($temporal);

    $documento = Documento::where('filename', '=', $filename)->first();
    if(!empty($documento)) {
      $documento->update([
        'folio'          => $meta['Pages'],
        'rotulo'         => $cotizacion->codigo(),
        'filename'       => $filename,
        'filesize'       => filesize($temporal),
        'cotizacion_id'  => $cotizacion->id,
        'oportunidad_id' => $cotizacion->oportunidad_id,
        'licitacion_id'  => $cotizacion->oportunidad()->licitacion_id,
      ]);
      Helper::gsutil_mv($temporal, config('constants.ruta_storage') . $documento->archivo, false);
    } else {
      Documento::nuevo([
        'formato'        => 'PDF',
        'tipo'           => 'COTIZACION',
        'directorio'     => trim($cotizacion->folder(true), '/'),
        'archivo'        => $destino, 
        'folio'          => $meta['Pages'],
        'rotulo'         => $cotizacion->codigo(),
        'filename'       => $filename,
        'filesize'       => filesize($temporal),
        'cotizacion_id'  => $cotizacion->id,
        'oportunidad_id' => $cotizacion->oportunidad_id,
        'licitacion_id'  => $cotizacion->oportunidad()->licitacion_id,
      ]);
      Helper::gsutil_mv($temporal, config('constants.ruta_storage') . $destino, false);
    }
    return response()->json([
      'status'  => true,
      'message' => 'Se ha exportado correctamente.',
      'from'    => $temporal,
    ]);
  }
}
