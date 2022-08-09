<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Correo;
class CorreoController extends Controller {

  protected $viewBag = [];
  public function __construct(){
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/correos", "name" => "Correos" ]
    ];
  }
   
  public function index(Request $request) {
    $search = $request->input('search');
    if(!empty($search)){
      $listado = Correo::search($search)->paginate(15)->appends(request()->query());
    } else {
      $listado = Correo::where('eliminado', false )->orderBy( 'id', 'desc')->paginate(15)->appends(request()->query());
    }
    $this->viewBag['listado'] = $listado;
    return view('correos.index', $this->viewBag);
  }

  public function ver(Request $request, Correo $correo ) {
     return view( 'correo.ver', compact('correo'));
  }
  
  public function create(Request $request, Correo $correo) {
    $this->viewBag['correo'] = new Correo(); 
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Nuevo Correo" ];
    if($request->ajax()) {
      return view( 'correos.fast', [ 'correo' => $correo ]);
    }
    return view('correos.add', $this->viewBag );
  }
  
  public function store(Request $request,Correo  $correo ) {
    $data = $request->all();
    if(!empty($data['empresa_id'])) {
      $cliente = Cliente::porEmpresaForce($data['empresa_id']);
      $data['cliente_id'] = $cliente->id;
    }
    $correo->fill($data);
    $correo->save();
    $correo->log( 'creado');
    return response()->json([ 
      'status' => "success",
      'data' => [
        "value" => $correo->nombres . " " . $correo->apellidos,
        "id" => $correo->id 
      ],
      'redirect' => '/correos'
    ]);
  }

  public function edit(Request $request, Correo $correo) {
    $this->viewBag['correo'] = $correo;
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Editar Correo" ]; 
    return view('correos.edit',$this->viewBag );    
  }

  public function update( Request $request,Correo  $correo  ) {
    $correo->update($request->all());
    #$correo->log('editado');
    return response()->json([ 
      'status' => true,
      'redirect' => '/correos',
    ]);
  }

  public  function destroy(Correo $correo  ){
    $correo->eliminado = true;
    $correo->save();
    $correo->log('eliminado');    
    return response()->json(['status'=> true , 'refresh' => true  ]); 
  }

  public function autocomplete(Request $request) {
    $term = $request->input('query');
    $data = Correo::search($term)->selectRaw(" correo.id, concat_ws(' ',correo.nombres, correo.apellidos) as value")->get();
    return response()->json($data);
  }
  public function observacion(Request $request, Correo $correo) {
    $correo->log('texto',$request->input('texto'));
    return back();
  }
  public function fast( Correo $correo ){
    return view( 'correos.fast', [ 'correo' => $correo ]); 
  }

}
