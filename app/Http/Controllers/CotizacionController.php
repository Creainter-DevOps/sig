<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;
use App\Cotizacion;
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
      $listado = Cotizacion::whereNull('eliminado')->search($search)->paginate(15)->appends(request()->query());
    } else {
      $listado = Cotizacion::where( 'eliminado', false )->orderBy('id', 'desc')->paginate(15)->appends(request()->query());
    }
    return view('cotizacion.index', ['listado' => $listado]);
  }

  public function show(Request $resquest, Cotizacion $cotizacion){
    $breadcrumbs[] = [ 'name' => "Detalle Cotizacion" ];
    $cliente  = isset( $cotizacion->cliente_id ) ? $cotizacion->cliente() : null;
//    $listado  = $cotizacion->cliente()->getContactos();
    $timeline = $cotizacion->timeline();
    $contacto = isset($cotizacion->contacto_id) ? $cotizacion->contacto() : null; 
    return view ('cotizacion.show', compact('cotizacion', 'listado', 'breadcrumbs', 'cliente', 'timeline','contacto' )); 
  }

  public function create() {
    $this->viewBag['cotizacion']  = new Cotizacion();
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Nueva Cotizacion" ];
    return view('cotizacion.create', $this->viewBag );
  }

  public function store( Request $request, Cotizacion $cotizacion ){
    $cotizacion->fill($request->all());
    $cotizacion->empresa_id  = $request->cliente_id;
    $cotizacion->codigo =  Cotizacion::generarCodigo();
    $cotizacion->save(); 
    $cotizacion->log("creado", null );
    return response()->json([
        'status' => true,
        'redirect' => '/cotizaciones'
      ]); 
  }

  public function edit( Cotizacion $cotizacion ) {
    $this->viewBag['cotizacion'] = $cotizacion; 
    $this->viewBag['breadcrumbs'][] = [ 'name' => "Editar" ];   
    return view('cotizacion.edit',$this->viewBag );    
  }

  public  function destroy( Cotizacion $cotizacion ){
    $cotizacion->eliminado = true;
    $cotizacion->save();
    $cotizacion->log("eliminado",null);
    return response()->json(['status'=> true , 'refresh' => true ]); 
  }

  public function update( Request  $request  , Cotizacion $cotizacion){
    $cotizacion->update($request->all());    
    $cotizacion->log("editado", null );
    return response()->json([ 
        'status' => true , 
        'redirect' => '/cotizaciones']);
  }
  public function autocomplete(Request $request ){
    $query = $request->input("query");
    $data = Cotizacion::search($query)->selectRaw(" cotizacion.id, CONCAT_WS(':' , cotizacion.codigo, cotizacion.descripcion ) as value ")->get() ; 
    return Response()->json($data); 
  }
  public function observacion(Request $request, Cotizacion $cotizacion ) {
    $cotizacion->log('texto',$request->input('texto'));
    return back();
  } 
}
