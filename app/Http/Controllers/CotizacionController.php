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
    $this->viewBag = $listado;
    return view('cotizacion.index', $this->viewBag );
  }

  public function show(Request $resquest, Cotizacion $cotizacion) {
    $cotizacion->codigo = '';
    $cliente  = isset( $cotizacion->cliente_id ) ? $cotizacion->cliente() : null;
    $timeline = $cotizacion->timeline();
    $contacto = isset($cotizacion->contacto_id) ? $cotizacion->contacto() : null; 
    return view ('cotizacion.show', compact('cotizacion', 'listado', 'breadcrumbs', 'cliente', 'timeline','contacto' )); 
  }
  public function enviar(Cotizacion $cotizacion, Request $request){
    $cotizacion->registrar_propuesta();
    if($request->ajax()) {
      return response()->json(['status' => true , 'refresh' => true ]);
    }
    return redirect()->route('oportunidades.show', [ 'oportunidad' => $cotizacion->oportunidad_id ]);
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
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
    $cotizacion->update($data);
    return response()->json(['status' => true , 'refresh' => true ]);
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
    return redirect()->route( 'proyectos.show', [ 'proyecto' => $id ]);
  }
  public function exportar(Request $request, Cotizacion $cotizacion) {
    $empresa = $cotizacion->empresa();
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
    $cotizacion->registrar_participacion();
    return redirect('/oportunidades/' . $cotizacion->oportunidad_id . '/');
  }
  public function registrarPropuesta(Request $request, Cotizacion $cotizacion) {
    $cotizacion->registrar_propuesta();
    return redirect('/oportunidades/' . $cotizacion->oportunidad_id . '/');
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
  public function registrar(Request $request, Cotizacion $cotizacion) {
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
      Helper::gsutil_mv($temporal, config('constants.ruta_storage') . $documento->archivo);
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
      Helper::gsutil_mv($temporal, config('constants.ruta_storage') . $destino);
    }
    return response()->json([
      'status'  => true,
      'message' => 'Se ha exportado correctamente.',
      'from'    => $temporal,
    ]);
  }
}
