<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;
use App\Cotizacion;
use App\Proyecto;

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
    return view('cotizacion.index', ['listado' => $listado]);
  }

  public function show(Request $resquest, Cotizacion $cotizacion) {
    $cotizacion->codigo = '';
    $breadcrumbs[] = [ 'name' => "Detalle Cotizacion" ];
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
    return view($request->ajax() ? 'cotizacion.fast' : 'cotizacion.create', compact('cotizacion'));
  }

  public function store(Request $request){
    $cotizacion = Cotizacion::create($request->all());
    //    $cotizacion->log("creado", null );
    if($request->ajax()) {
      return response()->json(['status' => true , 'refresh' => true ]);
    } else {
      return redirect()->route('cotizaciones.show', [ 'cotizacion' => $cotizacion->id ]);
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

  public function update( Request  $request, Cotizacion $cotizacion) {
    $data = $request->all();
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
    $cotizacion->update($data);
    return response()->json(['status' => true , 'refresh' => true ]);
  }
  public  function destroy( Cotizacion $cotizacion ){
    $cotizacion->eliminado = true;
    $cotizacion->save();
    $cotizacion->log("eliminado",null);
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
}
