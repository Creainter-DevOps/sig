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
      $listado = Cotizacion::search($search)->paginate(15)->appends(request()->query());
    } else {
      $listado = Cotizacion::visible()->orderBy('id', 'desc')->paginate(15)->appends(request()->query());
    }
    return view('cotizacion.index', ['listado' => $listado]);
  }

  public function show(Request $resquest, Cotizacion $cotizacion){
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
    if(!empty($_GET['oportunidad_id'])) {
      $cotizacion->oportunidad_id = $_GET['oportunidad_id'];
    }
    return view($request->ajax() ? 'cotizacion.fast' : 'cotizacion.create', compact('cotizacion'));
  }

  public function store(Request $request){
    $cotizacion = Cotizacion::create($request->all());
    //    $cotizacion->log("creado", null );
    return response()->json(['status' => true , 'refresh' => true ]);
    return back();
    return response()->json([
        'status' => true,
        'redirect' => '/cotizaciones'
      ]); 
  }

  public function edit(Request $request, Cotizacion $cotizacion) {
    return view($request->ajax() ? 'cotizacion.fast_edit' : 'cotizacion.edit', compact('cotizacion'));    
  }

  public function update( Request  $request  , Cotizacion $cotizacion){
    $cotizacion->update($request->all());    
    return response()->json(['status' => true , 'refresh' => true ]);
    return response()->json([ 
        'status' => true , 
        'redirect' => '/cotizaciones']);
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
    $proyecto = new Proyecto;
    $proyecto->cotizacion_id = $cotizacion->id;
    $proyecto->empresa_id = $cotizacion->empresa_id;
    $proyecto->nombre = $cotizacion->oportunidad()->rotulo();
    $proyecto->tipo = 'LICITACION';
    $proyecto->nomenclatura = $cotizacion->oportunidad()->licitacion()->nomenclatura;
    $proyecto->save();
    return redirect()->route( 'proyectos.show', [ 'proyecto' => $proyecto->id ]);
  }
}
